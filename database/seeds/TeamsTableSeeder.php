<?php

use Illuminate\Database\Seeder;
use App\Team;

class TeamsTableSeeder extends Seeder {

    public function run()
    {
        $faker = Faker\Factory::create();

        for ($i=0; $i < 5; $i++) {
            $team = Team::create([
                'name' => ucfirst($faker->word),
                'description' => $faker->sentence(12),
                'game_id' => 1
            ]);

            for ($j=0; $j < 4; $j++) {
                DB::table('team_roster')->insert([
                    'user_id' => $faker->randomElement([2, 3, 4, 5, 6, 7, 8, 9]),
                    'team_id' => $team->id,
                    'position' => $faker->randomElement(['Mid', 'Offlane', 'Support 4', 'Support 5']),
                    'status' => 'Test status',
                    'captain' => $j === 0 ? 1 : 0,
                ]);
            }
        }
    }

}