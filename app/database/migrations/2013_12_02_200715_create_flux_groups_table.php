<?php

use Illuminate\Database\Migrations\Migration;

class CreateFluxgroupsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('flux_groups', function($table) {
            $table->increments('id');
            $table->string('title', 50);
            $table->integer('parent_group_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('flux_groups');
    }

}