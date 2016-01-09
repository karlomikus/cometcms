<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;

class TeamsRepositoryTest extends TestCase
{
    use DatabaseTransactions;

    protected $repo;

    public function setUp()
    {
        parent::setUp();

        $this->repo = $this->app['Comet\Core\Contracts\Repositories\TeamsRepositoryInterface'];
    }

    /** @test */
    public function it_gets_roster_history()
    {

    }

    /** @test */
    public function it_gets_all_roster_user_ids()
    {
        $users = $this->repo->getTeamMembersUserIDs(1);

        $this->assertEquals($users, [7, 8, 9, 8]);
    }

    /** @test */
    public function it_checks_for_roster_changes()
    {
        $roster = [
            ['userId' => 7],
            ['userId' => 8],
            ['userId' => 9],
            ['userId' => 8]
        ];

        $changedRoster = [
            ['userId' => 1],
            ['userId' => 2],
            ['userId' => 3],
            ['userId' => 4]
        ];

        $this->assertTrue($this->repo->hasRosterChanges(1, $changedRoster));
        $this->assertFalse($this->repo->hasRosterChanges(1, $roster));
    }

    /** @test */
    public function it_updates_existing_roster_information()
    {
        $newRoster = [
            ['id' => 1, 'userId' => 7, 'position' => 'Test', 'status' => 'Testing'],
            ['id' => 2, 'userId' => 8, 'position' => 'Test', 'status' => 'Testing'],
            ['id' => 3, 'userId' => 9, 'position' => 'Test', 'status' => 'Testing'],
            ['id' => 4, 'userId' => 7, 'position' => 'Test', 'status' => 'Testing']
        ];
        $this->repo->updateMembers($newRoster, 1);

        $this->seeInDatabase('team_roster', ['position' => 'Test', 'status' => 'Testing']);
    }

    /** @test */
    public function it_soft_deletes_old_roster_and_creates_new_roster()
    {

    }

    /** @test */
    public function it_soft_deletes_roster()
    {
        $this->repo->deleteAllMembers(1);

        $this->assertEmpty($this->repo->getTeamMembersUserIDs(1));
    }

    /** @test */
    public function it_creates_roster_and_assigns_it_to_team()
    {
        $roster = [
            ['userId' => 1, 'position' => 'TestNew', 'status' => 'TestNewing']
        ];

        $this->repo->insertMembers($roster, 1);

        $this->seeInDatabase('team_roster', [
            'position' => 'TestNew',
            'status' => 'TestNewing',
            'team_id' => 1
        ]);
    }
}