<?php namespace App\Http\Controllers\Admin;

use App\Repositories\Contracts\UsersRepositoryInterface;
use App\Role;
use Illuminate\Http\Request;

class UsersController extends AdminController {

    protected $users;

    public function __construct(UsersRepositoryInterface $users)
    {
        $this->users = $users;
    }

	public function index(Request $request)
    {
        $searchTerm = $request->query('search');

        if (empty($searchTerm))
            $usersData = $this->users->paginate(10);
        else
            $usersData = $this->users->search($searchTerm)->paginate(10);

        $data['users'] = $usersData;

        return view('admin.users.index', $data);
    }

    public function create()
    {
        $data['roles'] = Role::all();

        return view('admin.users.form', $data);
    }

    public function save(Request $request)
    {
        $roles = $request->input('roles');

        $user = $this->users->insert([
            'email' => $request->input('email'),
            'password' => \Hash::make($request->input('pwd')),
            'name' => $request->input('name')
        ]);

        $user->attachRoles($roles);

        return redirect('admin/users');
    }

    public function edit($id)
    {

    }

    public function update($id)
    {

    }

}
