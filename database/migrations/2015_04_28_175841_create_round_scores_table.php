<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRoundScoresTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('round_scores', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('round_id')->unsigned();
			$table->foreign('round_id')->references('id')->on('match_rounds')->onDelete('cascade');
			$table->integer('home');
			$table->integer('guest');
			$table->timestamps();
			$table->softDeletes();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('round_scores');
	}

}
