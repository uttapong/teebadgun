<?php

use Illuminate\Database\Migrations\Migration;

class CreateManagersTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('managers', function($table) {
            $table->increments('id');
            $table->integer('team_id');
            $table->integer('user_id');
            $table->string('nonmember_name', 100)->nullable();
            $table->dateTime('created_at')->nullable();
            $table->dateTime('updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('managers');
    }

}