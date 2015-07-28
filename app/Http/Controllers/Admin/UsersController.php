<?php namespace App\Http\Controllers\Admin;

use App\Libraries\GridView\GridView;
use App\Http\Requests\SaveUserRequest;
use App\Repositories\Contracts\UsersRepositoryInterface;
use App\Repositories\Contracts\RolesRepositoryInterface;
use App\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\TraitTrashable as Trash;

class UsersController extends AdminController {

    use Trash;

    protected $users;

    public function __construct(UsersRepositoryInterface $users, RolesRepositoryInterface $roles)
    {
        parent::__construct();

        $this->users = $users;
        $this->roles = $roles;

        $this->trashInit($this->users, 'admin/users/trash', 'admin.users.trash');
    }

	public function index(Request $request)
    {
        $searchTerm = $request->query('search');
        $page       = $request->query('page');
        $sortColumn = $request->query('sort');
        $order      = $request->query('order');

        $grid = new GridView($this->users);
        $grid->setOrder($order, 'asc');
        $grid->setSortColumn($sortColumn, 'name');
        $grid->setSearchTerm($searchTerm);
        $grid->setPath($request->getPathInfo());

        $data = $grid->gridPage($page, 15);

        $data['pageTitle'] = 'Users';

        return view('admin.users.index', $data);
    }

    public function create()
    {
        $template['roles'] = $this->roles->all();
        $template['user'] = null;

        $template['pageTitle'] = 'Create new user';

        return view('admin.users.form', $template);
    }

    public function save(SaveUserRequest $request)
    {
        $roles = $request->input('roles');

        $user = $this->users->insert([
            'email' => $request->input('email'),
            'password' => \Hash::make($request->input('pwd')),
            'name' => $request->input('name')
        ]);

        if ($user) {
            $user->attachRoles($roles);
            if ($request->hasFile('image')) {
                $this->users->insertImage($user->id, $request->file('image'));
            }
            $this->alerts->alertSuccess('New user created successfully!');
        }
        else {
            $this->alerts->alertError('User creation failed!');
        }

        $this->alerts->getAlerts();

        return redirect('admin/users');
    }

    public function edit($id)
    {
        $data['roles'] = Role::all();
        $data['user'] = $this->users->get($id);

        $data['pageTitle'] = 'Editing user: ' . $data['user']->name;

        return view('admin.users.form', $data);
    }

    public function update($id, SaveUserRequest $request)
    {
        $roles = $request->input('roles');
        $data = [
            'email' => $request->input('email'),
            'password' => \Hash::make($request->input('pwd')),
            'name' => $request->input('name')
        ];

        $user = $this->users->update($id, $data);

        if ($user) {
            $user->detachRoles($user->roles);
            $user->attachRoles($roles);
            if ($request->hasFile('image')) {
                $this->users->updateImage($id, $request->file('image'));
            }

            $this->alerts->alertSuccess('User edited successfully!');
        }
        else {
            $this->alerts->alertError('Error while updating the user!');
        }

        $this->alerts->getAlerts();

        return redirect('admin/users');
    }

    public function delete($id)
    {
        if ($this->users->delete($id)) {
            $this->alerts->alertSuccess('User deleted succesfully!');
        }
        else {
            $this->alerts->alertError('Error deleting a user!');
        }

        $this->alerts->getAlerts();

        return redirect('admin/users');
    }

    public function searchUsers(Request $request)
    {
        $searchString = $request->input('q');
        $result = [];
        if(strlen($searchString) >= 2) {
            $result = $this->users->searchUsersByName($searchString);
        }
        return response()->json($result);
    }

}
