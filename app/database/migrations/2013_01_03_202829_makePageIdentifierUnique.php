<?php

use Illuminate\Database\Migrations\Migration;

class MakePageIdentifierUnique extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('page', function($table)
		{
			$table->unique('identifier');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('page', function($table)
		{
			$table->drop_unique('identifier');
		});
	}

}