<?php
namespace App\Repositories;

use App\Repositories\Contracts\TeamsRepositoryInterface;
use App\Team;
use App\Libraries\ImageUploadTrait as ImageUpload;
use Carbon\Carbon;
use DB;

/**
 * Teams repository
 *
 * @package App\Repositories
 */
class TeamsRepository extends AbstractRepository implements TeamsRepositoryInterface
{

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
     * @param  array $data Array with member data
     * @param  int $teamID ID of the team we are adding members to
     * @return void           Void since we use transaction in insert() method
     */
    public function insertMembers($data, $teamID)
    {
        // We go through each element since we need to get rid of garbage properties from client JSON
        foreach ($data as $member) {
            DB::table('team_roster')->insert([
                'user_id'  => $member['userId'],
                'team_id'  => $teamID,
                'position' => isset($member['position']) ? $member['position'] : null,
                'status'   => isset($member['status']) ? $member['status'] : null,
                'captain'  => isset($member['captain']) ? (int) $member['captain'] : 0
            ]);
        }
    }

    /**
     * Add new team and team members.
     *
     * @param  array $data
     * @return Team Created team model instance
     */
    public function insert($data)
    {
        $transaction = DB::transaction(function () use ($data) {
            $teamModel = parent::insert($data);

            if (!$teamModel) {
                throw new \Exception('Unable to create a squad!');
            }

            $this->insertMembers($data['roster'], $teamModel->id);

            return $teamModel;
        });

        return $transaction;
    }

    /**
     * @param $id
     * @param $data
     * @return bool
     */
    public function update($id, $data)
    {
        $transaction = DB::transaction(function () use ($id, $data) {
            $teamModel = parent::update($id, $data);

            if (!$teamModel) {
                throw new \Exception('Unable to update a squad!');
            }

            $this->updateMembers($data['roster'], $id);

            return $teamModel;
        });

        return $transaction;
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
        $formMembers = array_pluck($roster, 'userId');

        // If they are the same then we can just update the meta data
        if ($orgMembers === $formMembers) {
            foreach ($roster as $member) {
                \DB::table('team_roster')->where('id', $member['id'])->update([
                    'position' => isset($member['position']) ? $member['position'] : null,
                    'status'   => isset($member['status']) ? $member['status'] : null,
                    'captain'  => isset($member['captain']) ? (int) $member['captain'] : 0
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
            ->get(['team_roster.position', 'team_roster.captain', 'team_roster.deleted_at as replaced', 'users.*']);

        return $query;
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