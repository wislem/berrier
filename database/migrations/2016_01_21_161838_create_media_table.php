<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMediaTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('media', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name')->nullable();
			$table->text('path', 65535)->nullable();
			$table->boolean('type')->nullable()->default(0);
			$table->boolean('is_active')->nullable()->default(0)->index('is_active');
			$table->boolean('ordr')->nullable()->default(0);
			$table->integer('mediable_id')->unsigned()->nullable()->index('mediable_id');
			$table->string('mediable_type', 50)->nullable()->index('mediable_type');
			$table->nullableTimestamps();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('media');
	}

}
