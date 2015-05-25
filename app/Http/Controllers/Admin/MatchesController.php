<?php
namespace App\Http\Controllers\Admin;

use App\Repositories\Contracts\GamesRepositoryInterface;
use App\Repositories\Contracts\MapsRepositoryInterface;
use App\Repositories\Contracts\MatchesRepositoryInterface;
use App\Repositories\Contracts\TeamsRepositoryInterface;
use App\Repositories\Contracts\OpponentsRepositoryInterface;
use Illuminate\Http\Request;
use App\Libraries\GridView\GridView;

class MatchesController extends AdminController {

    protected $matches;

    public function __construct(MatchesRepositoryInterface $matches)
    {
        $this->matches = $matches;
    }
    /**
     * Show matches list
     * 
     * @param $request Request
     * @return void
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
        $grid->setSortColumn($sortColumn, 'created_at');
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
     * @return void
     */
    public function create(TeamsRepositoryInterface $teams, OpponentsRepositoryInterface $opponents, GamesRepositoryInterface $games, MapsRepositoryInterface $maps)
    {
        $data['teams'] = $teams->all();
        $data['opponents'] = $opponents->all();
        $data['games'] = $games->all();
        $data['maps'] = $maps->all();

        $data['pageTitle'] = 'Create new match';

        return view('admin.matches.form', $data);
    }

    /**
     * Read json request and save match to database
     * 
     * @param $request Request
     * @return string JSON response containing redirect location and alert messages
     */
    public function save(Request $request)
    {
        $data = json_decode($request->input('data'));

        if($this->matches->insert($data))
            $this->alertSuccess('Match saved successfully.');
        else
            $this->alertError('Unable to save a match.');

        \Session::flash('alerts', $this->getAlerts());

        // Browsers are dumb and can't follow 302 redirect from ajax call
        // return redirect('admin/matches')->with('alerts', $this->getAlerts());
        // So we return JSON response containing location which we redirect to with js
        return response()->json(['location' => '/admin/matches', 'alerts' => $this->getAlerts()]);
    }

    public function edit($id, TeamsRepositoryInterface $teams, OpponentsRepositoryInterface $opponents, GamesRepositoryInterface $games, MapsRepositoryInterface $maps)
    {
        $data['teams'] = $teams->all();
        $data['opponents'] = $opponents->all();
        $data['games'] = $games->all();
        $data['maps'] = $maps->all();

        $data['pageTitle'] = 'Editing a match';

        return view('admin.matches.form', $data);
    }

    public function update($id, Request $request)
    {
        $data = json_decode($request->input('data'));

        if($this->matches->update($id, $data))
            $this->alertSuccess('Match updated successfully.');
        else
            $this->alertError('Unable to update a match.');

        \Session::flash('alerts', $this->getAlerts());

        // Browsers are dumb and can't follow 302 redirect from ajax call
        // return redirect('admin/matches')->with('alerts', $this->getAlerts());
        // So we return JSON response containing location which we redirect to with js
        return response()->json(['location' => '/admin/matches', 'alerts' => $this->getAlerts()]);
    }

    public function delete($id)
    {
        try {
            $this->matches->delete($id);
            $this->alertSuccess('Match deleted succesfully!');
        }
        catch (Exception $e) {
            $this->alertError('Unable to delete a match due to an exception: ' . $e->getMessage());
        }

        return redirect('admin/matches')->with('alerts', $this->getAlerts());
    }

    public function getMatchJson($matchID)
    {
        $match = $this->matches->getMatchJson($matchID);

        return response()->json($match);
    }

} 