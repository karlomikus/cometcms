<?php
namespace Comet\Core\Gateways;

use Comet\Core\Models\Team;
use Comet\Core\Contracts\Repositories\TeamsRepositoryInterface as Teams;

class TeamGateway
{
    private $teams;

    public function __construct(Teams $teams)
    {
        $this->teams = $teams;
    }

    public function getTeams()
    {
        return $this->teams->all();
    }

    public function getTeam($id)
    {
        return $this->teams->get($id);
    }

    public function getTeamHistory($id)
    {
        return $this->teams->getMembersHistory($id);
    }

    public function getTeamMembers($id)
    {
        return $this->teams->getTeamData($id);
    }

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