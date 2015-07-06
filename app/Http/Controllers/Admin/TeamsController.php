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

    public function index()
    {
        $template = [
            'data' => $this->teams->all(),
            'pageTitle' => 'Squads'
        ];

        return view('admin.teams.index', $template);
    }

    public function create(GamesRepositoryInterface $games)
    {
        $template = [
            'team' => null,
            'modelData' => 'null',
            'games' => $games->all(),
            'pageTitle' => 'Create new squad'
        ];

        return view('admin.teams.form', $template);
    }

    public function save(SaveTeamRequest $request)
    {
        $data = $request->all();
        $team = $this->teams->insert($data);

        if ($team) {
            $this->alertSuccess('Squad saved successfully.');
        } else {
            $this->alertError('Unable to save a squad.');
        }

        return response()->json(['location' => '/admin/teams', 'alerts' => $this->getAlerts()]);
    }

    public function edit($id, GamesRepositoryInterface $games)
    {
        $template = [
            'team' => $this->teams->get($id),
            'pageTitle' => 'Editing an squad',
            'modelData' => $this->teams->getTeamData($id),
            'games' => $games->all(),
        ];

        return view('admin.teams.form', $template);
    }

    public function update($id, SaveTeamRequest $request)
    {
        $data = $request->all();
        $team = $this->teams->update($id, $data);

        if ($team) {
            $this->alertSuccess('Squad edited successfully.');
        } else {
            $this->alertError('Unable to edit a squad.');
        }
        
        return response()->json(['location' => '/admin/teams', 'alerts' => $this->getAlerts()]);
    }

    public function delete($id)
    {
        if ($this->teams->delete($id))
            $this->alertSuccess('Squad deleted succesfully!');
        else
            $this->alertError('Unable to delete squad!');

        return redirect('admin/teams')->with('alerts', $this->getAlerts());
    }

    public function getRoster($teamID)
    {
        $data = $this->teams->getTeamData($teamID);

        return response()->json(['data' => $data]);
    }

}
