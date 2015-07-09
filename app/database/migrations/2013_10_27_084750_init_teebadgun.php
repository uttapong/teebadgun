<?php

use Illuminate\Database\Migrations\Migration;

class InitTeebadgun extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function($table) {
		 // auto incremental id (PK)
		$table->increments('id');
		 // varchar 32
		$table->string('username', 32);
		$table->string('firstname', 32);
		$table->string('lastname', 32);
		$table->string('displayname', 32);
		$table->string('username', 32);
		$table->string('email', 320);
		$table->string('password', 64);
		 // int
		$table->integer('role');
		 // boolean
		$table->boolean('active');
		 // created_at | updated_at DATETIME
		$table->timestamps();
		});
		//
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		//
	}

}