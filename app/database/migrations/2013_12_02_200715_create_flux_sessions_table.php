<?php

use Illuminate\Database\Migrations\Migration;

class CreateFluxsessionsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('flux_sessions', function($table) {
            $table->increments('id');
            $table->string('id', 40)->primary();
            $table->integer('user_id')->default("1")->index();
            $table->integer('created');
            $table->integer('last_visit');
            $table->string('last_ip', 200)->default("0.0.0.0");
            $table->text('payload');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('flux_sessions');
    }

}