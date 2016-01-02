<?php namespace Comet\Http\Controllers\Admin;

use Comet\Core\Services\TeamService;
use Comet\Core\Gateways\MetaGateway;
use Comet\Http\Requests\SaveTeamRequest;
use Comet\Core\Transformers\TeamTransformer;
use Comet\Core\Transformers\TeamHistoryTransformer;
use Comet\Core\Transformers\TeamMembersTransformer;

class TeamsController extends AdminController
{
    use TraitApi;

    private $service;

    private $meta;

    public function __construct(TeamService $service, MetaGateway $meta)
    {
        parent::__construct();

        $this->service = $service;
        $this->meta = $meta;
        $this->breadcrumbs->addCrumb('Squads', 'teams');
    }

    public function index()
    {
        $template = [
            'pageTitle' => 'Squads',
            'data'      => $this->service->getTeams(),
        ];

        return view('admin.teams.index', $template);
    }

    public function create()
    {
        $this->breadcrumbs->addCrumb('New', 'new');

        $template = [
            'pageTitle' => 'Create new squad',
            'games'     => $this->meta->getAllGames(),
            'team'      => null,
            'history'   => null
        ];

        return view('admin.teams.form', $template);
    }

    public function save(SaveTeamRequest $request)
    {
        try {
            $team = $this->service->addTeam(
                $request->get('name'),
                $request->get('gameId'),
                $request->get('description'),
                $request->get('roster'),
                $request->file('image')
            );
            $this->setMessage('Squad saved successfully!');

            return $this->respondWithItem($team, new TeamTransformer());
        }
        catch (\Exception $e) {
            return $this->respondWithError($e->getMessage(), 500);
        }
    }

    public function edit($id)
    {
        $this->breadcrumbs->addCrumb('Edit squad', 'edit');

        $template = [
            'pageTitle' => 'Editing a squad',
            'team'      => $this->service->getTeam($id),
            'history'   => $this->service->getTeamHistory($id),
            'games'     => $this->meta->getAllGames()
        ];

        return view('admin.teams.form', $template);
    }

    public function update($id, SaveTeamRequest $request)
    {
        try {
            $team = $this->service->updateTeam(
                $id,
                $request->get('name'),
                $request->get('gameId'),
                $request->get('description'),
                $request->get('roster')
            );
            $this->setMessage('Squad updated successfully!');

            return $this->respondWithItem($team, new TeamTransformer());
        }
        catch (\Exception $e) {
            return $this->respondWithError($e->getMessage(), 500);
        }
    }

    public function delete($id)
    {
        if ($this->service->delete($id)) {
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
        $data = $this->service->getTeamMembers($teamID); // TODO REFACTOR

        return $this->respondWithItem($data, new TeamTransformer());
    }

    public function getHistory($teamID)
    {
        $data = $this->service->getTeamHistory($teamID);

        return $this->respondWithCollection($data, new TeamHistoryTransformer());
    }
}
