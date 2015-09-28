<?php
namespace App\Repositories;

use App\PostCategory;
use App\Repositories\Contracts\PostCategoriesRepositoryInterface;

/**
 * Post categories repository
 *
 * @package App\Repositories
 */
class PostCategoriesRepository extends AbstractRepository implements PostCategoriesRepositoryInterface {

	/**
	 * @param PostCategory $postCategory
	 */
	public function __construct(PostCategory $postCategory)
	{
		parent::__construct($postCategory);
	}
}