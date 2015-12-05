<?php namespace App\Http\Controllers\Admin;

use App\Repositories\Contracts\TeamsRepositoryInterface as Teams;
use App\Repositories\Contracts\GamesRepositoryInterface as Games;
use App\Http\Requests\SaveTeamRequest;
use App\Transformers\TeamMembersTransformer;
use App\Transformers\TeamTransformer;

class TeamsController extends AdminController
{
    use TraitApi;

    protected $teams;

    public function __construct(Teams $teams)
    {
        parent::__construct();
        $this->teams = $teams;
        $this->breadcrumbs->addCrumb('Squads', 'teams');
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
        $this->breadcrumbs->addCrumb('New', 'new');
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
        $team = $this->teams->insert($request->all());

        if ($team) {
            return $this->apiResponse(null, 'Squad saved successfully.', 200, '/admin/teams/edit/' . $team->id);
        }

        return $this->apiResponse(null, 'Error occured while saving a squad.', 500);
    }

    public function edit($id, Games $games)
    {
        $this->breadcrumbs->addCrumb('Edit squad', 'edit');
        $team = $this->teams->get($id);
        $template = [
            'team'      => $team,
            'pageTitle' => 'Editing a squad',
            'modelData' => $this->teams->getTeamData($id),
            'games'     => $games->all(),
            'history'   => $this->teams->getMembersHistory($id)
        ];

        return view('admin.teams.form', $template);
    }

    public function update($id, SaveTeamRequest $request)
    {
        $team = $this->teams->update($id, $request->all());

        if ($team) {
            $this->setMessage('Saved successfgllyl!');
            return $this->respondWithArray([]);
        }

        return $this->respondWithError('Error occured while updating a squad.', 500);
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

    public function get($teamID)
    {
        $data = $this->teams->getTeamData($teamID);
        $data['history'] = $this->teams->getMembersHistory($teamID);

        return $this->respondWithItem($data, new TeamTransformer());
    }

}
