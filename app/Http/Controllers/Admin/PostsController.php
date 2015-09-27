<?php namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Libraries\GridView\GridView;
use App\Http\Controllers\Admin\TraitTrashable as Trash;
use App\Repositories\Contracts\PostsRepositoryInterface as Posts;
use Illuminate\Support\Str;

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
            'post'      => null,
            'pageTitle' => 'Create new post'
        ];

        return view('admin.posts.form', $template);
    }

    public function save(Request $request)
    {
        $post = $this->posts->insert([
            'title'              => $request->input('title'),
            'summary'            => $request->input('summary'),
            'content'            => $request->input('content'),
            'slug'               => Str::slug($request->input('title')),
            'publish_date_start' => Carbon::parse($request->input('publish_date_start'))->toDateTimeString(),
            'publish_date_end'   => Carbon::parse($request->input('publish_date_end'))->toDateTimeString(),
            'user_id'            => $this->currentUser->id,
            'status'             => $request->input('status'),
            'comments'           => $request->input('comments')
        ]);

        if ($post) {
            $this->alerts->alertSuccess('New post created successfully!');
        }
        else {
            $this->alerts->alertError('Post creation failed!');
        }

        $this->alerts->getAlerts();

        return redirect('admin/posts');
    }

    public function edit($id)
    {
        $template = [
            'post'      => $this->posts->get($id),
            'pageTitle' => 'Editing a post'
        ];

        return view('admin.posts.form', $template);
    }

    public function update($id, Request $request)
    {
        $data = [
            'title'              => $request->input('title'),
            'summary'            => $request->input('summary'),
            'content'            => $request->input('content'),
            'publish_date_start' => $request->input('publish_date_start'),
            'publish_date_end'   => $request->input('publish_date_end')
        ];

        $post = $this->posts->update($id, $data);

        if ($post) {
            $this->alerts->alertSuccess('Post succesfully edited!');
        }
        else {
            $this->alerts->alertError('Failed to edit a post!');
        }

        $this->alerts->getAlerts();

        return redirect('admin/posts');
    }

}
