<?php namespace App\Http\Controllers\Admin;

use App\Libraries\GridView\GridView;
use App\Repositories\Contracts\GamesRepositoryInterface;
use App\Repositories\Contracts\MapsRepositoryInterface;
use Illuminate\Http\Request;
use App\Http\Requests\SaveGameRequest;
use Illuminate\Support\Str;
use App\Http\Controllers\Admin\TraitTrashable as Trash;

class GamesController extends AdminController {

    use Trash;

    protected $games;

    public function __construct(GamesRepositoryInterface $games)
    {
        parent::__construct();

        $this->games = $games;
        $this->trashInit($this->games, 'admin/games/trash', 'admin.games.trash');
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
        $template = [
            'pageTitle' => 'Create new game',
            'maps' => 'null',
            'model' => null
        ];

        return view('admin.games.form', $template);
    }

    public function save(SaveGameRequest $request, MapsRepositoryInterface $maps)
    {
        $code = Str::slug($request->input('code'));

        $game = $this->games->insert([
            'name'  => $request->input('name'),
            'code'  => $code,
            'image' => null
        ]);
        $formMaps = $request->input('mapname');

        if ($game) {
            if ($request->hasFile('image')) {
                $this->games->insertImage($game->id, $request->file('image'));
            }
            // Insert maps
            if ($request->has('mapname')) {
                $maps->insertMaps($formMaps, $game->id, $request->file('mapimage'));
            }
            else { // Insert default map
                $maps->insertMap('Default map', $game->id);
            }

            $this->alerts->alertSuccess('New game created successfully!');
        }
        else {
            $this->alerts->alertError('Game creation failed!');
        }

        $this->alerts->getAlerts();

        return redirect('admin/games');
    }

    public function edit($id, MapsRepositoryInterface $maps)
    {
        $template['pageTitle'] = 'Editing a game';
        $template['maps'] = $maps->getByGame($id)->toJson();
        $template['model'] = $this->games->get($id);

        return view('admin.games.form', $template);
    }

    public function update($id, SaveGameRequest $request, MapsRepositoryInterface $maps)
    {
        $code = Str::slug($request->input('code'));

        $game = $this->games->update($id, [
            'name' => $request->input('name'),
            'code' => $code
        ]);

        if ($game) {
            if ($request->hasFile('image')) {
                $this->games->updateImage($id, $request->file('image'));
            }

            if ($request->has('mapname')) {
                $maps->updateMaps($request->input('mapname'), $request->input('mapid'), $id, $request->file('mapimage'));
            }

            $this->alerts->alertSuccess('Game edited successfully!');
        }
        else {
            $this->alerts->alertError('Game edit failed!');
        }

        $this->alerts->getAlerts();

        return redirect('admin/games');
    }

    public function delete($gameID)
    {
        if ($this->games->delete($gameID)) {
            $this->alerts->alertSuccess('Game moved to trash succesfully!');
        }
        else {
            $this->alerts->alertError('Unable to trash a game!');
        }

        $this->alerts->getAlerts();

        return redirect('admin/games');
    }

}
