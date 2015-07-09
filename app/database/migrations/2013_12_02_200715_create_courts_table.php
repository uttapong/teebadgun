<?php

use Illuminate\Database\Migrations\Migration;

class CreateCourtsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('courts', function($table) {
            $table->increments('id');
            $table->string('name', 30);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('courts');
    }

}