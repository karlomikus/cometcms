<?php
namespace Comet\Core\Team;

use Comet\Core\Team\Exceptions\TeamException;
use Comet\Core\Team\Contracts\TeamServiceContract;
use Comet\Core\Contracts\Repositories\TeamsRepositoryInterface;

/**
 * Team Service
 *
 * @package Comet\Core\Team
 */
class TeamService implements TeamServiceContract
{
    private $teams;

    /**
     * @param Teams $teams Teams repository
     */
    public function __construct(TeamsRepositoryInterface $teams)
    {
        $this->teams = $teams;
    }

    /**
     * Fetch all teams
     *
     * @return Collection
     */
    public function getTeams()
    {
        return $this->teams->all();
    }

    /**
     * Get a team by it's identifier
     *
     * @param  int $id
     * @return Team
     */
    public function getTeam($id)
    {
        return $this->teams->get($id);
    }

    /**
     * Fetch team's member history
     *
     * @param  int $id
     * @return Collection
     */
    public function getTeamHistory($id)
    {
        return $this->teams->getMembersHistory($id);
    }

    /**
     * Fetch team's roster
     *
     * @param  int $id
     * @return Collection
     */
    public function getTeamMembers($id)
    {
        return $this->teams->get($id)->roster;
    }

    /**
     * Create a new team with its members
     *
     * @param string $name
     * @param int $gameId
     * @param string $description
     * @param array $roster
     * @param File|null $image
     * @throws TeamException
     */
    public function addTeam($name, $gameId, $description, $roster, $image = null)
    {
        if (empty($roster)) {
            throw new TeamException('A team must have at least one valid member!');
        }

        $data = [
            'name' => $name,
            'game_id' => $gameId,
            'description' => $description,
            'roster' => $roster
        ];

        $team = $this->teams->insert($data);
        if ($image) {
            $this->teams->insertImage($team->id, $image);
        }

        return $team;
    }

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
    public function updateTeam($id, $name, $gameId, $description, $roster)
    {
        $data = [
            'name' => $name,
            'game_id' => $gameId,
            'description' => $description,
            'roster' => $roster
        ];

        $team = $this->teams->update($id, $data);

        return $team;
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
        $currentMembers = $this->teams->getTeamMembersUserIDs($teamID);
        $newMembers = array_pluck($roster, 'userId');

        return !($currentMembers == $newMembers);
    }
}
