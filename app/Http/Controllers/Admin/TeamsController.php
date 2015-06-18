<?php namespace App\Http\Controllers\Admin;

use App\Libraries\GridView\GridView;
use App\Repositories\Contracts\TeamsRepositoryInterface;
use App\Repositories\Contracts\GamesRepositoryInterface;
use Illuminate\Http\Request;
use App\Http\Requests\SaveTeamRequest;

class TeamsController extends AdminController {

    protected $teams;

    public function __construct(TeamsRepositoryInterface $teams)
    {
        $this->teams = $teams;
    }

    public function index(Request $request)
    {
        $searchTerm = $request->query('search');

        $data['data'] = $this->teams->all();

        $data['pageTitle'] = 'Squads';

        return view('admin.teams.index', $data);
    }

    public function create(GamesRepositoryInterface $games)
    {
        $data['team'] = null;
        $data['modelData'] = 'null';
        $data['games'] = $games->all();

        $data['pageTitle'] = 'Create new squad';

        return view('admin.teams.form', $data);
    }

    public function save(SaveTeamRequest $request)
    {
        $data = $request->all();
        $team = $this->teams->insert($data);

        if ($team) {
            $this->alertSuccess('Squad saved successfully.');
        }
        else {
            $this->alertError('Unable to save a squad.');
        }

        \Session::flash('alerts', $this->getAlerts());

        // Browsers are dumb and can't follow 302 redirect from ajax call
        // So we return JSON response containing location which we redirect to with js
        return response()->json(['location' => '/admin/teams', 'alerts' => $this->getAlerts()]);
    }

    public function edit($id, GamesRepositoryInterface $games)
    {
        $data['team'] = $this->teams->get($id);
        $data['pageTitle'] = 'Editing an squad';

        $data['modelData'] = $this->teams->getTeamData($id);
        $data['games'] = $games->all();

        return view('admin.teams.form', $data);
    }

    public function update($id, SaveTeamRequest $request)
    {
        $data = $request->all();
        $team = $this->teams->update($id, $data);

        if ($team) {
            $this->alertSuccess('Squad edited successfully.');
        }
        else {
            $this->alertError('Unable to edit a squad.');
        }

        \Session::flash('alerts', $this->getAlerts());

        // Browsers are dumb and can't follow 302 redirect from ajax call
        // So we return JSON response containing location which we redirect to with js
        return response()->json(['location' => '/admin/teams', 'alerts' => $this->getAlerts()]);
    }

    public function getRoster($teamID)
    {
        $data = $this->teams->getTeamData($teamID);

        return response()->json(['data' => $data]);
    }

}
