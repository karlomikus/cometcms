<?php

use Illuminate\Database\Seeder;
use App\User, App\Role;

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