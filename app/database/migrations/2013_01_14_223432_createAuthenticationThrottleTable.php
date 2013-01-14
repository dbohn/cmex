<?php

use Illuminate\Database\Migrations\Migration;

class CreateAuthenticationThrottleTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('throttle', function($table)
		{
			$table->increments('id');
			$table->string('user_id');
			$table->integer('attempts');
			$table->boolean('suspended');
			$table->boolean('banned');
			$table->timestamp('last_attempt_at');
			$table->timestamp('suspended_at');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('throttle');
	}

}