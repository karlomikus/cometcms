<?php
namespace App\Repositories;

use App\Game;
use App\Repositories\Contracts\GamesRepositoryInterface;

class GamesRepository extends AbstractRepository implements GamesRepositoryInterface {

    public function __construct(Game $game)
    {
        parent::__construct($game);
    }

    public function allWithMaps()
    {
        return $this->model->with('maps')->get();
    }

} 