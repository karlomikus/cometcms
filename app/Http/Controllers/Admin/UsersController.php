<?php namespace App\Http\Controllers\Admin;

use App\Libraries\GridView\GridView;
use App\Http\Requests\SaveUserRequest;
use App\Repositories\Contracts\UsersRepositoryInterface;
use App\Repositories\Contracts\RolesRepositoryInterface;
use App\Role;
use Illuminate\Http\Request;

class UsersController extends AdminController {

    protected $users;

    public function __construct(UsersRepositoryInterface $users, RolesRepositoryInterface $roles)
    {
        parent::__construct();

        $this->users = $users;
        $this->roles = $roles;
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
        $data['roles'] = $this->roles->all();
        $data['user'] = null;

        $data['pageTitle'] = 'Create new user';

        return view('admin.users.form', $data);
    }

    public function save(SaveUserRequest $request)
    {
        $roles = $request->input('roles');

        $user = $this->users->insert([
            'email' => $request->input('email'),
            'password' => \Hash::make($request->input('pwd')),
            'name' => $request->input('name')
        ]);

        $user->attachRoles($roles);

        if ($user) {
            if ($request->hasFile('image')) {
                $this->users->insertImage($user->id, $request->file('image'));
            }
            $this->alertSuccess('New user created successfully!');
        } else {
            $this->alertError('User creation failed!');
        }

        return redirect('admin/users')->with('alerts', $this->getAlerts());
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
        // TODO: Roles editing
        $roles = $request->input('roles');
        $data = [
            'email' => $request->input('email'),
            'password' => \Hash::make($request->input('pwd')),
            'name' => $request->input('name')
        ];

        $user = $this->users->get($id);
        $usersRoles = $user->roles;

        if ($this->users->update($id, $data)) {
            $this->alertSuccess('User edited!');
        }
        else {
            $this->alertError('Error while updating the user!');
        }

        return redirect('admin/users')->with('alerts', $this->getAlerts());
    }

    public function delete($id)
    {
        $message = 'User deleting failed!';
        if ($this->users->delete($id)) {
            $message = 'User deleted succesfully!';
        }

        return redirect('admin/users')->with('message', $message);
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
