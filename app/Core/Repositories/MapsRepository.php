<?php
namespace Comet\Core\Repositories;

use Comet\Core\Models\Map;
use League\Flysystem\Exception;
use Comet\Libraries\GridView\GridViewInterface;
use Comet\Libraries\ImageUploadTrait as ImageUpload;
use Comet\Core\Contracts\Repositories\MapsRepositoryInterface;

/**
 * Maps repository
 *
 * Implements grid view and uses image uploading
 *
 * @package Comet\Repositories
 */
class MapsRepository extends EloquentRepository implements MapsRepositoryInterface, GridViewInterface
{
    use ImageUpload;

    /**
     * Set model instance and upload path
     *
     * @param Map $map
     */
    public function __construct(Map $map)
    {
        parent::__construct($map);

        $this->setUploadPath(base_path() . '/public/uploads/maps/');
    }

    /**
     * Add map and it's image
     *
     * @param $mapName string Map name
     * @param $gameID int Game ID
     * @param null $file Map image file
     * @return bool
     */
    public function insertMap($mapName, $gameID, $file = null)
    {
        try {
            $map = $this->model->create([
                'name'    => $mapName,
                'game_id' => $gameID,
                'image'   => null
            ]);

            if ($file !== null) {
                $this->insertImage($map->id, $file);
            }

            return true;
        } catch (\Exception $e) {
            \Session::flash('exception', $e->getMessage());

            return false;
        }
    }

    /**
     * Add multiple maps
     *
     * @param $mapNames array Map names
     * @param $gameID
     * @param array $mapImages
     * @throws Exception
     */
    public function insertMaps($mapNames, $gameID, $mapImages = [])
    {
        if (!is_array($mapNames)) {
            throw new Exception('Map names is not an array!');
        }

        $totalMaps = count($mapNames);
        for ($i = 0; $i < $totalMaps; $i ++) {
            if (!empty($mapNames[$i])) {
                $this->insertMap($mapNames[$i], $gameID, $mapImages[$i]);
            }
        }
    }

    /**
     * Update maps
     *
     * Compares changes on data coming from form and data coming from database.
     * Inserts new maps, updates existing maps and deletes removed maps.
     *
     * @param $maps array Maps array
     * @param $formMapIDs array Map IDs coming from the form
     * @param $gameID int Game ID
     * @param $files
     * @throws Exception
     */
    public function updateMaps($maps, $formMapIDs, $gameID, $files)
    {
        if (!is_array($maps) || !is_array($formMapIDs)) {
            throw new Exception('Maps are not an array!');
        }

        // Convert string values to integer
        $formMapIDs = array_map('intval', $formMapIDs);
        // Get current database map values
        $currentMaps = array_values(
            array_flatten($this->model->select('id')->where('game_id', '=', $gameID)->get()->toArray())
        );
        // Count maps coming from form
        $totalMaps = count($formMapIDs);

        // Update maps and insert new ones if any
        for ($i = 0; $i < $totalMaps; $i ++) {
            if (empty($formMapIDs[$i])) { // Map doesn't exist
                $this->insertMap($maps[$i], $gameID, $files[$i]);
            } else { // Update existing map
                if ($files[$i]) {
                    $this->updateImage($formMapIDs[$i], $files[$i]);
                }
                $this->update($formMapIDs[$i], ['name' => $maps[$i]]);
            }
        }

        // Delete maps
        $mapsToDelete = array_diff($currentMaps, array_filter($formMapIDs)); // Check missing map IDs
        $this->deleteMaps($mapsToDelete);
    }

    /**
     * @param array $mapIDs
     */
    public function deleteMaps(array $mapIDs)
    {
        $maps = $this->model->whereIn('id', $mapIDs)->get();

        foreach ($maps as $map) {
            //$this->deleteImage($map->id);
            parent::delete($map->id);
        }
    }

    /**
     * Permanently delete give maps
     *
     * @param array $mapIDs Map IDs
     */
    public function destroyMaps(array $mapIDs)
    {
        $maps = $this->model->whereIn('id', $mapIDs)->get();

        foreach ($maps as $map) {
            $this->deleteImage($map->id);
            $this->deleteFromTrash($map->id);
        }
    }

    /**
     * Prepare paged data for the grid view
     *
     * @param $page int Current page
     * @param $limit int Page results limit
     * @param $sortColumn string Column name
     * @param $order string Order type
     * @param $searchTerm string Search term
     * @param $trash bool Get only trashed items
     * @return array
     */
    public function getByPageGrid($page, $limit, $sortColumn, $order, $searchTerm = null, $trash = false)
    {
        $model = $this->model->orderBy($sortColumn, $order);

        if ($trash) {
            $model->onlyTrashed();
        }

        if ($searchTerm) {
            $model->where('name', 'LIKE', '%' . $searchTerm . '%');
        }

        $result['count'] = $model->count();
        $result['items'] = $model->skip($limit * ($page - 1))->take($limit)->get();

        return $result;
    }

    /**
     * Get all maps from a specific game
     *
     * @param $gameID int Game ID
     * @return mixed
     */
    public function getByGame($gameID)
    {
        return $this->model->where('game_id', '=', $gameID)->get();
    }
}
