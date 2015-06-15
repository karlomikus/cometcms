<?php
namespace App\Repositories;

use App\Game;
use App\Libraries\GridView\GridViewInterface;
use App\Repositories\Contracts\GamesRepositoryInterface;

class GamesRepository extends AbstractRepository implements GamesRepositoryInterface, GridViewInterface {

    public function __construct(Game $game)
    {
        parent::__construct($game);
    }

    public function allWithMaps()
    {
        return $this->model->with('maps')->get();
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