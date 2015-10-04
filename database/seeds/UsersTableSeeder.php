<?php

use Illuminate\Database\Seeder;
use App\User, App\UsersProfile, App\Role, App\Permission;

class UsersTableSeeder extends Seeder {

    public function run()
    {
        $faker = Faker\Factory::create();

        $roleAdmins = new Role();
        $roleAdmins->name = 'admin';
        $roleAdmins->display_name = 'Admins';
        $roleAdmins->description = 'All site administrators';
        $roleAdmins->save();

        $roleUsers = new Role();
        $roleUsers->name = 'user';
        $roleUsers->display_name = 'Users';
        $roleUsers->description = 'All registered users';
        $roleUsers->save();

        $roleModerators = new Role();
        $roleModerators->name = 'mod';
        $roleModerators->display_name = 'Moderators';
        $roleModerators->description = 'All site mods';
        $roleModerators->save();

        $roleContent = new Role();
        $roleContent->name = 'content';
        $roleContent->display_name = 'Content managers';
        $roleContent->description = 'Site content managers';
        $roleContent->save();

        // Match permissions
        $createMatch = new Permission();
        $createMatch->name = 'create-match';
        $createMatch->display_name = 'Create Matches';
        $createMatch->description  = 'Role can create matches';
        $createMatch->save();
        $editMatch = new Permission();
        $editMatch->name = 'edit-match';
        $editMatch->display_name = 'Edit Matches';
        $editMatch->description  = 'Role can edit matches';
        $editMatch->save();
        $deleteMatch = new Permission();
        $deleteMatch->name = 'delete-match';
        $deleteMatch->display_name = 'Delete Matches';
        $deleteMatch->description  = 'Role can delete matches';
        $deleteMatch->save();

        // Teams permissions
        $createTeam = new Permission();
        $createTeam->name = 'create-team';
        $createTeam->display_name = 'Create Teams';
        $createTeam->description  = 'Role can create teams';
        $createTeam->save();
        $editTeam = new Permission();
        $editTeam->name = 'edit-team';
        $editTeam->display_name = 'Edit Teams';
        $editTeam->description  = 'Role can edit teams';
        $editTeam->save();
        $deleteTeam = new Permission();
        $deleteTeam->name = 'delete-team';
        $deleteTeam->display_name = 'Delete Teams';
        $deleteTeam->description  = 'Role can delete teams';
        $deleteTeam->save();

        // Opponent permissions
        $createOpponent = new Permission();
        $createOpponent->name = 'create-opponent';
        $createOpponent->display_name = 'Create Opponents';
        $createOpponent->description  = 'Role can create opponents';
        $createOpponent->save();
        $editOpponent = new Permission();
        $editOpponent->name = 'edit-opponent';
        $editOpponent->display_name = 'Edit Opponents';
        $editOpponent->description  = 'Role can edit opponents';
        $editOpponent->save();
        $deleteOpponent = new Permission();
        $deleteOpponent->name = 'delete-opponent';
        $deleteOpponent->display_name = 'Delete Opponents';
        $deleteOpponent->description  = 'Role can delete opponents';
        $deleteOpponent->save();

        // Users permissions
        $createUser = new Permission();
        $createUser->name = 'create-user';
        $createUser->display_name = 'Create Users';
        $createUser->description  = 'Role can create Users';
        $createUser->save();
        $editUser = new Permission();
        $editUser->name = 'edit-user';
        $editUser->display_name = 'Edit Users';
        $editUser->description  = 'Role can edit Users';
        $editUser->save();
        $deleteUser = new Permission();
        $deleteUser->name = 'delete-user';
        $deleteUser->display_name = 'Delete Users';
        $deleteUser->description  = 'Role can delete users';
        $deleteUser->save();

        // Posts permissions
        $createPost = new Permission();
        $createPost->name = 'create-post';
        $createPost->display_name = 'Create post';
        $createPost->description  = 'Role can create posts';
        $createPost->save();
        $editPost = new Permission();
        $editPost->name = 'edit-post';
        $editPost->display_name = 'Edit posts';
        $editPost->description  = 'Role can edit post';
        $editPost->save();
        $deletePost = new Permission();
        $deletePost->name = 'delete-post';
        $deletePost->display_name = 'Delete posts';
        $deletePost->description  = 'Role can delete posts';
        $deletePost->save();

        $roleAdmins->attachPermissions([
            $createMatch, $editMatch, $deleteMatch,
            $createTeam, $editTeam, $deleteTeam,
            $createOpponent, $editOpponent, $deleteOpponent,
            $createUser, $editUser, $deleteUser,
            $createPost, $editPost, $deletePost
        ]);
        $roleModerators->attachPermissions([
            $createMatch, $editMatch, $deleteMatch,
            $createPost, $editPost, $deletePost
        ]);
        $roleContent->attachPermissions([
            $createMatch, $editMatch,
            $createTeam, $editTeam,
            $createPost, $editPost
        ]);

        $admin = User::create([
            'name' => 'Karlo',
            'email' => 'admin@admin.com',
            'password' => Hash::make('admin123')
        ]);
        $admin->attachRoles([$roleAdmins, $roleUsers]);
        UsersProfile::create([
            'user_id' => $admin->id,
            'bio' => 'First and most important user, the admin of this glorious web app',
            'image' => null,
            'first_name' => 'Karlo',
            'last_name' => 'Mikuš'
        ]);

        for ($i=0; $i < 54; $i++) {
            $user = User::create([
                'name' => $faker->name,
                'email' => $faker->email,
                'password' => Hash::make('demo123')
            ]);
            $user->attachRole($roleUsers);
            UsersProfile::create([
                'user_id' => $user->id,
                'bio' => $faker->paragraph(),
                'image' => null,
                'first_name' => $faker->firstName,
                'last_name' => $faker->lastName
            ]);
        }
    }

}