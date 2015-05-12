<?php
namespace App\Repositories;

use App\Repositories\Contracts\MapsRepositoryInterface;
use App\Map;

class MapsRepository extends AbstractRepository implements MapsRepositoryInterface {

    public function __construct(Map $map)
    {
        parent::__construct($map);
    }

}