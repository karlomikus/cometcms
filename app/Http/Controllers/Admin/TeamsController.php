<?php
namespace Comet\Http\Controllers\Admin;

use Exception;
use Comet\Core\Team\TeamService;
use Comet\Core\Gateways\MetaGateway;
use Comet\Http\Requests\SaveTeamRequest;
use Comet\Core\Team\Transformers\TeamTransformer;
use Comet\Core\Team\Transformers\TeamHistoryTransformer;
use Comet\Core\Team\Transformers\TeamMembersTransformer;

/**
 * Teams (Squads) Controller
 *
 * @package Comet\Http\Controllers\Admin
 * @author Karlo Mikus <contact@karlomikus.com>
 */
class TeamsController extends AdminController
{
    use TraitApi;

    /**
     * Team Service
     *
     * @var TeamServiceInterface
     */
    private $service;

    /**
     * Aggregate Service
     *
     * @var AggregateServiceInterface
     */
    private $aggregate;

    /**
     * Create a controller instance
     *
     * @param TeamService $service
     * @param MetaGateway $aggregate
     */
    public function __construct(TeamService $service, MetaGateway $aggregate)
    {
        parent::__construct();

        $this->service = $service;
        $this->aggregate = $aggregate;
        $this->breadcrumbs->addCrumb('Squads', 'teams');
    }

    /**
     * List all squads
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = $this->service->getTeams();

        return view('admin.teams.index')
            ->with('pageTitle', 'Squads')
            ->with('data', $data);
    }

    /**
     * Show create new squad form
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->breadcrumbs->addCrumb('New', 'new');

        $games = $this->aggregate->getAllGames();

        return view('admin.teams.form')
            ->with('pageTitle', 'Create new squad')
            ->with('games', $games)
            ->with('team', null)
            ->with('history', null);
    }

    /**
     * Save a squad
     *
     * @param  SaveTeamRequest $request
     * @return \Illuminate\Http\Response
     */
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

    /**
     * Show edit squad form
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->breadcrumbs->addCrumb('Edit squad', 'edit');

        $games = $this->aggregate->getAllGames();
        $history = $this->service->getTeamHistory($id);
        $team = $this->service->getTeam($id);

        return view('admin.teams.form')
            ->with('pageTitle', 'Editing a squad')
            ->with('games', $games)
            ->with('team', $team)
            ->with('history', $history);
    }

    /**
     * Update a squad
     *
     * @param  int $id
     * @param  SaveTeamRequest $request
     * @return \Illuminate\Http\Response
     */
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

    /**
     * Delete a team
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        // TODO
    }

    /**
     * Get a team data
     *
     * @param  int $teamID
     * @return \Illuminate\Http\Response
     */
    public function get($teamID)
    {
        $data = $this->service->getTeam($teamID);

        return $this->respondWithItem($data, new TeamTransformer());
    }

    /**
     * Get squad members history
     *
     * @param  int $teamID
     * @return \Illuminate\Http\Response
     */
    public function getHistory($teamID)
    {
        $data = $this->service->getTeamHistory($teamID);

        return $this->respondWithCollection($data, new TeamHistoryTransformer());
    }
}
