<?php
namespace Comet\Core\Post;

use Comet\Core\Post\PostCategory;
use Comet\Core\Common\EloquentRepository;
use Comet\Core\Contracts\Repositories\PostCategoriesRepositoryInterface;

/**
 * Post categories repository
 *
 * @package Comet\Repositories
 */
class PostCategoriesRepository extends EloquentRepository implements PostCategoriesRepositoryInterface
{
    /**
     * @param PostCategory $postCategory
     */
    public function __construct(PostCategory $postCategory)
    {
        parent::__construct($postCategory);
    }

    public function getOrInsert($data)
    {
        return $this->model->firstOrCreate($data);
    }
}
