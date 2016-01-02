<?php

use Comet\Core\Services\TeamService;
use Comet\Core\Exceptions\TeamException;
use Comet\Core\Repositories\TeamsRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class TeamServiceTest extends TestCase
{
    use DatabaseTransactions;

    protected $team;

    protected $members;

    public function setUp()
    {
        parent::setUp();

        $this->team = $this->app[TeamService::class];

        $this->members[] = [
            'userId' => 1,
            'position' => 'Test position',
            'status' => 'Test status',
            'captain' => true
        ];

        $this->members[] = [
            'userId' => 2,
            'position' => 'Test position',
            'status' => 'Test status',
            'captain' => false
        ];

        $this->members[] = [
            'userId' => 3,
            'position' => 'Test position',
            'status' => 'Test status',
            'captain' => false
        ];
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
        $this->team->addTeam('Test', 1, 'Content', $this->members);
        $team = $this->team->getTeam(6);

        $this->assertEquals('Test', $team->name);
        $this->assertEquals(1, $team->game_id);
        $this->assertEquals('Content', $team->description);
    }

    /** @test */
    public function it_can_create_a_team()
    {
        $team = $this->team->addTeam('Test', 1, 'Content', $this->members, null);

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
        $member = $this->members[0];
        $memberAttributes = array_keys($member);
        $validAttributes = ['userId', 'position', 'status', 'captain'];

        $this->assertEquals($memberAttributes, $validAttributes);
        $this->assertTrue(isset($member['userId']));
    }

    /** @test */
    public function a_team_can_only_have_one_captain()
    {
        
    }
}