<?php
namespace CometTests\Unit\Team;

use CometTests\TestCase;
use Comet\Core\Team\TeamService;
use Comet\Core\Team\Exceptions\TeamException;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class TeamServiceTest extends TestCase
{
    use DatabaseTransactions;

    protected $team;

    protected $members;

    protected function setUp()
    {
        parent::setUp();

        $this->team = $this->app[TeamService::class];
    }

    protected function setUpMembers()
    {
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
        $this->setUpMembers();
        $this->team->addTeam('Test', 1, 'Content', $this->members);
        $team = $this->team->getTeam(6);

        $this->assertEquals('Test', $team->name);
        $this->assertEquals(1, $team->game_id);
        $this->assertEquals('Content', $team->description);
    }

    /** @test */
    public function it_can_create_a_team()
    {
        $this->setUpMembers();
        $team = $this->team->addTeam('Test', 1, 'Content', $this->members);

        $this->assertEquals('Test', $team->name);
        $this->assertEquals(1, $team->game_id);
        $this->assertEquals('Content', $team->description);
    }

    /** @test */
    public function a_team_must_have_at_least_one_member()
    {
        $this->setExpectedException(TeamException::class);

        $this->team->addTeam('No Members', 1, 'Test', []);
    }

    /** @test */
    public function a_team_must_have_a_game_assigned()
    {
        $this->setUpMembers();
        $this->setExpectedException(\Exception::class);

        $this->team->addTeam('Test', null, 'Content', $this->members);
    }

    /** @test */
    public function a_member_of_team_must_be_a_valid_user()
    {
        $this->setUpMembers();
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