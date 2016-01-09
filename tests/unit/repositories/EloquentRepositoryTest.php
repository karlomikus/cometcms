<?php

use Comet\Core\Models\EloquentModel;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Comet\Core\Repositories\EloquentRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class EloquentRepositoryTest extends TestCase
{
    use DatabaseTransactions;

    private $stubRepo;

    public function setUp()
    {
        parent::setUp();

        $this->stubRepo = $this->app['Comet\Core\Contracts\Repositories\UsersRepositoryInterface'];
    }

    /** @test */
    public function it_gets_a_single_record()
    {
        $user = $this->stubRepo->get(1);

        $this->assertNotNull($user);
        $this->assertInstanceOf('Comet\Core\Models\User', $user);
    }

    /** @test */
    public function it_gets_all_records()
    {
        $users = $this->stubRepo->all();

        $this->assertCount(55, $users);
        $this->assertInstanceOf('Illuminate\Support\Collection', $users);
        $this->assertInstanceOf('Comet\Core\Models\User', $users->first());
    }

    /** @test */
    public function it_creates_a_new_record()
    {
        $data = [
            'email'    => 'teststub@test.com',
            'password' => 'test12345',
            'username' => 'testuser'
        ];
        $this->stubRepo->insert($data);

        $this->seeInDatabase('users', $data);
    }

    /** @test */
    public function it_updates_an_existing_record()
    {
        $data = [
            'username' => 'newAdminTest'
        ];
        $this->stubRepo->update(1, $data);

        $this->seeInDatabase('users', [
            'id' => 1,
            'username' => 'newAdminTest'
        ]);
    }

    /** @test */
    public function it_deletes_an_existing_record()
    {
        $user = $this->stubRepo->get(2);
        $this->assertNull($user->deleted_at);

        $this->stubRepo->delete(2);

        // We use soft deletes here
        $user = $this->stubRepo->get(2);
        $this->seeInDatabase('users', ['id' => 2]);
        $this->assertNotNull($user->deleted_at);
    }
}
