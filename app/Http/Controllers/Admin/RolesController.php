<?php namespace Comet\Http\Controllers\Admin;

use Comet\Libraries\GridView\GridView;
use Comet\Core\Repositories\Contracts\RolesRepositoryInterface as Roles;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Comet\Http\Requests\SaveRoleRequest;

class RolesController extends AdminController {

    /**
     * @var Roles
     */
    protected $roles;

    /**
     * @param Roles $roles
     */
    public function __construct(Roles $roles)
    {
        parent::__construct();
        $this->roles = $roles;
        $this->breadcrumbs->addCrumb('Roles', 'roles');
    }

    public function index()
    {
        $grid = new GridView($this->roles);
        $template = $grid->gridPage(15);

        $template['pageTitle'] = 'User roles';

        return view('admin.roles.index', $template);
    }

    public function create()
    {
        $this->breadcrumbs->addCrumb('New', 'new');
        $permissionGroups = ['match', 'post', 'user', 'team', 'opponent'];

        $perms = [];
        foreach ($permissionGroups as $group) {
            $perms[$group] = $this->roles->groupPermissionsBy($group);
        }

        $template = [
            'pageTitle'     => 'Create new role',
            'perms'         => $perms,
            'model'         => null,
            'selectedPerms' => []
        ];

        return view('admin.roles.form', $template);
    }

    public function save(SaveRoleRequest $request)
    {
        $displayName = $request->input('display_name');
        $name = Str::slug($displayName);

        $role = $this->roles->insert([
            'name'         => $name,
            'display_name' => $displayName,
            'description'  => $request->input('description')
        ]);

        $perms = $request->input('perms');

        if ($role) {
            if (!empty($perms)) {
                $role->attachPermissions($perms);
            }
            $this->alerts->alertSuccess('New role created successfully!');
        }
        else {
            $this->alerts->alertError('Role creation failed!');
        }

        $this->alerts->getAlerts();

        return redirect('admin/roles');
    }

    public function edit($id)
    {
        $this->breadcrumbs->addCrumb('Edit', 'edit');
        $permissionGroups = ['match', 'post', 'user', 'team', 'opponent'];

        $perms = [];
        foreach ($permissionGroups as $group) {
            $perms[$group] = $this->roles->groupPermissionsBy($group);
        }

        $roleData = $this->roles->get($id);
        $template = [
            'pageTitle'     => 'Editing a role',
            'model'         => $roleData,
            'perms'         => $perms,
            'selectedPerms' => $roleData->perms->lists('id')->toArray()
        ];

        return view('admin.roles.form', $template);
    }

    public function update($id, SaveRoleRequest $request)
    {
        $displayName = $request->input('display_name');
        $name = Str::slug($displayName);

        $role = $this->roles->update($id, [
            'display_name' => $displayName,
            'name'         => $name,
            'description'  => $request->input('description')
        ]);

        $perms = $request->input('perms');

        if ($role) {
            if (!empty($perms)) {
                // TODO: Fix perms editing
                //$role->detachPermission([]);
                $role->attachPermissions($perms);
            }
            $this->alerts->alertSuccess('Role edited successfully!');
        }
        else {
            $this->alerts->alertError('Role edit failed!');
        }

        $this->alerts->getAlerts();

        return redirect('admin/roles');
    }

    public function delete($id)
    {
        if ($this->roles->delete($id)) {
            $this->alerts->alertSuccess('Role deleted successfully!');
        }
        else {
            $this->alerts->alertError('Unable to delete a role!');
        }

        $this->alerts->getAlerts();

        return redirect('admin/roles');
    }

}
