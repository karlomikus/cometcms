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

    /**
     * Get final score of a match
     *
     * @param $matchID
     * @return array
     */
    public function getMatchScore($matchID);

    /**
     * Get match result in a string format
     *
     * @param $matchID
     * @return string Either a win, lose or draw
     */
    public function getMatchOutcome($matchID);

}