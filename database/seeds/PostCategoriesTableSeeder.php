<?php

use Illuminate\Database\Seeder;
use App\PostCategory;

class PostCategoriesTableSeeder extends Seeder {

	public function run()
	{
		$faker = Faker\Factory::create();

		for ($i=0; $i < 5; $i++) {
			PostCategory::create([
				'name' => $faker->sentence(2)
			]);
		}
	}

}