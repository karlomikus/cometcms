<?php namespace Comet\Http\Controllers\Admin;

use Comet\Libraries\GridView\GridView;
use Illuminate\Http\Request;

/**
 * Implements general methods for trash actions used by most of the controllers.
 */
trait TraitTrashable
{
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
        $this->breadcrumbs->addCrumb('Trash', 'trash');
        // Restore all items from trash
        if ($request->has('restore')) {
            $this->restoreAll();
        }

        if ($request->has('empty')) {
            $this->emptyTrash();
        }

        // Initiate grid view but only with trashed items
        $grid = new GridView($this->data, true);
        $template = $grid->gridPage(15);

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
        } else {
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
        } else {
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
        } else {
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
        } else {
            $this->alerts->alertError('Unable to empty the trash!');
        }

        $this->alerts->getAlerts();

        redirect($this->redirectUrl);
    }
}
