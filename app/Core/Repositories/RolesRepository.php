<?php
namespace Comet\Core\Repositories;

use Comet\Core\Models\Role;
use Comet\Core\Models\Permission;
use Comet\Libraries\GridView\GridViewInterface;
use Comet\Core\Contracts\Repositories\RolesRepositoryInterface;

/**
 * Roles repository
 *
 * @package Comet\Repositories
 */
class RolesRepository extends EloquentRepository implements RolesRepositoryInterface, GridViewInterface
{
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

    public function groupPermissionsBy($keyword)
    {
        return $this->permission->where('name', 'LIKE', '%' . $keyword . '%')->get();
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
        $sortColumn = (!$sortColumn) ? 'name' : $sortColumn;
        $order = (!$order) ? 'asc' : $order;

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
