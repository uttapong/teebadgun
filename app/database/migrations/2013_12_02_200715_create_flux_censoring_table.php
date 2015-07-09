<?php

use Illuminate\Database\Migrations\Migration;

class CreateFluxcensoringTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('flux_censoring', function($table) {
            $table->increments('id');
            $table->string('search_for', 60);
            $table->string('replace_with', 60);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('flux_censoring');
    }

}