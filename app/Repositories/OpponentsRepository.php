<?php
namespace App\Repositories;

use App\Opponent;
use App\Repositories\Contracts\OpponentsRepositoryInterface;

class OpponentsRepository extends AbstractRepository implements OpponentsRepositoryInterface {

    public function __construct(Opponent $opponent)
    {
        parent::__construct($opponent);
    }

} 