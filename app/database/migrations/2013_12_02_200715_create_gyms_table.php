<?php

use Illuminate\Database\Migrations\Migration;

class CreateGymsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gyms', function($table) {
            $table->increments('id');
            $table->string('name', 100)->unique();
            $table->float('lat')->nullable();
            $table->float('long')->nullable();
            $table->integer('type');
            $table->string('fee', 30)->nullable();
            $table->string('open_day', 40)->nullable();
            $table->time('open_time')->nullable();
            $table->time('close_time')->nullable();
            $table->integer('car_park')->nullable();
            $table->integer('court_count')->nullable();
            $table->string('tel', 30)->nullable();
            $table->string('contact_person', 50)->nullable();
            $table->string('address', 300)->nullable();
            $table->integer('owner');
            $table->dateTime('updated_at')->nullable();
            $table->dateTime('created_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('gyms');
    }

}