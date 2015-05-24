<?php
namespace App\Services;

use App\Repositories\Contracts\GamesRepositoryInterface;
use App\Repositories\Contracts\MatchesRepositoryInterface;
use App\Repositories\Contracts\OpponentsRepositoryInterface;
use App\Repositories\Contracts\TeamsRepositoryInterface;

class MatchService {

    protected $matches;
    protected $teams;
    protected $opponents;
    protected $games;
    protected $rounds;
    protected $scores;

    public function __construct(MatchesRepositoryInterface $matches, TeamsRepositoryInterface $teams, OpponentsRepositoryInterface $opponents, GamesRepositoryInterface $games)
    {

    }

}