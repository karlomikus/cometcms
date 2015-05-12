<?php
namespace App\Repositories;

use App\Contracts\GridViewInterface;
use App\Repositories\Contracts\UsersRepositoryInterface;
use App\User;

class UsersRepository extends AbstractRepository implements UsersRepositoryInterface, GridViewInterface {

    public function __construct(User $user)
    {
        parent::__construct($user);
    }

    public function all()
    {
        return $this->model->orderBy('name', 'asc')->get();
    }

    public function getByPageGrid($page, $limit, $sortColumn, $order, $searchTerm = null)
    {
        $sortColumn !== null ?: $sortColumn = 'name'; // Default order by column
        $order !== null ?: $order = 'asc'; // Default sorting

        $model = $this->model->orderBy($sortColumn, $order);

        if($searchTerm)
            $model->where('name', 'LIKE', '%'. $searchTerm .'%')->orWhere('email', 'LIKE', '%'. $searchTerm .'%');

        $result['count'] = $model->count();
        $result['items'] = $model->with('roles')->skip($limit * ($page - 1))->take($limit)->get();

        return $result;
    }

}