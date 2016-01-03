<?php
namespace Comet\Core\Contracts\Repositories;

use Symfony\Component\HttpFoundation\File\UploadedFile;

interface TeamsRepositoryInterface
{
    /**
     * Add members to specific team
     *
     * @param array $data
     * @param int $teamID
     * @throws TeamException
     * @return void
     */
    public function insertMembers(array $data, $teamID);

    /**
     * @param $roster
     * @param $teamID
     */
    public function updateMembers($roster, $teamID);

    /**
     * Delete all members from specific team
     *
     * @param  int $teamID Team ID
     * @return bool
     */
    public function deleteAllMembers($teamID);

    /**
     * Get all roster changes since team creation
     *
     * @param $teamID
     * @return array
     */
    public function getMembersHistory($teamID);

    /**
     * Get user ID's of all team members
     *
     * @param  int $teamID
     * @return array
     */
    public function getTeamMembersUserIDs($teamID);

    /**
     * Compare changes of current roster with given roster
     *
     * @param  int  $teamID
     * @param  array  $roster
     * @return boolean
     */
    public function hasRosterChanges($teamID, $roster);
}
