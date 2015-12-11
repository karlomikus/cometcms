<?php
namespace App\Repositories;

use App\Game, App\Map;
use App\Libraries\GridView\GridViewInterface;
use App\Repositories\Contracts\GamesRepositoryInterface;
use App\Repositories\Contracts\MapsRepositoryInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use App\Libraries\ImageUploadTrait as ImageUpload;

/**
 * Games repository
 *
 * Implements grid view and uses image uploading trait
 *
 * @package App\Repositories
 */
class GamesRepository extends AbstractRepository implements GamesRepositoryInterface, GridViewInterface {

    use ImageUpload;

    /**
     * @param Game $game
     */
    public function __construct(Game $game)
    {
        parent::__construct($game);

        $this->setUploadPath(base_path() . '/public/uploads/games/');
    }

    public function all()
    {
        return $this->model->orderBy('name')->get();
    }

    /**
     * @return mixed
     */
    public function allWithMaps()
    {
        return $this->model->with('maps')->get();
    }

    /**
     * @param int $id
     * @return bool
     */
    public function deleteFromTrash($id)
    {
        $this->deleteImage($id);

        if (parent::deleteFromTrash($id)) {
            return true;
        }

        return false;
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
        $sortColumn = (!$sortColumn) ? 'name' : $sortColumn;
        $order = (!$order) ? 'asc' : $order;

        $model = $this->model->orderBy($sortColumn, $order);

        if ($trash)
            $model->onlyTrashed();

        if ($searchTerm)
            $model->where('name', 'LIKE', '%' . $searchTerm . '%')->orWhere('code', 'LIKE', '%' . $searchTerm . '%');

        $result['count'] = $model->count();
        $result['items'] = $model->with('maps')->skip($limit * ($page - 1))->take($limit)->get();

        return $result;
    }

} 