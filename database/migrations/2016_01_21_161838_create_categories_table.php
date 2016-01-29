<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCategoriesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('categories', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('icon', 30)->nullable();
			$table->integer('parent_id')->unsigned()->nullable();
			$table->integer('_lft')->unsigned()->nullable();
			$table->integer('_rgt')->unsigned()->nullable();
			$table->softDeletes()->index('slug_deleted_at');
			$table->nullableTimestamps();
			$table->index(['_lft','_rgt','parent_id'], 'parent_id');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('categories');
	}

}
