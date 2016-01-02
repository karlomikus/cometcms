<?php
namespace Comet\Core\Services;

use Comet\Core\Models\Team;
use Comet\Core\Contracts\Repositories\TeamsRepositoryInterface as Teams;

class TeamService
{
    private $teams;

    /**
     * @param Teams $teams Teams repository
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
