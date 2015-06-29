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

    public function insertMap($mapName, $gameID, $file)
    {
        try {
            $map = $this->model->create([
                'name'    => $mapName,
                'game_id' => $gameID,
                'image'   => null
            ]);

            if ($file !== null) {
                $imageName = $map->id . '_' . $gameID . '.' . $file->getClientOriginalExtension();
                $file->move($this->uploadPath, $imageName);

                $map->image = $imageName;
                $map->save();
            }

            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function updateMaps($maps, $gameID, $file)
    {
        $this->deleteMaps($gameID);

        $totalMaps = count($maps);
        for ($i = 0; $i < $totalMaps; $i ++) {
            if (!empty($maps[$i]))
                $this->insertMap($maps[$i], $gameID, $file[$i]);
        }
    }

    public function deleteMaps($gameID)
    {
        $maps = $this->model->where('game_id', '=', $gameID)->get();

        foreach ($maps as $map) {
            $filename = $this->uploadPath . $map->image;
        
            if (file_exists($filename) && is_file($filename)) {
                parent::delete($map->id);
                unlink($filename);
            }
        }
    }

    public function getByPageGrid($page, $limit, $sortColumn, $order, $searchTerm = null)
    {
        $model = $this->model->orderBy($sortColumn, $order);

        if ($searchTerm)
            $model->where('name', 'LIKE', '%' . $searchTerm . '%');

        $result['count'] = $model->count();
        $result['items'] = $model->skip($limit * ($page - 1))->take($limit)->get();

        return $result;
    }

    public function getByGame($gameID)
    {
        return $this->model->where('game_id', '=', $gameID)->get();
    }
}