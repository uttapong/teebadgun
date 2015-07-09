<?php

use Illuminate\Database\Migrations\Migration;

class CreateFluxforumpermsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('flux_forum_perms', function($table) {
            $table->increments('id');
            $table->integer('group_id')->primary();
            $table->integer('forum_id')->primary();
            $table->boolean('read_forum')->default("1");
            $table->boolean('post_replies')->default("1");
            $table->boolean('post_topics')->default("1");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('flux_forum_perms');
    }

}