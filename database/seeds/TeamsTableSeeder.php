<?php

use Illuminate\Database\Seeder;
use App\Team;

class TeamsTableSeeder extends Seeder {

    public function run()
    {
        $faker = Faker\Factory::create();

        for ($i=0; $i < 5; $i++) {
            Team::create([
                'name' => ucfirst($faker->word),
                'description' => $faker->sentence(12)
            ]);
        }

        for ($i=0; $i < 15; $i++) {
            DB::table('team_roster')->insert([
                'user_id' => $faker->randomElement([2, 3, 4, 5, 6, 7, 8, 9]),
                'team_id' => $faker->numberBetween(1, 5)
            ]);
        }
    }

}