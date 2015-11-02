<?php

class UsersRepositoryTest extends TestCase
{
    public function testGetUser()
    {
        $user = factory(App\User::class)->make();
        $repo = new \App\Repositories\UsersRepository($user);

        $dbUser = $repo->get(1);
        dd($dbUser);
    }
}
