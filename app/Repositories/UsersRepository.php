<?php
namespace App\Repositories;

use App\Repositories\Contracts\UsersRepositoryInterface;
use App\User;

class UsersRepository extends AbstractRepository implements UsersRepositoryInterface {

    public function __construct(User $user)
    {
        parent::__construct($user);
    }
}