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

    public function insertMap($mapName, $gameID, $file = null)
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

    public function insertMaps($mapNames, $gameID, $mapImages = [])
    {
        $totalMaps = count($mapNames);
        for ($i = 0; $i < $totalMaps; $i ++) {
            if (!empty($mapNames[$i]))
                $this->insertMap($mapNames[$i], $gameID, $mapImages[$i]);
        }
    }

    public function updateMaps($maps, $formMapIDs, $gameID, $files)
    {
        // Convert string values to integer
        $formMapIDs = array_map('intval', $formMapIDs);
        // Get current database map values
        $currentMaps = array_values(array_flatten($this->model->select('id')->where('game_id', '=', $gameID)->get()->toArray()));
        $totalMaps = count($formMapIDs);

        // Update maps and insert new ones if any
        for ($i=0; $i < $totalMaps; $i++) {
            if (empty($formMapIDs[$i])) { // Map doesn't exist
                $this->insertMap($maps[$i], $gameID, $files[$i]);
            }
            else { // Update existing map
                $mapImage = $this->get($formMapIDs[$i])->image;
                if ($files[$i]) {
                    if ($mapImage) {
                        unlink($this->uploadPath . $mapImage);
                    }
                    $imageName = $formMapIDs[$i] . '_' . $gameID . '.' . $files[$i]->getClientOriginalExtension();
                    $files[$i]->move($this->uploadPath, $imageName);

                    $this->update($formMapIDs[$i], ['image' => $imageName]);
                }
                $this->update($formMapIDs[$i], ['name' => $maps[$i]]);
            }
        }

        // Delete maps
        $mapsToDelete = array_diff($currentMaps, array_filter($formMapIDs)); // Check missing map IDs
        $this->deleteMaps($mapsToDelete);
    }

    public function deleteMaps(array $mapIDs)
    {
        $maps = $this->model->whereIn('id', $mapIDs)->get();

        foreach ($maps as $map) {
            $filename = $this->uploadPath . $map->image;
            parent::delete($map->id);
            if (file_exists($filename) && is_file($filename)) {
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