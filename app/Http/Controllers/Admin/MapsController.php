<?php
namespace App\Http\Controllers\Admin;

use App\Libraries\GridView\GridView;
use App\Repositories\Contracts\MapsRepositoryInterface;
use Illuminate\Http\Request;

final class MapsController extends AdminController {

    protected $maps;

    public function __construct(MapsRepositoryInterface $maps)
    {
        $this->maps = $maps;
    }

    public function index(Request $request)
    {
        $searchTerm = $request->query('search');
        $page = $request->query('page');
        $sortColumn = $request->query('sort');
        $order = $request->query('order');

        $grid = new GridView($this->maps);
        $grid->setOrder($order, 'asc');
        $grid->setSearchTerm($searchTerm);
        $grid->setSortColumn($sortColumn, 'name');
        $grid->setPath($request->getPathInfo());

        $data = $grid->gridPage($page, 15);

        $data['pageTitle'] = 'Game maps';

        return view('admin.maps.index', $data);
    }

}