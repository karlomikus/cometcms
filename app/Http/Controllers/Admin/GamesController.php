<?php namespace App\Http\Controllers\Admin;

use App\Libraries\GridView\GridView;
use App\Repositories\Contracts\GamesRepositoryInterface;
use Illuminate\Http\Request;

class GamesController extends AdminController {

    protected $games;

    public function __construct(GamesRepositoryInterface $games)
    {
        $this->games = $games;
    }

    public function index(Request $request)
    {
        $searchTerm = $request->query('search');
        $page = $request->query('page');
        $sortColumn = $request->query('sort');
        $order = $request->query('order');

        $grid = new GridView($this->games);
        $grid->setSearchTerm($searchTerm);
        $grid->setSortColumn($sortColumn, 'name');
        $grid->setPath($request->getPathInfo());
        $grid->setOrder($order, 'asc');

        $data = $grid->gridPage($page, 15);

        $data['pageTitle'] = 'Games';

        return view('admin.games.index', $data);
    }

    public function create()
    {
        $data['pageTitle'] = 'Create new game';

        return view('admin.games.form', $data);
    }

    public function save(Request $request)
    {
        
    }

    public function edit($id, GamesRepositoryInterface $games)
    {
        $data['game'] = $this->games->get($id);
        $data['pageTitle'] = 'Editing a game';

        return view('admin.games.form', $data);
    }

    public function update($id, Request $request)
    {
        
    }

    public function getRoster($teamID)
    {
        $data = $this->teams->getTeamData($teamID);

        return response()->json(['data' => $data]);
    }

}
