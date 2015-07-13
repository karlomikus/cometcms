<?php
namespace App\Repositories;

use App\Repositories\Contracts\RolesRepositoryInterface;
use App\Libraries\GridView\GridViewInterface;
use App\Role, App\Permission;

class RolesRepository extends AbstractRepository implements RolesRepositoryInterface, GridViewInterface {

    protected $permission;

    public function __construct(Role $role, Permission $permission)
    {
        parent::__construct($role);
        $this->permission = $permission;
    }

    /**
     * Get all existing permissions
     * 
     * @return mixed
     */
    public function getAllPermissions()
    {
        return $this->permission->get();
    }

    /**
     * Get permissions for a specified role ID
     * 
     * @param  int $roleID Role ID
     * @return mixed
     */
    public function getRolePermissions($roleID)
    {
        return $this->get($roleID)->perms;
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
            $model->where('name', 'LIKE', '%' . $searchTerm . '%')
                ->orWhere('display_name', 'LIKE', '%'. $searchTerm .'%')
                ->orWhere('description', 'LIKE', '%'. $searchTerm .'%');

        $result['count'] = $model->count();
        $result['items'] = $model->skip($limit * ($page - 1))->take($limit)->get();

        return $result;
    }

}