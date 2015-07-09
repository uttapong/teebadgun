<?php

use Illuminate\Database\Migrations\Migration;

class CreateFluxtopicsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('flux_topics', function($table) {
            $table->increments('id');
            $table->string('poster', 200);
            $table->string('subject', 255);
            $table->integer('posted');
            $table->integer('first_post_id')->index();
            $table->integer('last_post')->index();
            $table->integer('last_post_id');
            $table->string('last_poster', 200)->nullable();
            $table->integer('num_views');
            $table->integer('num_replies');
            $table->boolean('closed');
            $table->boolean('sticky');
            $table->integer('moved_to')->nullable()->index();
            $table->integer('forum_id')->index();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('flux_topics');
    }

}