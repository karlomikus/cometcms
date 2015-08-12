<?php namespace App\Http\Controllers\Admin;

use App\Repositories\Contracts\TeamsRepositoryInterface as Teams;
use App\Repositories\Contracts\GamesRepositoryInterface as Games;
use App\Http\Requests\SaveTeamRequest;

class TeamsController extends AdminController {

    protected $teams;

    public function __construct(Teams $teams)
    {
        parent::__construct();
        $this->teams = $teams;
    }

    public function index()
    {
        $template = [
            'data'      => $this->teams->all(),
            'pageTitle' => 'Squads'
        ];

        return view('admin.teams.index', $template);
    }

    public function create(Games $games)
    {
        $template = [
            'team'      => null,
            'modelData' => 'null',
            'games'     => $games->all(),
            'pageTitle' => 'Create new squad',
            'history'   => null
        ];

        return view('admin.teams.form', $template);
    }

    public function save(SaveTeamRequest $request)
    {
        $data = $request->all();
        $team = $this->teams->insert($data);

        if ($team) {
            $this->alerts->alertSuccess('Squad saved successfully.');
        }
        else {
            $this->alerts->alertError('Unable to save a squad.');
        }

        return response()->json(['location' => '/admin/teams', 'alerts' => $this->alerts->getAlerts()]);
    }

    public function edit($id, Games $games)
    {
        $template = [
            'team'      => $this->teams->get($id),
            'pageTitle' => 'Editing an squad',
            'modelData' => $this->teams->getTeamData($id),
            'games'     => $games->all(),
            'history'   => $this->teams->getMembersHistory($id)
        ];

        return view('admin.teams.form', $template);
    }

    public function update($id, SaveTeamRequest $request)
    {
        $data = $request->all();
        $team = $this->teams->update($id, $data);

        if ($team) {
            $this->alerts->alertSuccess('Squad edited successfully.');
        }
        else {
            $this->alerts->alertError('Unable to edit a squad.');
        }

        return response()->json(['location' => '/admin/teams', 'alerts' => $this->alerts->getAlerts()]);
    }

    public function delete($id)
    {
        if ($this->teams->delete($id)) {
            $this->alerts->alertSuccess('Squad deleted successfully!');
        }
        else {
            $this->alerts->alertError('Unable to delete squad!');
        }

        $this->alerts->getAlerts();

        return redirect('admin/teams');
    }

    public function getRoster($teamID)
    {
        $data = $this->teams->getTeamData($teamID);

        return response()->json(['data' => $data]);
    }

}
