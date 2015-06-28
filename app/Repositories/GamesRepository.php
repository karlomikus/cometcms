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

    public function insertImage($gameID, UploadedFile $file)
    {
        $imageName = $gameID . '.' . $file->getClientOriginalExtension();

        try {
            $file->move($this->uploadPath, $imageName);
            $this->update($gameID, ['image' => $imageName]);

            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function updateImage($gameID, UploadedFile $file)
    {
        $currentImage = $this->model->find($gameID)->image;

        if ($currentImage !== null) {
            $this->deleteImage($gameID);
        }

        $imageName = $gameID . '.' . $file->getClientOriginalExtension();

        try {
            $file->move($this->uploadPath, $imageName);
            $this->update($gameID, ['image' => $imageName]);

            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function deleteImage($gameID)
    {
        $game = $this->get($gameID);
        $filename = $this->uploadPath . $game->image;

        if (file_exists($filename) && is_file($filename)) {
            parent::update($gameID, ['image' => null]);
            return unlink($filename);
        }

        return false;
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