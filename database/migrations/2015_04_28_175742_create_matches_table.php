<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMatchesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('matches', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('team_id')->unsigned();
			$table->foreign('team_id')->references('id')->on('teams');
			$table->integer('opponent_id')->unsigned();
			$table->foreign('opponent_id')->references('id')->on('opponents');
			$table->integer('game_id')->unsigned();
			$table->foreign('game_id')->references('id')->on('games');
            $table->string('matchlink')->nullable();
            $table->text('opponent_participants')->nullable();
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('matches');
	}

}
