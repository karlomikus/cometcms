<?php namespace App\Http\Controllers\Admin;

use App\Repositories\Contracts\UsersRepositoryInterface;
use App\User;

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

}
