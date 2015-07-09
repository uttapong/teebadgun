<?php

use Illuminate\Database\Migrations\Migration;

class CreateOpengymsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('opengyms', function($table) {
            $table->increments('id');
            $table->integer('team_id');
            $table->integer('gym_id');
            $table->dateTime('created_at')->nullable();
            $table->dateTime('updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('opengyms');
    }

}