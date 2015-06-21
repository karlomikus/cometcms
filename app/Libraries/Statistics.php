<?php
namespace App\Libraries;


use App\Match;

final class Statistics {

    private $match;

    public function __construct(Match $match)
    {
        $this->match = $match;
    }

    public function getMatchesResults()
    {
        $this->match->where()->get();
        return ['won'];
    }

}