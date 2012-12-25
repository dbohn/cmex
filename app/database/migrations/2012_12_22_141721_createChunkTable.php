<?php

use Illuminate\Database\Migrations\Migration;

class CreateChunkTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('chunks', function($table)
		{
			$table->increments('id');
			$table->string('name')->unique();
			$table->string('type');
			$table->text('content');
			$table->integer('page');
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('chunks');
	}

}