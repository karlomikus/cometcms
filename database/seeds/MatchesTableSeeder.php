<?php

use Illuminate\Database\Seeder;
use App\Match, App\MatchRounds, App\RoundScores;

class MatchesTableSeeder extends Seeder {

    public function run()
    {
        $faker = Faker\Factory::create();

        for ($i=0; $i < 10; $i++) {
            Match::create([
                'team_id' => $faker->numberBetween(1, 5),
                'game_id' => $faker->numberBetween(1, 3),
                'opponent_id' => $faker->numberBetween(1, 10)
            ]);
        }

        for ($i=0; $i < 20; $i++) {
            MatchRounds::create([
                'match_id' => $faker->numberBetween(1, 10),
                'map_id' => $faker->numberBetween(1, 4)
            ]);
        }

        for ($i=0; $i < 20; $i++) {
            RoundScores::create([
                'round_id' => $faker->numberBetween(1, 20),
                'score_home' => $faker->numberBetween(10, 50),
                'score_guest' => $faker->numberBetween(10, 50)
            ]);
        }
    }

}