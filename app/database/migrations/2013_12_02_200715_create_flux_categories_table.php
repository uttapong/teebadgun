<?php

use Illuminate\Database\Migrations\Migration;

class CreateFluxcategoriesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('flux_categories', function($table) {
            $table->increments('id');
            $table->string('cat_name', 80);
            $table->integer('disp_position');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('flux_categories');
    }

}