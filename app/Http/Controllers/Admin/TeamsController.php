<?php
namespace Comet\Http\Controllers\Admin;

use Exception;
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
        $data = $this->service->getTeams();

        return view('admin.teams.index')
            ->with('pageTitle', 'Squads')
            ->with('data', $data);
    }

    public function create()
    {
        $this->breadcrumbs->addCrumb('New', 'new');

        $games = $this->meta->getAllGames();

        return view('admin.teams.form')
            ->with('pageTitle', 'Create new squad')
            ->with('games', $games)
            ->with('team', null)
            ->with('history', null);
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
        } catch (Exception $e) {
            return $this->respondWithError($e->getMessage(), 500);
        }
    }

    public function edit($id)
    {
        $this->breadcrumbs->addCrumb('Edit squad', 'edit');

        $games = $this->meta->getAllGames();
        $history = $this->service->getTeamHistory($id);
        $team = $this->service->getTeam($id);

        return view('admin.teams.form')
            ->with('pageTitle', 'Editing a squad')
            ->with('games', $games)
            ->with('team', $team)
            ->with('history', $history);
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
        } catch (Exception $e) {
            return $this->respondWithError($e->getMessage(), 500);
        }
    }

    public function delete($id)
    {
        // TODO
    }

    public function get($teamID)
    {
        $data = $this->service->getTeam($teamID);

        return $this->respondWithItem($data, new TeamTransformer());
    }

    public function getHistory($teamID)
    {
        $data = $this->service->getTeamHistory($teamID);

        return $this->respondWithCollection($data, new TeamHistoryTransformer());
    }
}
