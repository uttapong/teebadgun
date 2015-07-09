<?php

use Illuminate\Database\Migrations\Migration;

class CreateFluxforumsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('flux_forums', function($table) {
            $table->increments('id');
            $table->string('forum_name', 80);
            $table->text('forum_desc')->nullable();
            $table->string('redirect_url', 100)->nullable();
            $table->integer('num_topics');
            $table->integer('num_posts');
            $table->integer('last_post')->nullable();
            $table->integer('last_post_id')->nullable();
            $table->string('last_poster', 200)->nullable();
            $table->integer('sort_by');
            $table->integer('disp_position');
            $table->integer('cat_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('flux_forums');
    }

}