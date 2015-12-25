<?php
namespace Comet\Repositories;

use Comet\Core\Models\Match, Comet\Repositories\Contracts\MatchesRepositoryInterface, Comet\Libraries\GridView\GridViewInterface;
use Comet\Core\Models\MatchRounds;
use Comet\Core\Models\RoundScores;
use Carbon\Carbon;

/**
 * Matches repository
 *
 * @package Comet\Repositories
 */
class MatchesRepository extends AbstractRepository implements MatchesRepositoryInterface, GridViewInterface {

    /**
     * Rounds (games) model instance
     *
     * @var MatchRounds
     */
    protected $rounds;

    /**
     * Scores model instance
     *
     * @var RoundScores
     */
    protected $scores;

    /**
     * Initiate the repository with given models. We also need rounds and scores models
     * since the match is dependent on them, but they don't need a sepearete repository.
     *
     * @param $match Match Match model
     * @param $rounds MatchRounds Rounds model
     * @param $scores RoundScores Scores model
     */
    public function __construct(Match $match, MatchRounds $rounds, RoundScores $scores)
    {
        parent::__construct($match);

        $this->rounds = $rounds;
        $this->scores = $scores;
    }

    /**
     * Gets rounds model from specified match ID
     *
     * @param $matchID int ID of the match
     * @return mixed Rounds model
     */
    public function getMatchRounds($matchID)
    {
        return $this->get($matchID)->rounds;
    }

    /**
     * Render JSON for use in knockout
     *
     * @param  int $matchID Match ID
     * @return mixed
     */
    public function getMatchJson($matchID)
    {
        $model = $this->model->where('id', '=', $matchID);

        return $model->with('team', 'opponent', 'game', 'rounds', 'rounds.scores')->first();
    }

    /**
     * Prepare paged data for the grid view
     *
     * @param $page int Current page
     * @param $limit int Page results limit
     * @param $sortColumn string Column name
     * @param $order string Order type
     * @param $searchTerm string Search term
     * @param $trash bool Get only trashed items
     * @return array
     */
    public function getByPageGrid($page, $limit, $sortColumn, $order, $searchTerm = null, $trash = false)
    {
        $sortColumn = (!$sortColumn) ? 'date' : $sortColumn;
        $order = (!$order) ? 'asc' : $order;

        $model = $this->model
            ->join('teams', 'teams.id', '=', 'matches.team_id')
            ->join('opponents', 'opponents.id', '=', 'matches.opponent_id')
            ->join('games', 'games.id', '=', 'matches.game_id')
            ->join('match_rounds', 'match_rounds.match_id', '=', 'matches.id')
            ->join('round_scores', 'round_scores.round_id', '=', 'match_rounds.id')
            ->select('matches.*', \DB::raw('sum(round_scores.home) as home_score, sum(round_scores.guest) as guest_score'))
            ->groupBy('matches.id');

        if ($trash)
            $model->onlyTrashed();

        if ($searchTerm)
            $model->where('opponents.name', 'LIKE', '%' . $searchTerm . '%')
                ->orWhere('teams.name', 'LIKE', '%' . $searchTerm . '%')
                ->orWhere('games.name', 'LIKE', '%' . $searchTerm . '%');

        $model->orderBy($sortColumn, $order)->with('team', 'opponent', 'game');
        $result['count'] = $this->model->count();
        $result['items'] = $model->skip($limit * ($page - 1))->take($limit)->get();

        return $result;
    }

    /**
     * Returns all matches with match ID, date and final scores for home and guest teams
     *
     * @return mixed
     */
    public function getMatchesScores()
    {
        $model = $this->model
            ->join('match_rounds', 'match_rounds.match_id', '=', 'matches.id')
            ->join('round_scores', 'round_scores.round_id', '=', 'match_rounds.id')
            ->select('matches.id', \DB::raw('sum(round_scores.home) as home, sum(round_scores.guest) as guest'), 'matches.date')
            ->groupBy('matches.id');

        return $model->get();
    }

    /**
     * Gets data from JSON request and inserts match, round and scores into database
     *
     * @param  array $data Array of data
     * @return bool       Insert successful
     */
    public function insert($data)
    {
        try {
            \DB::beginTransaction();

            // Insert tab delimited opponent team participants
            $opponentParticipants = null;
            if (isset($data['guest_team'])) {
                $opponentParticipants = implode("\t", $data['guest_team']);
            }

            // Parse date
            $matchDate = Carbon::parse($data['match_date'])->toDateTimeString();

            // Create a new match
            $matchModel = $this->model->create([
                'team_id'               => $data['team_id'],
                'opponent_id'           => $data['opponent_id'],
                'game_id'               => $data['game_id'],
                'matchlink'             => isset($data['matchlink']) ? $data['matchlink'] : null,
                'opponent_participants' => $opponentParticipants,
                'date'                  => $matchDate
            ]);

            // Create match rounds
            foreach ($data['rounds'] as $round) {
                $roundModel = $this->rounds->create([
                    'match_id' => $matchModel['id'],
                    'map_id'   => $round['map_id'],
                    'notes'    => isset($round['notes']) ? $round['notes'] : null,
                ]);

                // Create round scores
                foreach ($round['scores'] as $score) {
                    $this->scores->create([
                        'round_id' => $roundModel['id'],
                        'home'     => $score['home'],
                        'guest'    => $score['guest']
                    ]);
                }
            }

            // Insert team participants
            $teamParticipants = $data['home_team'];
            foreach ($teamParticipants as $participant) {
                if ($participant['active'] == 1) {
                    \DB::table('match_participants')->insert([
                        'match_id'  => $matchModel['id'],
                        'roster_id' => $participant['roster_id']
                    ]);
                }
            }
        }
        catch (\Exception $e) {
            \DB::rollback();

            dd($e->getMessage());

            return false;
        }
        \DB::commit();

        return true;
    }

    /**
     * Deletes all rounds and it's scores for a given match ID
     *
     * @param  int $matchID Match ID
     * @return void
     */
    public function deleteRoundsAndScores($matchID)
    {
        $rounds = $this->getMatchRounds($matchID);
        foreach ($rounds as $round) {
            foreach ($round->scores as $score) {
                $score->delete();
            }
            $round->delete();
        }
    }

    /**
     * Update match on edit. Deletes old scores and rounds before inserting new ones
     *
     * @param  int $id Match ID
     * @param  array $data Data to insert
     * @return mixed
     */
    public function update($id, $data)
    {
        try {
            \DB::beginTransaction();

            $match = $this->model->find($id);

            // Insert tab delimited opponent team participants
            $opponentParticipants = null;
            if (isset($data['guest_team'])) {
                $opponentParticipants = implode("\t", $data['guest_team']);
            }

            // Parse date
            $matchDate = Carbon::parse($data['match_date'])->toDateTimeString();

            $match->team_id = $data['team_id'];
            $match->opponent_id = $data['opponent_id'];
            $match->game_id = $data['game_id'];
            $match->matchlink = isset($data['matchlink']) ? $data['matchlink'] : null;
            $match->date = $matchDate;
            $match->opponent_participants = $opponentParticipants;

            $match->save();

            // Delete old records
            $this->deleteRoundsAndScores($id);

            // Create match rounds
            foreach ($data['rounds'] as $round) {
                $roundModel = $this->rounds->create([
                    'match_id' => $match->id,
                    'map_id'   => $round['map_id'],
                    'notes'    => isset($round['notes']) ? $round['notes'] : null,
                ]);

                // Create round scores
                foreach ($round['scores'] as $score) {
                    $this->scores->create([
                        'round_id' => $roundModel['id'],
                        'home'     => $score['home'],
                        'guest'    => $score['guest']
                    ]);
                }
            }

            // Insert team participants
            \DB::table('match_participants')->where('match_id', '=', $match->id)->delete();
            $teamParticipants = $data['home_team'];
            foreach ($teamParticipants as $participant) {
                if ($participant['active'] == 1) {
                    \DB::table('match_participants')->insert([
                        'match_id'  => $match->id,
                        'roster_id' => $participant['roster_id']
                    ]);
                }
            }
        }
        catch (\Exception $e) {
            \DB::rollback();

            return false;
        }

        \DB::commit();

        return true;
    }

    public function getUpcomingMatches()
    {
        $date = Carbon::now()->toDateTimeString();
        return $this->model->where('date', '>', $date)->orderBy('date')->get();
    }

    public function getMatchesByYearMonth($year, $month)
    {
        return $this->model
            ->where('YEAR(date)', $year)
            ->where('MONTH(date)', $month)
            ->orderBy('date')
            ->get();
    }

    public function yearlyReport($year)
    {
        return $this->model
            ->whereRaw('YEAR(date) = ?', [$year])
            ->select(\DB::raw('COUNT(*) as matches, MONTH(date) as month'))
            ->groupBy('month')
            ->get();
    }

}