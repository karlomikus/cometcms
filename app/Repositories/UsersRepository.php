<?php
namespace App\Repositories;

use App\Libraries\GridView\GridViewInterface;
use App\Repositories\Contracts\UsersRepositoryInterface;
use App\User;
use App\Libraries\ImageUploadTrait as ImageUpload;

class UsersRepository extends AbstractRepository implements UsersRepositoryInterface, GridViewInterface {

    use ImageUpload;

    private $uploadPath;

    public function __construct(User $user)
    {
        parent::__construct($user);

        $this->setUploadPath(base_path() . '/public/uploads/users/');
    }

    public function delete($userID)
    {
        $this->deleteImage($userID);
        return parent::delete($userID);
    }

    public function getByPageGrid($page, $limit, $sortColumn, $order, $searchTerm = null, $trash = false)
    {
        $model = $this->model->orderBy($sortColumn, $order);

        if ($trash)
            $model->onlyTrashed();

        if ($searchTerm)
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

}