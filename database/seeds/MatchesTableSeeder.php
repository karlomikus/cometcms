<?php

use Illuminate\Database\Seeder;
use App\Match, App\MatchRounds, App\RoundScores;

class MatchesTableSeeder extends Seeder {

    public function run()
    {
        $faker = Faker\Factory::create();

        for ($i=1; $i <= 10; $i++) {
            Match::create([
                'team_id' => $faker->numberBetween(1, 5),
                'game_id' => $faker->numberBetween(1, 3),
                'opponent_id' => $faker->numberBetween(1, 10)
            ]);

            for ($j=1; $j <= 3; $j++) {
                $round = MatchRounds::create([
                    'match_id' => $i,
                    'map_id' => $faker->numberBetween(1, 4)
                ]);

                for ($k=1; $k <= 2; $k++) {
                    RoundScores::create([
                        'round_id' => $round->id,
                        'score_home' => $faker->numberBetween(5, 20),
                        'score_guest' => $faker->numberBetween(5, 20)
                    ]);
                }
            }
        }
    }

}