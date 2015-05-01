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

    public function getMatchResult($matchID)
    {
        $matchRounds = $this->getMatchRounds($matchID);

        return $matchRounds[0]->scores;
    }

}