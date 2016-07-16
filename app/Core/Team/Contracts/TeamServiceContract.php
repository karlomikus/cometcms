<?php
namespace Comet\Core\Team\Contracts;

use Illuminate\Http\UploadedFile;

/**
 * Team Service Contract
 *
 * @package Comet\Core\Team\Contracts
 */
interface TeamServiceContract
{
    /**
     * Fetch all teams
     *
     * @return Collection
     */
    public function getTeams();

    /**
     * Get a team by it's identifier
     *
     * @param  int $id
     * @return Team
     */
    public function getTeam($id);

    /**
     * Fetch team's member history
     *
     * @param  int $id
     * @return Collection
     */
    public function getTeamHistory($id);

    /**
     * Fetch team's roster
     *
     * @param  int $id
     * @return Collection
     */
    public function getTeamMembers($id);

    /**
     * Create a new team with its members
     *
     * @param string $name
     * @param int $gameId
     * @param string $description
     * @param array $roster
     * @param File|null $image
     * @throws TeamException
     * @return Team
     */
    public function addTeam($name, $gameId, $description, $roster, $image = null);

    /**
     * Uploads and inserts image to database
     *
     * @param int $id Model entity ID
     * @param UploadedFile $file File object
     * @return bool
     */
    public function updateTeamImage($id, UploadedFile $file);

    /**
     * Update a team
     *
     * @param  int $id
     * @param  string $name
     * @param  int $gameId
     * @param  string $description
     * @param  array $roster
     * @return Team
     */
    public function updateTeam($id, $name, $gameId, $description, $roster);

    /**
     * Compare changes of current roster with given roster
     *
     * @param  int  $teamID
     * @param  array  $roster
     * @return boolean
     */
    public function hasRosterChanges($teamID, $roster);
}
