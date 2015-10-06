<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEvents extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->dateTime('date_start');
            $table->dateTime('date_end');
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->integer('game_id')->unsigned()->nullable();
            $table->integer('country_id')->unsigned()->nullable();
            $table->string('location')->nullable();
            $table->text('prize')->nullable();

            $table->foreign('game_id')->references('id')->on('games')->onDelete('cascade');
            $table->foreign('country_id')->references('id')->on('countries')->onDelete('cascade');

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
        Schema::drop('events');
    }
}
