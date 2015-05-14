<?php
namespace App\Repositories;

use App\Opponent;
use App\Repositories\Contracts\OpponentsRepositoryInterface;
use App\Libraries\GridView\GridViewInterface;

class OpponentsRepository extends AbstractRepository implements OpponentsRepositoryInterface, GridViewInterface {

    public function __construct(Opponent $opponent)
    {
        parent::__construct($opponent);
    }

    public function getByPageGrid($page, $limit, $sortColumn, $order, $searchTerm = null)
    {
        $sortColumn !== null ?: $sortColumn = 'name'; // Default order by column
        $order !== null ?: $order = 'asc'; // Default sorting

        $model = $this->model->orderBy($sortColumn, $order);

        if($searchTerm)
            $model->where('name', 'LIKE', '%'. $searchTerm .'%');

        $result['count'] = $model->count();
        $result['items'] = $model->skip($limit * ($page - 1))->take($limit)->get();

        return $result;
    }

} 