<?php namespace Comet\Http\Controllers\Admin;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Comet\Libraries\GridView\GridView;
use Comet\Http\Requests\SaveGameRequest;
use Comet\Core\Transformers\GameTransformer;
use Comet\Http\Controllers\Admin\TraitTrashable as Trash;
use Comet\Core\Contracts\Repositories\GamesRepositoryInterface as Games;
use Comet\Core\Contracts\Repositories\MapsRepositoryInterface as Maps;

/**
 * Games Controller
 *
 * @package Comet\Http\Controllers\Admin
 */
class GamesController extends AdminController {

    use Trash, TraitApi;

    /**
     * @var Games
     */
    protected $games;

    /**
     * @param Games $games
     */
    public function __construct(Games $games)
    {
        parent::__construct();

        $this->games = $games;
        $this->trashInit($this->games, 'admin/games/trash', 'admin.games.trash');
        $this->breadcrumbs->addCrumb('Games', 'games');
    }

    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $grid = new GridView($this->games);
        $data = $grid->gridPage(15);

        $data['pageTitle'] = 'Games';

        return view('admin.games.index', $data);
    }

    /**
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $this->breadcrumbs->addCrumb('New', 'new');
        $template = [
            'pageTitle' => 'Create new game',
            'maps'      => 'null',
            'model'     => null
        ];

        return view('admin.games.form', $template);
    }

    /**
     * @param SaveGameRequest $request
     * @param Maps $maps
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function save(SaveGameRequest $request, Maps $maps)
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

    /**
     * @param $id
     * @param Maps $maps
     * @return \Illuminate\View\View
     */
    public function edit($id, Maps $maps)
    {
        $this->breadcrumbs->addCrumb('Edit', 'edit');
        $template['pageTitle'] = 'Editing a game';
        $template['maps'] = $maps->getByGame($id)->toJson();
        $template['model'] = $this->games->get($id);

        return view('admin.games.form', $template);
    }

    /**
     * @param $id
     * @param SaveGameRequest $request
     * @param Maps $maps
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update($id, SaveGameRequest $request, Maps $maps)
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

    /**
     * @param $gameID
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function delete($gameID)
    {
        if ($this->games->delete($gameID)) {
            $this->alerts->alertSuccess('Game moved to trash successfully!');
        }
        else {
            $this->alerts->alertError('Unable to trash a game!');
        }

        $this->alerts->getAlerts();

        return redirect('admin/games');
    }

    public function getAll()
    {
        $games = $this->games->all();

        return $this->respondWithCollection($games, new GameTransformer());
    }
}
