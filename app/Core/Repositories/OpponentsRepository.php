<?php
namespace Comet\Core\Repositories;

use Comet\Core\Models\Opponent;
use Comet\Core\Repositories\Contracts\OpponentsRepositoryInterface;
use Comet\Libraries\GridView\GridViewInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Comet\Libraries\ImageUploadTrait as ImageUpload;

/**
 * Opponents Repository
 *
 * @package Comet\Repositories
 */
class OpponentsRepository extends EloquentRepository implements OpponentsRepositoryInterface, GridViewInterface {

    use ImageUpload;

    /**
     * @param Opponent $opponent
     */
    public function __construct(Opponent $opponent)
    {
        parent::__construct($opponent);

        $this->setUploadPath(base_path() . '/public/uploads/opponents/');
    }

    /**
     * Remove reference image when permanently deleting an opponent
     *
     * @param int $id
     * @return bool
     */
    public function deleteFromTrash($id)
    {
        $this->deleteImage($id);

        return parent::deleteFromTrash($id);
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
            $model->where('name', 'LIKE', '%' . $searchTerm . '%');

        $result['count'] = $model->count();
        $result['items'] = $model->skip($limit * ($page - 1))->take($limit)->get();

        return $result;
    }

} 