<?php
namespace App\Http\Controllers\Admin;

use App\Repositories\Contracts\GamesRepositoryInterface;
use App\Repositories\Contracts\MapsRepositoryInterface;
use App\Repositories\Contracts\MatchesRepositoryInterface;
use App\Repositories\Contracts\TeamsRepositoryInterface;
use App\Repositories\Contracts\OpponentsRepositoryInterface;
use Illuminate\Http\Request;
use App\Http\Requests\SaveMatchRequest;
use App\Libraries\GridView\GridView;

class MatchesController extends AdminController {

    protected $matches;

    public function __construct(MatchesRepositoryInterface $matches)
    {
        parent::__construct();
        $this->matches = $matches;
    }
    /**
     * Show matches list
     * 
     * @param $request Request
     * @return mixed
     */
    public function index(Request $request)
    {
        $searchTerm = $request->query('search');
        $page       = $request->query('page');
        $sortColumn = $request->query('sort');
        $order      = $request->query('order');

        $grid = new GridView($this->matches);
        $grid->setOrder($order, 'desc');
        $grid->setSearchTerm($searchTerm);
        $grid->setSortColumn($sortColumn, 'date');
        $grid->setPath($request->getPathInfo());

        $data = $grid->gridPage($page, 15);

        $data['pageTitle'] = 'Matches';

        return view('admin.matches.index', $data);
    }

    /**
     * Show match create form
     * 
     * @param $teams TeamsRepositoryInterface
     * @param $opponents OpponentsRepositoryInterface
     * @param $games GamesRepositoryInterface
     * @param $maps MapsRepositoryInterface
     * @return mixed
     */
    public function create(TeamsRepositoryInterface $teams, OpponentsRepositoryInterface $opponents, GamesRepositoryInterface $games, MapsRepositoryInterface $maps)
    {
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

        if($this->matches->insert($data)) {
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

    public function edit($id, TeamsRepositoryInterface $teams, OpponentsRepositoryInterface $opponents, GamesRepositoryInterface $games, MapsRepositoryInterface $maps)
    {
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

        if($this->matches->update($id, $data))
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

    public function getMetaJson(GamesRepositoryInterface $games)
    {
        $data = $games->allWithMaps();

        return response()->json($data);
    }

} 