<?php

use Illuminate\Database\Migrations\Migration;

class CreateMenuTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('menu', function($table)
		{
			$table->increments('id');
			$table->string('title');
			$table->string('path');
			$table->string('menu');
			$table->integer('lft');
			$table->integer('rgt');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('menu');
	}

}