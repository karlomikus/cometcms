<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Model::unguard();

		$this->call('GamesTableSeeder');
		$this->call('MapsTableSeeder');
		$this->call('CountriesTableSeeder');
		$this->call('UsersTableSeeder');
		$this->call('TeamsTableSeeder');
		$this->call('OpponentsTableSeeder');
		$this->call('MatchesTableSeeder');
		$this->call('PostCategoriesTableSeeder');
		$this->call('PostsTableSeeder');
		$this->call('EventsTableSeeder');
	}

}
