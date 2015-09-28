<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePosts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->string('title', 150);
            $table->string('summary', 250)->nullable();
            $table->text('content');
            $table->string('slug', 100);
            $table->integer('post_category_id')->unsigned()->nullable();
            $table->dateTime('publish_date_start')->nullable();
            $table->dateTime('publish_date_end')->nullable();
            $table->enum('status', ['published', 'draft'])->default('draft');
            $table->tinyInteger('comments')->default(0);
            $table->timestamps();

            $table->unique('slug');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('post_category_id')->references('id')->on('post_categories');
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
        Schema::drop('posts');
    }
}
