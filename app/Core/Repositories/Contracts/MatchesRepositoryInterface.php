<?php
namespace Comet\Core\Repositories\Contracts;

interface MatchesRepositoryInterface {

    /**
     * Get match round data
     *
     * @param $matchID
     * @return mixed
     */
    public function getMatchRounds($matchID);

    /**
     * Render JSON for use in viewmodels
     * 
     * @param  int $matchID Match ID
     * @return mixed
     */
    public function getMatchJson($matchID);

    /**
     * Deletes all rounds and it's scores for a given match ID
     * 
     * @param  int $matchID Match ID
     * @return void
     */
    public function deleteRoundsAndScores($matchID);

}