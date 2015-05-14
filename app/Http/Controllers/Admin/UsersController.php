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

        return view('admin.users.index', $data);
    }

    public function create()
    {
        $data['roles'] = $this->roles->all();
        $data['user'] = null;

        return view('admin.users.form', $data);
    }

    public function save(SaveUserRequest $request)
    {
        $roles = $request->input('roles');
        $message = 'User creation failed!';

        $user = $this->users->insert([
            'email' => $request->input('email'),
            'password' => \Hash::make($request->input('pwd')),
            'name' => $request->input('name')
        ]);

        $user->attachRoles($roles);

        if ($user) {
            $message = 'New user created successfully!';
        }

        return redirect('admin/users')->with('message', $message);
    }

    public function edit($id)
    {
        $data['roles'] = Role::all();
        $data['user'] = $this->users->get($id);

        return view('admin.users.form', $data);
    }

    public function update($id, SaveUserRequest $request)
    {
        // TODO: Roles editing
        $roles = $request->input('roles');
        $message = 'User edit failed!';
        $data = [
            'email' => $request->input('email'),
            'password' => \Hash::make($request->input('pwd')),
            'name' => $request->input('name')
        ];

        $user = $this->users->get($id);
        $usersRoles = $user->roles;

        if ($this->users->update($id, $data)) {
            $message = 'User succesfully edited!';
        }
        //$user->attachRoles(array_diff($usersRoles, $roles));

        return redirect('admin/users')->with('message', $message);
    }

    public function delete($id)
    {
        $message = 'User deleting failed!';
        if ($this->users->delete($id)) {
            $message = 'User deleted succesfully!';
        }

        return redirect('admin/users')->with('message', $message);
    }

}
