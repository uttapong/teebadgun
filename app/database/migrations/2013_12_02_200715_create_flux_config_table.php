<?php

use Illuminate\Database\Migrations\Migration;

class CreateFluxconfigTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('flux_config', function($table) {
            $table->increments('id');
            $table->string('conf_name', 255)->primary();
            $table->text('conf_value')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('flux_config');
    }

}