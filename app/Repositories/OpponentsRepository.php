<?php
namespace App\Repositories;

use App\Opponent;
use App\Repositories\Contracts\OpponentsRepositoryInterface;
use App\Libraries\GridView\GridViewInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use App\Libraries\ImageUploadTrait as ImageUpload;

class OpponentsRepository extends AbstractRepository implements OpponentsRepositoryInterface, GridViewInterface {

    use ImageUpload;

    private $uploadPath;

    public function __construct(Opponent $opponent)
    {
        parent::__construct($opponent);

        $this->setUploadPath(base_path() . '/public/uploads/opponents/');
    }

    /**
     * Delete a single opponent and it's image
     * 
     * @param $id
     */
    public function delete($opponentID)
    {
        $this->deleteImage($opponentID);

        return parent::delete($opponentID);
    }

    /**
     * Returns paged results for a specific page
     *
     * @param $page int Current page
     * @param $limit int Page results limit
     * @param $sortColumn string Column name
     * @param $searchTerm string Search term
     * @return array
     */
    public function getByPageGrid($page, $limit, $sortColumn, $order, $searchTerm = null)
    {
        $model = $this->model->orderBy($sortColumn, $order);

        if ($searchTerm)
            $model->where('name', 'LIKE', '%' . $searchTerm . '%');

        $result['count'] = $model->count();
        $result['items'] = $model->skip($limit * ($page - 1))->take($limit)->get();

        return $result;
    }

} 