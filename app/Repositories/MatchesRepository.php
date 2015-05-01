<?php
namespace App\Repositories;

use App\Match, App\Repositories\Contracts\MatchesRepositoryInterface;

class MatchesRepository extends AbstractRepository implements MatchesRepositoryInterface {

    public function __construct(Match $match)
    {
        parent::__construct($match);
    }

    public function getMatchRounds($matchID)
    {
        return $this->get($matchID)->rounds;
    }

    public function getMatchScore($matchID)
    {
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

}