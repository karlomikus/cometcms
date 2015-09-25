<?php namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Libraries\GridView\GridView;
use App\Http\Controllers\Admin\TraitTrashable as Trash;
use App\Repositories\Contracts\PostsRepositoryInterface as Posts;

/**
 * Posts backend module. Uses trashable trait.
 *
 * @category Admin controllers
 */
class PostsController extends AdminController {

	use Trash;

	/**
	 * Local repository instance
	 */
	private $posts;


	public function __construct(Posts $posts)
	{
		parent::__construct();

		$this->posts = $posts;
		$this->trashInit($this->posts, 'admin/posts/trash', 'admin.posts.trash');
	}

	/**
	 * @param Request $request
	 * @return \Illuminate\View\View
	 */
	public function index(Request $request)
	{
		$searchTerm = $request->query('search');
		$page = $request->query('page');
		$sortColumn = $request->query('sort');
		$order = $request->query('order');

		$grid = new GridView($this->posts);
		$grid->setSearchTerm($searchTerm);
		$grid->setSortColumn($sortColumn, 'title');
		$grid->setPath($request->getPathInfo());
		$grid->setOrder($order, 'asc');

		$data = $grid->gridPage($page, 15);

		$data['pageTitle'] = 'Posts';

		return view('admin.posts.index', $data);
	}

	public function create()
	{
		$template = [
			'post'  => null,
			'pageTitle' => 'Create new post'
		];

		return view('admin.posts.form', $template);
	}

}
