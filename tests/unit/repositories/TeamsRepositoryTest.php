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
        
    }

    /** @test */
    public function it_checks_for_roster_changes()
    {
        
    }

    /** @test */
    public function it_can_update_roster()
    {
        
    }

    /** @test */
    public function it_can_delete_roster()
    {
        
    }

    /** @test */
    public function it_can_create_roster()
    {
        
    }
}