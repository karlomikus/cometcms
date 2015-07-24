<?php namespace App\Http\Controllers\Admin;

use App\Libraries\GridView\GridView;
use Illuminate\Http\Request;

trait TraitTrashable {

    protected $view;
    protected $data;

    private function trashInit($data, $view)
    {
        // Set repository instance
        $this->data = $data;
        // Set main trash view file
        $this->view = $view;
        // Insert total trash items to view
        view()->share('totalTrash', count($this->data->getTrash()));
    }

    public function trash(Request $request)
    {
        // Usual grid view stuff
        $searchTerm = $request->query('search');
        $page = $request->query('page');
        $sortColumn = $request->query('sort');
        $order = $request->query('order');

        // Initiate grid view but only with trashed items
        $grid = new GridView($this->data, true);
        $grid->setSearchTerm($searchTerm);
        $grid->setSortColumn($sortColumn, 'name'); // TODO: Sortcolumn name
        $grid->setPath($request->getPathInfo());
        $grid->setOrder($order, 'asc');

        // Setup view data
        $template = $grid->gridPage($page, 15);
        $template['pageTitle'] = 'Trash';
        
        return view($this->view, $template);
    }

    public function restore($id)
    {
        if ($this->data->restoreFromTrash($id)) {
            $this->alerts->alertSuccess('Item restored successfully!');
        }
        else {
            $this->alerts->alertError('Unable to restore an item!');
        }

        $this->alerts->getAlerts();

        return redirect('admin/opponents/trash');
    }

    public function remove($id)
    {
        if ($this->data->deleteFromTrash($id)) {
            $this->alerts->alertSuccess('Item and it\'s references successfully deleted!');
        }
        else {
            $this->alerts->alertError('Unable to delete an item!');
        }

        $this->alerts->getAlerts();

        return redirect('admin/opponents/trash');
    }

}