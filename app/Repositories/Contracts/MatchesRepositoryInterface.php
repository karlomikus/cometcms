<?php
namespace App\Repositories\Contracts;

interface MatchesRepositoryInterface {

    /**
     * Get match round data
     *
     * @param $matchID
     * @return mixed
     */
    public function getMatchRounds($matchID);

}