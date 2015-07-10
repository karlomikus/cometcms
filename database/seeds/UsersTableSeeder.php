<?php

use Illuminate\Database\Seeder;
use App\User, App\Role, App\Permission;

class UsersTableSeeder extends Seeder {

    public function run()
    {
        $faker = Faker\Factory::create();

        $roleUsers = new Role();
        $roleUsers->name = 'user';
        $roleUsers->display_name = 'Users';
        $roleUsers->description = 'All registered users';
        $roleUsers->save();

        $roleAdmins = new Role();
        $roleAdmins->name = 'admin';
        $roleAdmins->display_name = 'Admins';
        $roleAdmins->description = 'All site administrators';
        $roleAdmins->save();

        $roleModerators = new Role();
        $roleModerators->name = 'mod';
        $roleModerators->display_name = 'Moderators';
        $roleModerators->description = 'All site mods';
        $roleModerators->save();

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

        $roleAdmins->attachPermissions([$createMatch, $editMatch, $deleteMatch]);

        User::create([
            'name' => 'Karlo',
            'email' => 'admin@admin.com',
            'password' => Hash::make('admin123')
        ])->attachRoles([$roleAdmins, $roleUsers]);

        for ($i=0; $i < 54; $i++) {
            User::create([
                'name' => $faker->name,
                'email' => $faker->email,
                'password' => Hash::make('demo123')
            ])->attachRole($roleUsers);
        }
    }

}