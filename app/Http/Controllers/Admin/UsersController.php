<?php namespace App\Http\Controllers\Admin;

use App\Http\Requests\SaveUserRequest;
use App\Repositories\Contracts\UsersRepositoryInterface;
use App\Role;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class UsersController extends AdminController {

    protected $users;

    const PAGE_LIMIT = 15;

    public function __construct(UsersRepositoryInterface $users)
    {
        $this->users = $users;
    }

	public function index(Request $request)
    {
        $searchTerm = $request->query('search');
        $page = $request->query('page');

        if (empty($searchTerm)) {
            $usersData = $this->users->getByPage($page, self::PAGE_LIMIT);
        }
        else {
            $usersData = $this->users->search($searchTerm);
        }

        $paginator = new LengthAwarePaginator($usersData, $this->users->countAll(), self::PAGE_LIMIT, $page, ['path' => $request->getPathInfo()]);

        $data['users'] = $paginator;
        $data['searchTerm'] = $searchTerm;

        return view('admin.users.index', $data);
    }

    public function create()
    {
        $data['roles'] = Role::all();
        $data['user'] = null;

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

        return redirect('admin/users');
    }

    public function edit($id)
    {
        $data['roles'] = Role::all();
        $data['user'] = $this->users->get($id);

        return view('admin.users.form', $data);
    }

    public function update($id, SaveUserRequest $request)
    {

    }

    public function delete($id)
    {
        $this->users->delete($id);

        return redirect('admin/users');
    }

}
