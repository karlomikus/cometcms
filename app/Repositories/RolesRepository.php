<?php
namespace App\Repositories;

use App\Repositories\Contracts\RolesRepositoryInterface;
use App\Role;

class RolesRepository extends AbstractRepository implements RolesRepositoryInterface {

    public function __construct(Role $role)
    {
        parent::__construct($role);
    }

}