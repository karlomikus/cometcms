<?php
namespace App\Repositories\Contracts;

interface TeamsRepositoryInterface {

    /**
     * Get members of a specific team
     *
     * @param $teamID
     * @return mixed
     */
    public function getTeamRoster($teamID);

} 