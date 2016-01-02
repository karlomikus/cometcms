<?php

use Comet\Core\Models\Post;
use Illuminate\Database\Seeder;

class PostsTableSeeder extends Seeder {

	public function run()
	{
		$faker = Faker\Factory::create();

		for ($i=0; $i < 50; $i++) {
			$title = $faker->sentence(4);
			Post::create([
				'user_id' => 1,
				'title' => $title,
				'summary' => $faker->text(250),
				'content' => $faker->text(250),
				'slug' => \Illuminate\Support\Str::slug($title),
				'post_category_id' => $faker->numberBetween(1, 5),
				'status' => $faker->randomElement(['draft', 'published']),
				'comments' => $faker->numberBetween(0, 1)
			]);
		}
	}

}