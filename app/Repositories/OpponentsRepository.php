<?php
namespace App\Repositories;

use App\Opponent;
use App\Repositories\Contracts\OpponentsRepositoryInterface;
use App\Libraries\GridView\GridViewInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class OpponentsRepository extends AbstractRepository implements OpponentsRepositoryInterface, GridViewInterface {

    private $uploadPath;

    public function __construct(Opponent $opponent)
    {
        parent::__construct($opponent);

        $this->uploadPath = base_path() . '/public/uploads/opponents/';
    }

    /**
     * Uploads and inserts filename to database
     *
     * @param int $id Opponent ID
     * @param UploadedFile $file File request
     * @return bool
     */
    public function insertFile($opponentID, UploadedFile $file)
    {
        $imageName = $opponentID . '.' . $file->getClientOriginalExtension();

        try {
            $file->move($this->uploadPath, $imageName);
            $this->update($opponentID, ['image' => $imageName]);

            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Deletes the file from disk and database
     * 
     * @param  int $id Opponent ID
     * @return bool     Is the file deleted
     */
    public function deleteFile($opponentID)
    {
        $opponent = $this->get($opponentID);
        $filename = $this->uploadPath . $opponent->image;
        
        if (file_exists($filename) && is_file($filename)) {
            parent::update($opponentID, ['image' => null]);
            return unlink($filename);
        }

        return false;
    }

    /**
     * Delete a single opponent
     * 
     * @param $id
     */
    public function delete($opponentID)
    {
        $this->deleteFile($opponentID);

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