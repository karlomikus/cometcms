<?php

use Illuminate\Database\Seeder;
use App\Match, App\MatchRounds, App\RoundScores;

class MatchesTableSeeder extends Seeder {

    public function run()
    {
        $faker = Faker\Factory::create();

        for ($i=1; $i <= 100; $i++) {
            Match::create([
                'team_id' => $faker->numberBetween(1, 5),
                'game_id' => $faker->numberBetween(1, 3),
                'opponent_id' => $faker->numberBetween(1, 10)
            ]);

            for ($j=1; $j <= 2; $j++) {
                $round = MatchRounds::create([
                    'match_id' => $i,
                    'map_id' => $faker->numberBetween(1, 4),
                    'notes' => $faker->paragraph()
                ]);

                for ($k=1; $k <= 2; $k++) {
                    RoundScores::create([
                        'round_id' => $round->id,
                        'home' => $faker->numberBetween(1, 5),
                        'guest' => $faker->numberBetween(1, 5)
                    ]);
                }
            }
        }
    }

}