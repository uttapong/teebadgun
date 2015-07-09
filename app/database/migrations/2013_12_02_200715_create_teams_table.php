<?php

use Illuminate\Database\Migrations\Migration;

class CreateTeamsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teams', function($table) {
            $table->increments('id');
            $table->string('name', 50);
            $table->string('tel', 20)->nullable();
            $table->text('logo')->nullable();
            $table->string('motto', 100)->nullable();
            $table->text('description')->nullable();
            $table->dateTime('updated_at');
            $table->dateTime('created_at');
            $table->integer('owner');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('teams');
    }

}