<?php
namespace Comet\Core\Services;

use Comet\Core\Models\Team;
use Comet\Core\Exceptions\TeamException;
use Comet\Core\Contracts\Repositories\TeamsRepositoryInterface as Teams;

class TeamService
{
    private $teams;

    /**
     * @param Teams $teams Teams repository instance
     */
    public function __construct(Teams $teams)
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
     * Get a team by it's identifierž
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
     * @return collection
     */
    public function getTeamHistory($id)
    {
        return $this->teams->getMembersHistory($id);
    }

    /**
     * Get team with all it's members
     *
     * @param  int $id
     * @return Team
     */
    public function getTeamMembers($id)
    {
        return $this->teams->getTeamData($id);
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
}
