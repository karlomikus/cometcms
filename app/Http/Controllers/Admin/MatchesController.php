<?php
namespace Comet\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Comet\Libraries\GridView\GridView;
use Comet\Http\Requests\SaveMatchRequest;
use Comet\Core\Contracts\Repositories\MapsRepositoryInterface as Maps;
use Comet\Core\Contracts\Repositories\GamesRepositoryInterface as Games;
use Comet\Core\Contracts\Repositories\TeamsRepositoryInterface as Teams;
use Comet\Core\Contracts\Repositories\MatchesRepositoryInterface as Matches;
use Comet\Core\Contracts\Repositories\OpponentsRepositoryInterface as Opponents;

class MatchesController extends AdminController {

    use TraitTrashable;

    protected $matches;

    public function __construct(Matches $matches)
    {
        parent::__construct();
        $this->matches = $matches;
        $this->trashInit($this->matches, 'admin/matches/trash', 'admin.matches.trash');
        $this->breadcrumbs->addCrumb('Matches', 'matches');
    }

    /**
     * Show matches list
     *
     * @param $request Request
     * @return mixed
     */
    public function index()
    {
        $grid = new GridView($this->matches);
        $data = $grid->gridPage(15);

        $data['pageTitle'] = 'Matches';

        return view('admin.matches.index', $data);
    }

    /**
     * Show match create form
     *
     * @param $teams Teams
     * @param $opponents Opponents
     * @param $games Games
     * @param $maps Maps
     * @return mixed
     */
    public function create(Teams $teams, Opponents $opponents, Games $games, Maps $maps)
    {
        $this->breadcrumbs->addCrumb('New', 'new');
        $data['teams'] = $teams->all();
        $data['opponents'] = $opponents->all();
        $data['games'] = $games->all();
        $data['maps'] = $maps->all();

        $data['matchJSON'] = 'null';
        $data['metaData'] = $games->allWithMaps()->toJson();
        $data['pageTitle'] = 'Create new match';

        return view('admin.matches.form', $data);
    }

    /**
     * Read json request and save match to database
     *
     * @param $request SaveMatchRequest
     * @return string JSON response containing redirect location and alert messages
     */
    public function save(SaveMatchRequest $request)
    {
        $data = $request->all();

        if ($this->matches->insert($data)) {
            $this->alerts->alertSuccess('Match saved successfully.');
        }
        else {
            $this->alerts->alertError('Unable to save a match.');
        }

        // Browsers are dumb and can't follow 302 redirect from ajax call
        // return redirect('admin/matches')->with('alerts', $this->getAlerts());
        // So we return JSON response containing location which we redirect to with js
        return response()->json(['location' => '/admin/matches', 'alerts' => $this->alerts->getAlerts()]);
    }

    public function edit($id, Teams $teams, Opponents $opponents, Games $games, Maps $maps)
    {
        $this->breadcrumbs->addCrumb('Edit', 'edit');
        $data['teams'] = $teams->all();
        $data['opponents'] = $opponents->all();
        $data['games'] = $games->all();
        $data['maps'] = $maps->all();

        $data['matchJSON'] = $this->matches->getMatchJson($id)->toJson();
        $data['metaData'] = $games->allWithMaps()->toJson();
        $data['pageTitle'] = 'Editing a match';

        return view('admin.matches.form', $data);
    }

    public function update($id, SaveMatchRequest $request)
    {
        $data = $request->all();

        if ($this->matches->update($id, $data))
            $this->alerts->alertSuccess('Match updated successfully.');
        else
            $this->alerts->alertError('Unable to update a match.');

        // Browsers are dumb and can't follow 302 redirect from ajax call
        // return redirect('admin/matches')->with('alerts', $this->getAlerts());
        // So we return JSON response containing location which we redirect to with js
        return response()->json(['location' => '/admin/matches', 'alerts' => $this->alerts->getAlerts()]);
    }

    public function delete($id)
    {
        if ($this->matches->delete($id)) {
            $this->alerts->alertSuccess('Match deleted succesfully!');
        }
        else {
            $this->alerts->alertError('Unable to delete a match!');
        }

        $this->alerts->getAlerts();

        return redirect('admin/matches');
    }

    public function getMatchJson($matchID)
    {
        $match = $this->matches->getMatchJson($matchID);

        return response()->json($match);
    }

    public function getMetaJson(Games $games)
    {
        $data = $games->allWithMaps();

        return response()->json($data);
    }

} 