<?php

class TeamsTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();

        $user = Comet\Core\Models\User::find(1);
        $this->actingAs($user);
    }

    /** @test */
    public function it_lists_teams()
    {
        $this->visit('/admin/teams')
            ->see('Squads')
            ->see('Create new squad')
            ->click('Create new squad')
            ->seePageIs('/admin/teams/new');
    }

    /** @test */
    public function it_shows_team_creation_form()
    {
        $this->visit('/admin/teams/new')
            ->see('Create new squad')
            ->see('Save squad');
    }

    /** @test */
    public function it_shows_team_edit_form()
    {
        $this->visit('/admin/teams/edit/1')
            ->see('Editing a squad')
            ->see('Save squad')
            ->see('Delete squad');
    }

    /** @test */
    public function it_shows_team_json_response()
    {
        // $this->get('/admin/api/team/', ['id' => 1])
        //     ->seeJson([
        //         'message' => null
        //     ]);
    }
}