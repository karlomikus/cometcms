<?php
namespace App\Repositories;

use App\Post;
use App\Libraries\GridView\GridViewInterface;
use App\Repositories\Contracts\PostsRepositoryInterface;

/**
 * Games repository
 *
 * Implements grid view and uses image uploading trait
 *
 * @package App\Repositories
 */
class PostsRepository extends AbstractRepository implements PostsRepositoryInterface, GridViewInterface {

    /**
     * @param Post $post
     */
    public function __construct(Post $post)
    {
        parent::__construct($post);
    }

    /**
     * Prepare paged data for the grid view
     *
     * @param $page int Current page
     * @param $limit int Page results limit
     * @param $sortColumn string Column name
     * @param $order string Order type
     * @param $searchTerm string Search term
     * @param $trash bool Get only trashed items
     * @return array
     */
    public function getByPageGrid($page, $limit, $sortColumn, $order, $searchTerm = null, $trash = false)
    {
        $sortColumn = (!$sortColumn) ? 'title' : $sortColumn;
        $order = (!$order) ? 'asc' : $order;

        $model = $this->model->orderBy($sortColumn, $order);

        if ($trash)
            $model->onlyTrashed();

        if ($searchTerm)
            $model->where('title', 'LIKE', '%' . $searchTerm . '%')->orWhere('slug', 'LIKE', '%' . $searchTerm . '%');

        $result['count'] = $model->count();
        $result['items'] = $model->with('author', 'category')->skip($limit * ($page - 1))->take($limit)->get();

        return $result;
    }

}