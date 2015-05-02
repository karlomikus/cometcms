<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMatchRoundsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('match_rounds', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('match_id')->unsigned();
			$table->foreign('match_id')->references('id')->on('matches');
			$table->integer('map_id')->unsigned()->nullable();
			$table->foreign('map_id')->references('id')->on('maps');
            $table->text('notes')->nullable();
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
		Schema::drop('match_rounds');
	}

}
