<?php

use Illuminate\Database\Migrations\Migration;

class CreateBlogTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('blog_posts', function($table) 
		{
			$table->increments('id');
			$table->string('title');
			$table->string('slug', 50);
			$table->text('post');
			$table->integer('author');
			$table->integer('blog_id');
		});
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