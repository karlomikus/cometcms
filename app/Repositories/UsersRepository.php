<?php
namespace App\Repositories;

use App\Libraries\GridView\GridViewInterface;
use App\Repositories\Contracts\UsersRepositoryInterface;
use App\User;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class UsersRepository extends AbstractRepository implements UsersRepositoryInterface, GridViewInterface {

    private $uploadPath;

    public function __construct(User $user)
    {
        parent::__construct($user);

        $this->uploadPath = base_path() . '/public/uploads/users/';
    }

    public function getByPageGrid($page, $limit, $sortColumn, $order, $searchTerm = null)
    {
        $model = $this->model->orderBy($sortColumn, $order);

        if($searchTerm)
            $model->where('name', 'LIKE', '%'. $searchTerm .'%')->orWhere('email', 'LIKE', '%'. $searchTerm .'%');

        $result['count'] = $model->count();
        $result['items'] = $model->with('roles')->skip($limit * ($page - 1))->take($limit)->get();

        return $result;
    }

    public function searchUsersByName($string)
    {
        $model = $this->model->orderBy('name');

        return $model->where('name', 'LIKE', '%'. $string .'%')->get();
    }

    public function insertImage($id, UploadedFile $file)
    {
        $imageName = $id . '.' . $file->getClientOriginalExtension();

        try {
            $file->move($this->uploadPath, $imageName);
            $this->update($id, ['image' => $imageName]);

            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

}