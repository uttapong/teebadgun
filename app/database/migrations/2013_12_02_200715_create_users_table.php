<?php

use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function($table) {
            $table->increments('id');
            $table->string('username', 30);
            $table->string('password', 64);
            $table->string('firstname', 20);
            $table->string('lastname', 20)->nullable();
            $table->string('email', 30)->nullable();
            $table->string('addressno', 20)->nullable();
            $table->string('moo', 10)->nullable();
            $table->string('soi', 10)->nullable();
            $table->string('road', 50)->nullable();
            $table->string('subdistrict', 50)->nullable();
            $table->integer('district')->nullable();
            $table->integer('province')->nullable();
            $table->string('country', 11)->default("TH")->nullable();
            $table->string('phone', 20)->nullable();
            $table->string('mobile', 20)->nullable();
            $table->string('fb_token', 50)->nullable();
            $table->string('tw_token', 50)->nullable();
            $table->string('gg_token', 50)->nullable();
            $table->longtext('picture')->nullable();
            $table->text('signature')->nullable();
            $table->date('birthdate')->nullable();
            $table->integer('role');
            $table->integer('status');
            $table->dateTime('created_at');
            $table->dateTime('updated_at');
            $table->integer('fb_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('users');
    }

}