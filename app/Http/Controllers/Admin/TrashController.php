<?php namespace App\Http\Controllers\Admin;

use App\Libraries\GridView\GridView;
use App\Repositories\Contracts\OpponentsRepositoryInterface;
use Illuminate\Http\Request;

class TrashController extends AdminController {

    private $opponents;

    public function __construct(OpponentsRepositoryInterface $opponents)
    {
        parent::__construct();
        $this->opponents = $opponents;
    }

    public function index($module, Request $request)
    {
        $searchTerm = $request->query('search');
        $page = $request->query('page');
        $sortColumn = $request->query('sort');
        $order = $request->query('order');

        $grid = new GridView($this->opponents);
        $grid->setSearchTerm($searchTerm);
        $grid->setSortColumn($sortColumn, 'name');
        $grid->setPath($request->getPathInfo());
        $grid->setOrder($order, 'asc');

        $data = $grid->gridPage($page, 15);

        $data['pageTitle'] = 'Trash';

        return view('admin.trash.index', $data);
    }

}
