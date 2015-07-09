<?php

use Illuminate\Database\Migrations\Migration;

class CreateFluxbansTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('flux_bans', function($table) {
            $table->increments('id');
            $table->string('username', 200)->nullable()->index();
            $table->string('ip', 255)->nullable();
            $table->string('email', 80)->nullable();
            $table->string('message', 255)->nullable();
            $table->integer('expire')->nullable();
            $table->integer('ban_creator');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('flux_bans');
    }

}