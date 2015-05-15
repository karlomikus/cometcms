<?php
namespace App\Repositories;

use App\Match, App\Repositories\Contracts\MatchesRepositoryInterface, App\Libraries\GridView\GridViewInterface;

class MatchesRepository extends AbstractRepository implements MatchesRepositoryInterface, GridViewInterface {

    public function __construct(Match $match)
    {
        parent::__construct($match);
    }

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
                 sum(round_scores.score_home) as 'score_home', sum(round_scores.score_guest) as 'score_guest', matches.created_at"))
                ->groupBy('matches.id');

        return $query->get();
    }

    public function getMatchRounds($matchID)
    {
        return $this->get($matchID)->rounds;
    }

    public function getMatchScore($matchID)
    {
        // TODO: Remove these score methods from interface, they are now in App\Match model
        $result = \DB::table('round_scores')
                ->join('match_rounds', 'round_scores.round_id', '=', 'match_rounds.id')
                ->select(\DB::raw('sum(score_home) as home, sum(score_guest) as guest'))
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

    public function getByPageGrid($page, $limit, $sortColumn, $order, $searchTerm = null)
    {
        $sortColumn !== null ?: $sortColumn = 'created_at'; // Default order by column
        $order !== null ?: $order = 'asc'; // Default sorting

        $model = $this->model
            ->join('teams', 'teams.id', '=', 'matches.team_id')
            ->join('opponents', 'opponents.id', '=', 'matches.opponent_id')
            ->join('games', 'games.id', '=', 'matches.game_id')
            ->select('matches.*');

        if($searchTerm)
            $model->where('opponents.name', 'LIKE', '%'. $searchTerm .'%')
                ->orWhere('teams.name', 'LIKE', '%'. $searchTerm .'%')
                ->orWhere('games.name', 'LIKE', '%'. $searchTerm .'%');

        $result['count'] = $model->count();
        $result['items'] = $model->orderBy($sortColumn, $order)->with('team', 'opponent', 'game')->skip($limit * ($page - 1))->take($limit)->get();

        return $result;
    }

}