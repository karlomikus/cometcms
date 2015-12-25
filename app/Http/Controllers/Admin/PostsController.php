<?php namespace Comet\Http\Controllers\Admin;

use Carbon\Carbon;
use Comet\Http\Requests\SavePostRequest;
use Comet\Libraries\GridView\GridView;
use Comet\Http\Controllers\Admin\TraitTrashable as Trash;
use Comet\Core\Repositories\Contracts\PostsRepositoryInterface as Posts;
use Comet\Core\Repositories\Contracts\PostCategoriesRepositoryInterface as Categories;
use Illuminate\Http\Request;
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
    private $categories;

    public function __construct(Posts $posts, Categories $categories)
    {
        parent::__construct();

        $this->posts = $posts;
        $this->categories = $categories;
        $this->trashInit($this->posts, 'admin/posts/trash', 'admin.posts.trash');
        $this->breadcrumbs->addCrumb('Posts', 'posts');
    }

    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $grid = new GridView($this->posts);
        $data = $grid->gridPage(15);

        $data['pageTitle'] = 'Posts';

        return view('admin.posts.index', $data);
    }

    public function create()
    {
        $this->breadcrumbs->addCrumb('New', 'new');
        $template = [
            'post'       => $this->posts->getModel(),
            'pageTitle'  => 'Create new post',
            'categories' => $this->categories->all()->lists('name', 'id')
        ];

        return view('admin.posts.form', $template);
    }

    public function save(SavePostRequest $request)
    {
        $status = 'draft';
        if ($request->input('save-type') === 'publish') {
            $status = 'published';
        }

        $post = $this->posts->insert([
            'title'              => $request->input('title'),
            'summary'            => $request->input('summary'),
            'content'            => $request->input('content'),
            'slug'               => Str::slug($request->input('title')),
            'publish_date_start' => Carbon::parse($request->input('publish_date_start'))->toDateTimeString(),
            'publish_date_end'   => Carbon::parse($request->input('publish_date_end'))->toDateTimeString(),
            'user_id'            => $this->currentUser->id,
            'status'             => $status,
            'comments'           => $request->input('comments'),
            'post_category_id'   => $request->input('post_category_id')
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
        $this->breadcrumbs->addCrumb('Edit', 'edit');
        $template = [
            'post'       => $this->posts->get($id),
            'pageTitle'  => 'Editing a post',
            'categories' => $this->categories->all()->lists('name', 'id')
        ];

        return view('admin.posts.form', $template);
    }

    public function update($id, SavePostRequest $request)
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
            $this->alerts->alertSuccess('Post successfully edited!');
        }
        else {
            $this->alerts->alertError('Failed to edit a post!');
        }

        $this->alerts->getAlerts();

        return redirect('admin/posts');
    }

    public function delete($id)
    {
        if ($this->posts->delete($id)) {
            $this->alerts->alertSuccess('Post moved to trash successfully!');
        }
        else {
            $this->alerts->alertError('Unable to trash this post!');
        }

        $this->alerts->getAlerts();

        return redirect('admin/posts');
    }

}
