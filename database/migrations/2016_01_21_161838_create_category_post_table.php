<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCategoryPostTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('category_post', function(Blueprint $table)
		{
			$table->integer('post_id')->unsigned();
			$table->integer('category_id')->unsigned()->nullable();
			$table->nullableTimestamps();
			$table->index(['post_id','category_id'], 'post_id');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('category_post');
	}

}
