<?php
namespace App\Repositories\Contracts;

interface MatchesRepositoryInterface {

    public function getMatchRounds($matchID);
    public function getMatchResult($matchID);

}