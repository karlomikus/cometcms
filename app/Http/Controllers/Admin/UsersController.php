<?php namespace Comet\Http\Controllers\Admin;

use Comet\Core\Models\Role;
use Illuminate\Http\Request;
use Comet\Libraries\GridView\GridView;
use Comet\Http\Requests\SaveUserRequest;
use Comet\Core\User\UserTransformer;
use Comet\Http\Controllers\Admin\TraitTrashable as Trash;
use Comet\Core\Contracts\Repositories\UsersRepositoryInterface;
use Comet\Core\Contracts\Repositories\RolesRepositoryInterface;

class UsersController extends AdminController
{
    use Trash, TraitApi;

    protected $users;

    public function __construct(UsersRepositoryInterface $users, RolesRepositoryInterface $roles)
    {
        parent::__construct();

        $this->users = $users;
        $this->roles = $roles;

        $this->trashInit($this->users, 'admin/users/trash', 'admin.users.trash');
        $this->breadcrumbs->addCrumb('Users', 'users');
    }

    public function index()
    {
        $grid = new GridView($this->users);
        $data = $grid->gridPage(15);

        $data['pageTitle'] = 'Users';

        return view('admin.users.index', $data);
    }

    public function create()
    {
        $this->breadcrumbs->addCrumb('New', 'new');
        $template['roles'] = $this->roles->all();
        $template['user'] = null;

        $template['pageTitle'] = 'Create new user';

        return view('admin.users.form', $template);
    }

    public function save(SaveUserRequest $request)
    {
        $roles = $request->input('roles');

        $user = $this->users->insert([
            'email'    => $request->input('email'),
            'password' => \Hash::make($request->input('pwd')),
            'name'     => $request->input('name')
        ]);

        if ($user) {
            $user->attachRoles($roles);
            if ($request->hasFile('image')) {
                $this->users->insertImage($user->id, $request->file('image'));
            }
            $this->alerts->alertSuccess('New user created successfully!');
        } else {
            $this->alerts->alertError('User creation failed!');
        }

        $this->alerts->getAlerts();

        return redirect('admin/users');
    }

    public function edit($id)
    {
        $this->breadcrumbs->addCrumb('Edit', 'edit');
        $data['roles'] = Role::all();
        $data['user'] = $this->users->get($id);

        $data['pageTitle'] = 'Editing user: ' . $data['user']->name;

        return view('admin.users.form', $data);
    }

    public function update($id, SaveUserRequest $request)
    {
        $roles = $request->input('roles');
        $data = [
            'email'    => $request->input('email'),
            'password' => \Hash::make($request->input('pwd')),
            'name'     => $request->input('name')
        ];

        $user = $this->users->update($id, $data);

        if ($user) {
            $user->detachRoles($user->roles);
            $user->attachRoles($roles);
            if ($request->hasFile('image')) {
                $this->users->updateImage($id, $request->file('image'));
            }

            $this->alerts->alertSuccess('User edited successfully!');
        } else {
            $this->alerts->alertError('Error while updating the user!');
        }

        $this->alerts->getAlerts();

        return redirect('admin/users');
    }

    public function delete($id)
    {
        if ($this->users->delete($id)) {
            $this->alerts->alertSuccess('User deleted succesfully!');
        } else {
            $this->alerts->alertError('Error deleting a user!');
        }

        $this->alerts->getAlerts();

        return redirect('admin/users');
    }

    public function searchUsers(Request $request)
    {
        $searchString = $request->input('q');

        $result = [];
        if (strlen($searchString) >= 3) {
            $result = $this->users->searchUsersByName($searchString);
            if (count($result) == 0) {
                $this->setMessage('No users found!');
            }
        } else {
            $this->setMessage('Search string must contain at least 3 characters!');
        }

        return $this->respondWithCollection($result, new UserTransformer());
    }
}
