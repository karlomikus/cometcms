<?php namespace App\Http\Controllers\Admin;

use App\Http\Requests\SaveUserRequest;
use App\Repositories\Contracts\UsersRepositoryInterface;
use App\Role;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class UsersController extends AdminController {

    protected $users;

    protected $pageLimit = 15;

    public function __construct(UsersRepositoryInterface $users)
    {
        $this->users = $users;
    }

	public function index(Request $request)
    {
        $searchTerm = $request->query('search');
        $page = $request->query('page');

        if (empty($searchTerm)) {
            $usersData = $this->users->getByPage($page, $this->pageLimit);
            $count = $this->users->countAll();
        }
        else {
            $usersData = $this->users->search($searchTerm);
            $count = 0;
        }

        $paginator = new LengthAwarePaginator($usersData, $count, $this->pageLimit, $page, ['path' => $request->getPathInfo()]);

        $data['users'] = $paginator;
        $data['searchTerm'] = $searchTerm;

        return view('admin.users.index', $data);
    }

    public function create()
    {
        $data['roles'] = Role::all();

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

    }

    public function update($id)
    {

    }

}
