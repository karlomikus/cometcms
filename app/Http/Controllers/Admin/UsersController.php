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

	public function index()
    {
        $data['users'] = $this->users->all();
        return view('admin.users.index', $data);
    }

    public function create()
    {
        $data['roles'] = Role::all();

        return view('admin.users.form', $data);
    }

    public function save(Request $request)
    {
        $all = $request->all();

        $this->users->insert($all);

        return redirect('admin/users');
    }

    public function edit($id)
    {

    }

    public function update($id)
    {

    }

}
