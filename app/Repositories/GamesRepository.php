<?php
namespace App\Repositories;

use App\Game, App\Map;
use App\Libraries\GridView\GridViewInterface;
use App\Repositories\Contracts\GamesRepositoryInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class GamesRepository extends AbstractRepository implements GamesRepositoryInterface, GridViewInterface {

    private $uploadPath;

    public function __construct(Game $game)
    {
        parent::__construct($game);

        $this->uploadPath = base_path() . '/public/uploads/games/';
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