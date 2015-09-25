<?php

use Illuminate\Database\Seeder;
use App\Post;

class PostsTableSeeder extends Seeder {

	public function run()
	{
		$faker = Faker\Factory::create();

		for ($i=0; $i < 10; $i++) {
			$title = $faker->sentence(4);
			Post::create([
				'user_id' => 1,
				'title' => $title,
				'summary' => $faker->text(250),
				'content' => $faker->text(250),
				'slug' => \Illuminate\Support\Str::slug($title)
			]);
		}
	}

}