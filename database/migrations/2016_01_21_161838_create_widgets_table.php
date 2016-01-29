<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateWidgetsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('widgets', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('title', 80)->nullable();
			$table->text('content', 65535)->nullable();
			$table->string('path', 80)->nullable();
			$table->string('position', 50)->nullable();
			$table->boolean('is_active')->nullable()->default(1);
			$table->boolean('is_global')->nullable()->default(0);
			$table->boolean('ordr')->nullable()->default(0);
			$table->nullableTimestamps();
			$table->softDeletes();
			$table->index(['position','is_active','is_global'], 'position_active_global');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('widgets');
	}

}
