<?php namespace App\Http\Controllers\Admin;

use App\CometGridView;
use App\Http\Requests\SaveUserRequest;
use App\Repositories\Contracts\UsersRepositoryInterface;
use App\Role;
use Illuminate\Http\Request;

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
        $page       = $request->query('page');
        $sortColumn = $request->query('sort');
        $order      = $request->query('order');

        //$usersData = $this->users->getByPageGrid($page, self::PAGE_LIMIT, $sortColumn, $order, $searchTerm);
        //$pagedData = new LengthAwarePaginator($usersData['items'], $usersData['count'], self::PAGE_LIMIT, $page, ['path' => $request->getPathInfo()]);
        $icon = $order == 'asc' ? 'down' : 'up';

        $grid = new CometGridView($this->users);
        $grid->setOrder($order);
        $grid->setSearchTerm($searchTerm);
        $grid->setSortColumn($sortColumn);
        $grid->setPath($request->getPathInfo());

        $data['users']      = $grid->gridPage($page, 15);
        $data['searchTerm'] = $searchTerm;
        $data['sortColumn'] = $sortColumn;
        $data['order']      = $order;
        $data['caret']      = '<i class="fa fa-caret-' . $icon . '"></i>';

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
