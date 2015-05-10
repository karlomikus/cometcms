<?php
namespace App\Repositories;

use App\Contracts\CometListView;
use App\Repositories\Contracts\UsersRepositoryInterface;
use App\User;

class UsersRepository extends AbstractRepository implements UsersRepositoryInterface, CometListView {

    public function __construct(User $user)
    {
        parent::__construct($user);
    }

    public function all()
    {
        return $this->model->orderBy('name', 'asc')->get();
    }

    public function getByPage($page, $limit)
    {
        return $this->model->orderBy('name', 'asc')
            ->skip($limit * ($page - 1))
            ->take($limit)
            ->get();
    }

    public function search($term)
    {
        return $this->model->where('name', 'LIKE', '%'. $term .'%')
            ->orWhere('email', 'LIKE', '%'. $term .'%')
            ->orderBy('name', 'asc')
            ->get();
    }

    public function getByPageGrid($page, $limit, $sortColumn, $order, $searchTerm = null)
    {
        $sortColumn !== null ?: $sortColumn = 'name'; // Default order by column
        $order !== null ?: $order = 'asc'; // Default sorting

        $model = $this->model->orderBy($sortColumn, $order)->skip($limit * ($page - 1))->take($limit);

        if($searchTerm)
            $model->where('name', 'LIKE', '%'. $searchTerm .'%')->orWhere('email', 'LIKE', '%'. $searchTerm .'%');

        return $model->with('roles')->get();
    }

}