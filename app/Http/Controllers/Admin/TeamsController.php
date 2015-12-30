<?php namespace Comet\Http\Controllers\Admin;

use Comet\Core\Gateways\TeamGateway;
use Comet\Core\Gateways\MetaGateway;
use Comet\Http\Requests\SaveTeamRequest;
use Comet\Core\Transformers\TeamTransformer;
use Comet\Core\Transformers\TeamHistoryTransformer;
use Comet\Core\Transformers\TeamMembersTransformer;

class TeamsController extends AdminController
{
    use TraitApi;

    private $gateway;

    private $meta;

    public function __construct(TeamGateway $gateway, MetaGateway $meta)
    {
        parent::__construct();

        $this->gateway = $gateway;
        $this->meta = $meta;
        $this->breadcrumbs->addCrumb('Squads', 'teams');
    }

    public function index()
    {
        $template = [
            'pageTitle' => 'Squads',
            'data'      => $this->gateway->getTeams(),
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
            $team = $this->gateway->addTeam(
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
            'team'      => $this->gateway->getTeam($id),
            'history'   => $this->gateway->getTeamHistory($id),
            'games'     => $this->meta->getAllGames()
        ];

        return view('admin.teams.form', $template);
    }

    public function update($id, SaveTeamRequest $request)
    {
        try {
            $team = $this->gateway->updateTeam(
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
        if ($this->gateway->delete($id)) {
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
        $data = $this->gateway->getTeamMembers($teamID); // TODO REFACTOR

        return $this->respondWithItem($data, new TeamTransformer());
    }

    public function getHistory($teamID)
    {
        $data = $this->gateway->getTeamHistory($teamID);

        return $this->respondWithCollection($data, new TeamHistoryTransformer());
    }
}
