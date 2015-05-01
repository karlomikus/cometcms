<?php

use Illuminate\Database\Seeder;
use App\Opponent;

class OpponentsTableSeeder extends Seeder {

    public function run()
    {
        $faker = Faker\Factory::create();

        for ($i=0; $i < 10; $i++) {
            Opponent::create([
                'name' => ucfirst($faker->word),
                'description' => $faker->sentence(12)
            ]);
        }
    }

}