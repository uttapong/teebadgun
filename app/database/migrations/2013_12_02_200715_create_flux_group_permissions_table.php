<?php

use Illuminate\Database\Migrations\Migration;

class CreateFluxgrouppermissionsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('flux_group_permissions', function($table) {
            $table->increments('id');
            $table->integer('group_id');
            $table->string('name', 50);
            $table->boolean('value');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('flux_group_permissions');
    }

}