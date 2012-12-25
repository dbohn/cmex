<?php

use Illuminate\Database\Migrations\Migration;

class CreateUserTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function($table)
		{
			$table->increments('id');
			$table->string('name')->unique();
			$table->string('password');
			$table->string('email')->unique();
			$table->string('firstname');
			$table->string('lastname');
			$table->timestamps();
			$table->integer('rights');
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