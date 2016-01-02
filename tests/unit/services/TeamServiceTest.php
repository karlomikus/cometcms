<?php

use Comet\Core\Services\TeamService;
use Comet\Core\Exceptions\TeamException;
use Comet\Core\Repositories\TeamsRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class TeamServiceTest extends TestCase
{
    use DatabaseTransactions;

    protected $team;

    public function setUp()
    {
        parent::setUp();

        $this->team = $this->app[TeamService::class];
    }

    /** @test */
    public function it_can_get_all_teams()
    {
        $teams = $this->team->getTeams();

        $this->assertCount(5, $teams);
    }

    /** @test */
    public function it_can_get_a_specific_team()
    {
        $this->team->addTeam('Test', 1, 'Content', [], null);
        $team = $this->team->getTeam(6);

        $this->assertEquals('Test', $team->name);
        $this->assertEquals(1, $team->game_id);
        $this->assertEquals('Content', $team->description);
    }

    /** @test */
    public function it_can_create_a_team()
    {
        $team = $this->team->addTeam('Test', 1, 'Content', [], null);

        $this->assertEquals('Test', $team->name);
        $this->assertEquals(1, $team->game_id);
        $this->assertEquals('Content', $team->description);
    }

    /** @test */
    public function a_team_must_have_at_least_one_member()
    {
        $this->setExpectedException(TeamException::class);
        $this->team->addTeam('No Members', 1, 'Test', [], null);
    }

    /** @test */
    public function a_team_must_have_a_game_assigned()
    {
        
    }

    /** @test */
    public function a_member_of_team_must_be_a_valid_user()
    {

    }
}