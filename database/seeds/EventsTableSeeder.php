<?php

use Illuminate\Database\Seeder;
use App\Event;

class EventsTableSeeder extends Seeder {

    public function run()
    {
        $faker = Faker\Factory::create();

        for ($i=0; $i < 7; $i++) {
            Event::create([
                'name' => ucfirst($faker->word),
                'description' => $faker->sentence(12),
                'date_start' => $faker->dateTimeThisYear,
                'date_end' => $faker->dateTimeThisYear
            ]);
        }
    }

}