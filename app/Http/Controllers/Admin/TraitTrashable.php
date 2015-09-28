<?php namespace App\Http\Controllers\Admin;

use App\Libraries\GridView\GridView;
use Illuminate\Http\Request;

/**
 * Implements general methods for trash actions used by most of the controllers.
 */
trait TraitTrashable {

    /**
     * @var
     */
    protected $view;
    /**
     * @var
     */
    protected $data;
    /**
     * @var
     */
    protected $redirectUrl;

    private $defaultSortColumn = 'name';

    /**
     * Setup repository reference and default trash view.
     *
     * @param  mixed $data Repository reference
     * @param  string $redirectUrl
     * @param  string $view Trash view
     * @return void
     */
    private function trashInit($data, $redirectUrl, $view)
    {
        $this->data = $data;
        $this->view = $view;
        $this->redirectUrl = $redirectUrl;

        // Insert total trash items to view
        view()->share('totalTrash', count($this->data->getTrash()));
        view()->share('trashLink', $this->redirectUrl);
    }

    /**
     * Default trash action. Generates grid made of only trashed items.
     * Also checks for query string for emptying and restoring trashed items.
     *
     * @param  Request $request Http request
     * @return mixed
     */
    public function trash(Request $request)
    {
        // Usual grid view stuff
        $searchTerm = $request->query('search');
        $page = $request->query('page');
        $sortColumn = $request->query('sort');
        $order = $request->query('order');

        // Restore all items from trash
        if ($request->has('restore')) {
            $this->restoreAll();
        }

        if ($request->has('empty')) {
            $this->emptyTrash();
        }

        // Initiate grid view but only with trashed items
        $grid = new GridView($this->data, true);
        $grid->setSearchTerm($searchTerm);
        $grid->setSortColumn($sortColumn, $this->defaultSortColumn);
        $grid->setPath($request->getPathInfo());
        $grid->setOrder($order, 'asc');

        // Setup view data
        $template = $grid->gridPage($page, 15);
        $template['pageTitle'] = 'Trash';

        return view($this->view, $template);
    }

    /**
     * Restore specific item
     *
     * @param  int $id
     * @return mixed
     */
    public function restore($id)
    {
        if ($this->data->restoreFromTrash($id)) {
            $this->alerts->alertSuccess('Item restored successfully!');
        }
        else {
            $this->alerts->alertError('Unable to restore an item!');
        }

        $this->alerts->getAlerts();

        return redirect($this->redirectUrl);
    }

    /**
     * Remove specific item
     *
     * @param  int $id
     * @return mixed
     */
    public function remove($id)
    {
        if ($this->data->deleteFromTrash($id)) {
            $this->alerts->alertSuccess('Item and it\'s references successfully deleted!');
        }
        else {
            $this->alerts->alertError('Unable to delete an item!');
        }

        $this->alerts->getAlerts();

        return redirect($this->redirectUrl);
    }

    /**
     * Restore all items
     *
     * @return mixed
     */
    private function restoreAll()
    {
        if ($this->data->restoreAll()) {
            $this->alerts->alertSuccess('Successfully restored all items from trash!');
        }
        else {
            $this->alerts->alertError('Unable to restore all items from trash!');
        }

        $this->alerts->getAlerts();

        redirect($this->redirectUrl);
    }

    /**
     * Remove all items
     *
     * @return mixed
     */
    private function emptyTrash()
    {
        if ($this->data->emptyAll()) {
            $this->alerts->alertSuccess('Successfully deleted all items from trash!');
        }
        else {
            $this->alerts->alertError('Unable to empty the trash!');
        }

        $this->alerts->getAlerts();

        redirect($this->redirectUrl);
    }

    /**
     * @param string $defaultSortColumn
     */
    protected function setDefaultSortColumn($defaultSortColumn)
    {
        $this->defaultSortColumn = $defaultSortColumn;
    }

}