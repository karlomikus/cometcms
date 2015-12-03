<?php
namespace App\Repositories;

use App\Repositories\Contracts\TeamsRepositoryInterface;
use App\Team;
use App\Libraries\ImageUploadTrait as ImageUpload;
use Carbon\Carbon;

/**
 * Teams repository
 *
 * @package App\Repositories
 */
class TeamsRepository extends AbstractRepository implements TeamsRepositoryInterface {

    use ImageUpload;

    /**
     * Initiate the repository with team model
     *
     * @param Team $team Model
     */
    public function __construct(Team $team)
    {
        parent::__construct($team);

        $this->setUploadPath(base_path() . '/public/uploads/squads/');
    }

    /**
     * Add members to specific team
     *
     * @param  array $data    Array with member data
     * @param  int   $teamID  ID of the team we are adding members to
     * @return void           Void since we use transaction in insert() method
     */
    public function insertMembers($data, $teamID)
    {
        // We go through each element since we need to get rid of garbage properties from client JSON
        foreach ($data as $member) {
            \DB::table('team_roster')->insert([
                'user_id'  => $member['id'],
                'team_id'  => $teamID,
                'position' => isset($member['pivot']['position']) ? $member['pivot']['position'] : null,
                'status'   => isset($member['pivot']['status']) ? $member['pivot']['status'] : null,
                'captain'  => isset($member['pivot']['captain']) ? $member['pivot']['captain'] : 0
            ]);
        }
    }

    /**
     * Add new team and team members.
     * Uses transactions, if transaction commits returns true.
     *
     * @param  array $data Array of data
     * @return bool        Was transaction commited
     */
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
            \Session::flash('exception', $e->getMessage());

            return false;
        }
        \DB::commit();

        return true;
    }

    /**
     * @param $id
     * @param $data
     * @return bool
     */
    public function update($id, $data)
    {
        try {
            \DB::beginTransaction();
            $teamModel = parent::update($id, $data);

            if ($teamModel) {
                //$this->deleteAllMembers($id);
                $this->updateMembers($data['roster'], $id);
            }
        }
        catch (\Exception $e) {
            \DB::rollback();
            \Session::flash('exception', $e->getMessage());

            dd($e);

            return false;
        }
        \DB::commit();

        return true;
    }

    /**
     * Delete all members from specific team
     *
     * @param  int $teamID Team ID
     * @return bool
     */
    public function deleteAllMembers($teamID)
    {
        return \DB::table('team_roster')
            ->where('team_id', '=', $teamID)
            ->whereNull('deleted_at')
            ->update(['deleted_at' => Carbon::now()->toDateTimeString()]);
    }

    /**
     * @param $teamID
     * @return bool
     */
    public function delete($teamID)
    {
        try {
            \DB::beginTransaction();
            $this->deleteAllMembers($teamID);
            parent::delete($teamID);
        }
        catch (\Exception $e) {
            \DB::rollback();

            \Session::flash('exception', $e->getMessage());

            return false;
        }

        \DB::commit();

        return true;
    }

    /**
     * @param $roster
     * @param $teamID
     */
    public function updateMembers($roster, $teamID)
    {
        $table = \DB::table('team_roster');

        // Get original team members user IDs and compare it to the ones we get from the form
        $orgMembers = array_pluck($table->where('team_id', $teamID)->whereNull('deleted_at')->get(['user_id']), 'user_id');
        $formMembers = array_pluck($roster, 'id');

        // If they are the same then we can just update the meta data
        if ($orgMembers === $formMembers) {
            foreach ($roster as $member) {
                \DB::table('team_roster')->where('id', $member['pivot']['id'])->update([
                    'position' => isset($member['pivot']['position']) ? $member['pivot']['position'] : null,
                    'status'   => isset($member['pivot']['status']) ? $member['pivot']['status'] : null,
                    'captain'  => isset($member['pivot']['captain']) ? $member['pivot']['captain'] : 0
                ]);
            }
        }
        else { // Else we need to soft delete old roster and create new one
            $this->deleteAllMembers($teamID);
            $this->insertMembers($roster, $teamID);
        }
    }

    /**
     * Get all roster changes since team creation
     *
     * @param $teamID
     * @return array
     */
    public function getMembersHistory($teamID)
    {
        $query = \DB::table('team_roster')
            ->where('team_roster.team_id', $teamID)
            ->whereNotNull('team_roster.deleted_at')
            ->join('users', 'team_roster.user_id', '=', 'users.id')
            ->get(['team_roster.position', 'team_roster.deleted_at as replaced', 'users.*']);

        // Group changes by date
        $group = [];
        foreach ($query as $val) {
            $group[Carbon::parse($val->replaced)->format('Y-m-d H:i')][] = $val;
        }

        return $group;
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
}