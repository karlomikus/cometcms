<?php
namespace App\Repositories;

use App\Repositories\Contracts\RolesRepositoryInterface;
use App\Libraries\GridView\GridViewInterface;
use App\Role, App\Permission;

/**
 * Roles repository
 *
 * @package App\Repositories
 */
class RolesRepository extends AbstractRepository implements RolesRepositoryInterface, GridViewInterface {

    /**
     * Permission model instance
     *
     * @var Permission
     */
    protected $permission;

    /**
     * @param Role $role
     * @param Permission $permission
     */
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
     * Prepare paged data for the grid view
     *
     * @param int $page
     * @param int $limit
     * @param string $sortColumn
     * @param $order
     * @param null $searchTerm
     * @param bool $trash
     * @return mixed
     */
    public function getByPageGrid($page, $limit, $sortColumn, $order, $searchTerm = null, $trash = false)
    {
        $model = $this->model->orderBy($sortColumn, $order);

        if ($trash)
            $model->onlyTrashed();

        if ($searchTerm)
            $model->where('name', 'LIKE', '%' . $searchTerm . '%')
                ->orWhere('display_name', 'LIKE', '%' . $searchTerm . '%')
                ->orWhere('description', 'LIKE', '%' . $searchTerm . '%');

        $result['count'] = $model->count();
        $result['items'] = $model->skip($limit * ($page - 1))->take($limit)->get();

        return $result;
    }

}