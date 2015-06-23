<?php
namespace App\Repositories;

use App\Libraries\GridView\GridViewInterface;
use App\Repositories\Contracts\MapsRepositoryInterface;
use App\Map;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class MapsRepository extends AbstractRepository implements MapsRepositoryInterface, GridViewInterface {

    private $uploadPath;

    public function __construct(Map $map)
    {
        parent::__construct($map);

        $this->uploadPath = base_path() . '/public/uploads/maps/';
    }

    public function insertMap($mapName, $gameID, UploadedFile $file)
    {
        try {
            $map = $this->model->create([
                'name' => $mapName,
                'game_id' => $gameID
            ]);

            $imageName = $map->id . '_' . $gameID . '.' . $file->getClientOriginalExtension();
            $file->move($this->uploadPathMaps, $imageName);

            $newMap = $this->map->get($map->id);
            $newMap->image = $imageName;
            $newMap->save();

            return true;
        } catch (\Exception $e) {
            dd($e->getMessage());
            return false;
        }
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

    public function getByGame($gameID)
    {
        return $this->model->where('game_id', '=', $gameID)->get();
    }
}