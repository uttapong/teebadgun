<?php

use Illuminate\Database\Migrations\Migration;

class CreateProvincesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('provinces', function($table) {
            $table->increments('id');
            $table->string('code', 2);
            $table->string('name', 150);
            $table->string('name_eng', 150);
            $table->integer('geo_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('provinces');
    }

}