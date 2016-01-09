<?php
namespace Comet\Core\Repositories;

use Comet\Core\Models\User;
use Comet\Libraries\GridView\GridViewInterface;
use Comet\Libraries\ImageUploadTrait as ImageUpload;
use Comet\Core\Contracts\Repositories\UsersRepositoryInterface;

/**
 * Users Repository
 *
 * @package Comet\Repositories
 */
class UsersRepository extends EloquentRepository implements UsersRepositoryInterface, GridViewInterface
{
    use ImageUpload;

    /**
     * @param User $user
     */
    public function __construct(User $user)
    {
        parent::__construct($user);

        $this->setUploadPath(base_path() . '/public/uploads/users/');
    }

    /**
     * Permanently delete one item. This affects all his references.
     *
     * @param int $userID
     * @return bool
     */
    public function deleteFromTrash($userID)
    {
        $this->deleteImage($userID);

        return parent::deleteFromTrash($userID);
    }

    /**
     * Prepare paged data for the grid view
     *
     * @param int $page
     * @param int $limit
     * @param string $sortColumn
     * @param $order
     * @param null $searchTerm
     * @param bool $trash
     * @return mixed
     */
    public function getByPageGrid($page, $limit, $sortColumn, $order, $searchTerm = null, $trash = false)
    {
        $sortColumn = (!$sortColumn) ? 'profile.first_name' : $sortColumn;
        $order = (!$order) ? 'asc' : $order;

        $model = $this->model
            ->with('profile')
            ->join('users_profiles as profile', 'profile.user_id', '=', 'users.id')
            ->orderBy($sortColumn, $order);

        if ($trash) {
            $model->onlyTrashed();
        }

        if ($searchTerm) {
            $model->where('profile.first_name', 'LIKE', '%' . $searchTerm . '%')
                ->orWhere('profile.last_name', 'LIKE', '%' . $searchTerm . '%');
        }

        $result['count'] = $model->count();
        $result['items'] = $model->with('roles')->skip($limit * ($page - 1))->take($limit)->get();

        return $result;
    }

    /**
     * Get user collection by name
     *
     * @param $string
     * @return mixed
     */
    public function searchUsersByName($string)
    {
        $model = $this->model
            ->join('users_profiles as profile', 'profile.user_id', '=', 'users.id')
            ->with('profile')
            ->orderBy('profile.first_name')
            ->orderBy('profile.last_name')
            ->where('profile.first_name', 'LIKE', '%' . $string . '%')
            ->orWhere('profile.last_name', 'LIKE', '%' . $string . '%')
            ->get();

        return $model;
    }
}
