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

    public function insertMembers($data, $teamID)
    {
        // We go through each element since we need to get rid of garbage properties from client JSON
        foreach ($data as $member) {
            \DB::table('team_roster')->insert([
                'user_id' => $member['user_id'],
                'team_id' => $teamID,
                'position' => isset($member['position']) ?: null,
                'status' => isset($member['status']) ?: null,
                'captain' => isset($member['captain']) ?: 0
            ]);
        }
    }

    public function insert($data)
    {
        try {
            \DB::beginTransaction();
            $teamModel = parent::insert($data);

            if ($teamModel) {
                $this->insertMembers($data['members'], $teamModel->id);
            }
        }
        catch (\Exception $e) {
            \DB::rollback();

            return false;
        }
        \DB::commit();

        return true;
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