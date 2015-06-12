<?php
namespace App\Repositories;

use App\Libraries\GridView\GridViewInterface;
use App\Repositories\Contracts\TeamsRepositoryInterface;
use App\Team;

class TeamsRepository extends AbstractRepository implements TeamsRepositoryInterface {

    public function __construct(Team $team)
    {
        parent::__construct($team);
    }

    /**
     * Get members of a specific team
     *
     * @param $teamID
     * @return mixed
     */
    public function getTeamData($teamID)
    {
        return $this->model->where('id', '=', $teamID)->with('roster')->first();
    }

    public function getTeamRoster($teamID)
    {

    }
}