<?php

use Illuminate\Database\Migrations\Migration;

class CreateOpendaysTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('opendays', function($table) {
            $table->increments('id');
            $table->string('day', 30)->nullable();
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->integer('gym');
            $table->text('payment')->nullable();
            $table->text('remark')->nullable();
            $table->integer('team');
            $table->dateTime('updated_at');
            $table->dateTime('created_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('opendays');
    }

}