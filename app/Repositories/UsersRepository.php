<?php
namespace App\Repositories;

use App\Libraries\GridView\GridViewInterface;
use App\Repositories\Contracts\UsersRepositoryInterface;
use App\User;
use App\Libraries\ImageUploadTrait as ImageUpload;

/**
 * Users Repository
 *
 * @package App\Repositories
 */
class UsersRepository extends AbstractRepository implements UsersRepositoryInterface, GridViewInterface {

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
        $sortColumn = (!$sortColumn) ? 'name' : $sortColumn;
        $order = (!$order) ? 'asc' : $order;

        $model = $this->model->orderBy($sortColumn, $order);

        if ($trash)
            $model->onlyTrashed();

        if ($searchTerm)
            $model->where('name', 'LIKE', '%' . $searchTerm . '%')->orWhere('email', 'LIKE', '%' . $searchTerm . '%');

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
        $model = $this->model->orderBy('name');

        return $model->where('name', 'LIKE', '%' . $string . '%')->get();
    }

}