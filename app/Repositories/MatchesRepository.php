<?php
namespace App\Repositories;

use App\Match, App\Repositories\Contracts\MatchesRepositoryInterface, App\Libraries\GridView\GridViewInterface;
use App\MatchRounds;
use App\RoundScores;

class MatchesRepository extends AbstractRepository implements MatchesRepositoryInterface, GridViewInterface {

    protected $rounds;
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
     * Custom query for all matches
     * 
     * @return mixed
     */
    public function all()
    {
        // TODO: Fix rounds counting!
        $query = \DB::table('matches')
            ->join('teams', 'teams.id', '=', 'matches.team_id')
            ->join('opponents', 'opponents.id', '=', 'matches.opponent_id')
            ->join('games', 'games.id', '=', 'matches.game_id')
            ->join('match_rounds', 'match_rounds.match_id', '=', 'matches.id')
            ->join('round_scores', 'round_scores.round_id', '=', 'match_rounds.id')
            ->select(\DB::raw("matches.id, teams.name as team, opponents.name as opponent,
                 games.name as game, count(match_rounds.match_id) as 'rounds',
                 sum(round_scores.home) as 'score_home', sum(round_scores.guest) as 'score_guest', matches.created_at"))
            ->groupBy('matches.id');

        return $query->get();
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

    public function getMatchScore($matchID)
    {
        // TODO: Remove these score methods from interface, they are now in App\Match model
        $result = \DB::table('round_scores')
            ->join('match_rounds', 'round_scores.round_id', '=', 'match_rounds.id')
            ->select(\DB::raw('sum(home) as home, sum(guest) as guest'))
            ->where('match_id', '=', $matchID)
            ->first();

        return $result;
    }

    public function getMatchOutcome($matchID)
    {
        $score = $this->getMatchScore($matchID);

        if ($score->home > $score->guest)
            return 'win';
        elseif ($score->home < $score->guest)
            return 'lose';

        return 'draw';
    }

    public function getMatchJson($matchID)
    {
        $model = $this->model->where('id', '=', $matchID);

        return $model->with('team', 'opponent', 'game', 'rounds', 'rounds.scores')->first();
    }

    public function getByPageGrid($page, $limit, $sortColumn, $order, $searchTerm = null)
    {
        $sortColumn !== null ?: $sortColumn = 'created_at'; // Default order by column
        $order !== null ?: $order = 'asc'; // Default sorting

        $model = $this->model
            ->join('teams', 'teams.id', '=', 'matches.team_id')
            ->join('opponents', 'opponents.id', '=', 'matches.opponent_id')
            ->join('games', 'games.id', '=', 'matches.game_id')
            ->select('matches.*');

        if ($searchTerm)
            $model->where('opponents.name', 'LIKE', '%' . $searchTerm . '%')
                ->orWhere('teams.name', 'LIKE', '%' . $searchTerm . '%')
                ->orWhere('games.name', 'LIKE', '%' . $searchTerm . '%');

        $result['count'] = $model->count();
        $result['items'] = $model->orderBy($sortColumn, $order)->with('team', 'opponent', 'game')->skip($limit * ($page - 1))->take($limit)->get();

        return $result;
    }

    public function insert($data)
    {
        try {
            \DB::beginTransaction();

            // Insert tab delimited opponent team participants
            $opponentParticipants = null;
            if(isset($data['guest_team'])) {
                $opponentParticipants = implode("\t", $data['guest_team']);
            }

            // Create a new match
            $matchModel = $this->model->create([
                'team_id' => $data['team_id'],
                'opponent_id' => $data['opponent_id'],
                'game_id' => $data['game_id'],
                'matchlink' => isset($data['matchlink']) ?: null,
                'opponent_participants' => $opponentParticipants
            ]);

            // Create match rounds
            foreach ($data['rounds'] as $round) {
                $roundModel = $this->rounds->create([
                    'match_id' => $matchModel['id'],
                    'map_id' => $round['map_id'],
                    'notes' => isset($round['notes']) ? $round['notes'] : null,
                ]);

                // Create round scores
                foreach ($round['scores'] as $score) {
                    $this->scores->create([
                        'round_id' => $roundModel['id'],
                        'home' => $score['home'],
                        'guest' => $score['guest']
                    ]);
                }
            }

            // Insert team participants
            $teamParticipants = $data['home_team'];
            foreach ($teamParticipants as $participant) {
                if ($participant['active'] == 1) {
                    \DB::table('match_participants')->insert([
                        'match_id' => $matchModel['id'],
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
     * Update match on edit
     * 
     * @param  int   $id    Match ID
     * @param  array $data  Data to insert
     * @return mixed
     */
    public function update($id, $data)
    {
        try {
            \DB::beginTransaction();

            $match = $this->model->find($id);

            // Insert tab delimited opponent team participants
            $opponentParticipants = null;
            if(isset($data['guest_team'])) {
                $opponentParticipants = implode("\t", $data['guest_team']);
            }

            $match->team_id = $data['team_id'];
            $match->opponent_id = $data['opponent_id'];
            $match->game_id = $data['game_id'];
            $match->matchlink = isset($data['matchlink']) ?: null;
            $match->opponent_participants = $opponentParticipants;

            $match->save();

            // Delete old records
            $scores = $this->model->rounds;
            dd($scores);
            $rounds->scores()->delete();
            // $rounds->delete();

            // Create match rounds
            foreach ($data['rounds'] as $round) {
                $roundModel = $this->rounds->create([
                    'match_id' => $match->id,
                    'map_id' => $round['map_id'],
                    'notes' => isset($round['notes']) ? $round['notes'] : null,
                ]);

                // Create round scores
                foreach ($round['scores'] as $score) {
                    $this->scores->create([
                        'round_id' => $roundModel['id'],
                        'home' => $score['home'],
                        'guest' => $score['guest']
                    ]);
                }
            }

            // Insert team participants
            \DB::table('match_participants')->where('match_id', '=', $match->id)->delete();
            $teamParticipants = $data['home_team'];
            foreach ($teamParticipants as $participant) {
                if ($participant['active'] == 1) {
                    \DB::table('match_participants')->insert([
                        'match_id' => $match->id,
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

        throw new \Exception("Error Processing Request", 1);
        
        \DB::commit();

        return true;
    }

}