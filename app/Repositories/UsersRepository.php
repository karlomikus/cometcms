<?php
namespace App\Repositories;

use App\Repositories\Contracts\UsersRepositoryInterface;
use App\User;

class UsersRepository extends AbstractRepository implements UsersRepositoryInterface {

    public function __construct(User $user)
    {
        parent::__construct($user);
    }

    public function search($term)
    {
        return $this->model->where('name', 'LIKE', '%'. $term .'%')
                           ->orWhere('email', 'LIKE', '%'. $term .'%');
    }

}