<?php
namespace Comet\Repositories;

use Comet\PostCategory;
use Comet\Repositories\Contracts\PostCategoriesRepositoryInterface;

/**
 * Post categories repository
 *
 * @package Comet\Repositories
 */
class PostCategoriesRepository extends AbstractRepository implements PostCategoriesRepositoryInterface {

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