<?php namespace App\Http\Controllers\Admin;

use App\Libraries\GridView\GridView;
use App\Repositories\Contracts\RolesRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class RolesController extends AdminController {

    protected $roles;

    public function __construct(RolesRepositoryInterface $roles)
    {
        parent::__construct();
        $this->roles = $roles;
    }

    public function index(Request $request)
    {
        $searchTerm = $request->query('search');
        $page = $request->query('page');
        $sortColumn = $request->query('sort');
        $order = $request->query('order');

        $grid = new GridView($this->roles);
        $grid->setSearchTerm($searchTerm);
        $grid->setSortColumn($sortColumn, 'display_name');
        $grid->setPath($request->getPathInfo());
        $grid->setOrder($order, 'asc');

        $template = $grid->gridPage($page, 15);

        $template['pageTitle'] = 'User roles';

        return view('admin.roles.index', $template);
    }

    public function create()
    {
        $template = [
            'pageTitle' => 'Create new role',
            'perms' => $this->roles->getAllPermissions(),
            'model' => null,
            'selectedPerms' => []
        ];

        return view('admin.roles.form', $template);
    }

    public function save(Request $request)
    {
        $displayName = $request->input('display_name');
        $name = Str::slug($displayName);

        $role = $this->roles->insert([
            'name'  => $name,
            'display_name'  => $displayName,
            'description' => $request->input('description')
        ]);

        $perms = $request->input('perms');

        if ($role) {
            $role->attachPermissions($perms);
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
        $roleData = $this->roles->get($id);
        $template = [
            'pageTitle' => 'Editing a role',
            'model' => $roleData,
            'perms' => $this->roles->getAllPermissions(),
            'selectedPerms' => $roleData->perms->lists('id')->toArray()
        ];

        return view('admin.roles.form', $template);
    }

    public function update($id, Request $request)
    {
        $displayName = $request->input('display_name');
        $name = Str::slug($displayName);

        $role = $this->roles->update($id, [
            'display_name' => $displayName,
            'name' => $name,
            'description' => $request->input('description')
        ]);

        if ($role) {
            $this->alerts->alertSuccess('Role edited successfully!');
        }
        else {
            $this->alerts->alertError('Role edit failed!');
        }

        $this->alerts->getAlerts();

        return redirect('admin/roles');
    }

}
