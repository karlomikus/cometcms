<?php
namespace Comet\Core\Team;

use DB;
use Carbon\Carbon;
use Comet\Core\Team\Team;
use Comet\Core\Team\Exceptions\TeamException;
use Comet\Core\Common\EloquentRepository;
use Comet\Libraries\ImageUploadTrait as ImageUpload;
use Comet\Core\Contracts\Repositories\TeamsRepositoryInterface;

/**
 * Teams repository
 *
 * @package Comet\Repositories
 */
class TeamsRepository extends EloquentRepository implements TeamsRepositoryInterface
{
    use ImageUpload;

    /**
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
     * @param  array $data
     * @param  int $teamID
     * @throws TeamException
     * @return void
     */
    public function insertMembers(array $data, $teamID)
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
                throw new TeamException('Unable to create a squad!');
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
                throw new TeamException('Unable to update a squad!');
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
        $deletedAt = Carbon::now()->toDateTimeString();

        return DB::table('team_roster')
            ->where('team_id', '=', $teamID)
            ->whereNull('deleted_at')
            ->update(['deleted_at' => $deletedAt]);
    }

    /**
     * Delete a team and all it's members
     *
     * @param $teamID
     * @return bool
     */
    public function delete($teamID)
    {
        $transaction = DB::transaction(function () use ($teamID) {
            $this->deleteAllMembers($teamID);

            return parent::delete($teamID);
        });

        return $transaction;
    }

    /**
     * Update members or create new roster
     *
     * @param $roster
     * @param $teamID
     */
    public function updateMembers($roster, $teamID)
    {
        // Just update current roster info if there are no roster changes
        if (!$this->hasRosterChanges($teamID, $roster)) {
            foreach ($roster as $member) {
                DB::table('team_roster')->where('id', $member['id'])->update([
                    'position' => isset($member['position']) ? $member['position'] : null,
                    'status'   => isset($member['status']) ? $member['status'] : null,
                    'captain'  => isset($member['captain']) ? (int) $member['captain'] : 0
                ]);
            }
        } else { // Soft delete the old roster and create a new one
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
        $query = DB::table('team_roster')
            ->where('team_roster.team_id', $teamID)
            ->whereNotNull('team_roster.deleted_at')
            ->join('users', 'team_roster.user_id', '=', 'users.id')
            ->join('users_profiles as profile', 'profile.user_id', '=', 'users.id')
            ->get([
                'team_roster.position',
                'team_roster.captain',
                'team_roster.status',
                'team_roster.deleted_at as replaced',
                'profile.first_name',
                'profile.last_name',
                'profile.user_id'
            ]);

        return $query;
    }

    /**
     * Get user ID's of all team members
     *
     * @param  int $teamID
     * @return array
     */
    public function getTeamMembersUserIDs($teamID)
    {
        $table = DB::table('team_roster');

        return array_pluck($table->where('team_id', $teamID)->whereNull('deleted_at')->get(['user_id']), 'user_id');
    }

    /**
     * Compare changes of current roster with given roster
     *
     * @param  int  $teamID
     * @param  array  $roster
     * @return boolean
     */
    public function hasRosterChanges($teamID, $roster)
    {
        $currentMembers = $this->getTeamMembersUserIDs($teamID);
        $newMembers = array_pluck($roster, 'userId');

        return !($currentMembers == $newMembers);
    }
}
