<?php
namespace App\Repositories;

use App\Match, App\Repositories\Contracts\MatchesRepositoryInterface;

class MatchesRepository extends AbstractRepository implements MatchesRepositoryInterface {

    public function __construct()
    {
        parent::__construct(new Match());
    }

    public function getMatchRounds($matchID)
    {
        return $this-> get($matchID)->rounds;
    }

    public function getMatchResult($matchID)
    {
        $matchRounds = $this->getMatchRounds($matchID);

        return $matchRounds[0]->scores;
    }

}