<?php
namespace App\Repositories;

use App\Libraries\GridView\GridViewInterface;
use App\Repositories\Contracts\TeamsRepositoryInterface;
use App\Team;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use App\Libraries\ImageUploadTrait as ImageUpload;

class TeamsRepository extends AbstractRepository implements TeamsRepositoryInterface {

    use ImageUpload;

    private $uploadPath;

    /**
     * Initiate the repository with team model
     *
     * @param Team $team Model
     */
    public function __construct(Team $team)
    {
        parent::__construct($team);

        $this->uploadPath = base_path() . '/public/uploads/squads/';
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
            \DB::table('team_roster')->insert([
                'user_id'  => $member['user_id'],
                'team_id'  => $teamID,
                'position' => isset($member['position']) ? $member['position'] : null,
                'status'   => isset($member['status']) ? $member['status'] : null,
                'captain'  => isset($member['captain']) ? $member['captain'] : 0
            ]);
        }
    }

    /**
     * Add new team and team members. Uses transactions, if transaction commits returns true.
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
        } catch (\Exception $e) {
            \DB::rollback();

            \Session::flash('exception', $e->getMessage());

            return false;
        }
        \DB::commit();

        return true;
    }

    public function update($id, $data)
    {
        try {
            \DB::beginTransaction();
            $teamModel = parent::update($id, $data);

            if ($teamModel) {
                //$this->deleteAllMembers($id);
                $this->updateMembers($data['members']);
            }
        } catch (\Exception $e) {
            \DB::rollback();

            \Session::flash('exception', $e->getMessage());

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
        return \DB::table('team_roster')->where('team_id', '=', $teamID)->delete();
    }

    public function delete($teamID)
    {
        try {
            \DB::beginTransaction();
            $this->deleteAllMembers($teamID);
            parent::delete($teamID);
        } catch (\Exception $e) {
            \DB::rollback();

            \Session::flash('exception', $e->getMessage());

            return false;
        }

        \DB::commit();

        return true;
    }

    public function updateMembers($roster)
    {
        $table = \DB::table('team_roster');
        $orgMembers = $table->where('id', $member['member_id'])->get(['user_id']);
        foreach ($roster as $member) {
            $table
            ->where('id', $member['member_id'])
            ->update([
                'position' => isset($member['position']) ? $member['position'] : null,
                'status'   => isset($member['status']) ? $member['status'] : null,
                'captain'  => isset($member['captain']) ? $member['captain'] : 0
            ]);
        }
    }

    public function getMembersHistory($teamID)
    {
        return \DB::table('team_roster')
                ->where('team_roster.team_id', $teamID)
                ->whereNotNull('team_roster.deleted_at')
                ->join('users', 'team_roster.user_id', '=', 'users.id')
                ->get(['team_roster.position', 'team_roster.deleted_at as replaced', 'users.*']);
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