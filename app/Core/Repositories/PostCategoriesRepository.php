<?php
namespace Comet\Core\Repositories;

use Comet\Core\Models\PostCategory;
use Comet\Core\Repositories\Contracts\PostCategoriesRepositoryInterface;

/**
 * Post categories repository
 *
 * @package Comet\Repositories
 */
class PostCategoriesRepository extends EloquentRepository implements PostCategoriesRepositoryInterface {

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