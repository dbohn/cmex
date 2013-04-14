<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPageStatusField extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('page', function(Blueprint $table)
		{
			$table->enum('status', array('live', 'private', 'custom'))->default('private');
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
			$table->dropColumn('status');
		});
	}

}