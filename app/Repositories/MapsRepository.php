<?php
namespace App\Repositories;

use App\Libraries\GridView\GridViewInterface;
use App\Repositories\Contracts\MapsRepositoryInterface;
use App\Map;

class MapsRepository extends AbstractRepository implements MapsRepositoryInterface, GridViewInterface {

    public function __construct(Map $map)
    {
        parent::__construct($map);
    }

    public function getByPageGrid($page, $limit, $sortColumn, $order, $searchTerm = null)
    {
        $model = $this->model->orderBy($sortColumn, $order);

        if($searchTerm)
            $model->where('name', 'LIKE', '%'. $searchTerm .'%');

        $result['count'] = $model->count();
        $result['items'] = $model->skip($limit * ($page - 1))->take($limit)->get();

        return $result;
    }
}