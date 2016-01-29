<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUsettingsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('usettings', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name', 50)->nullable();
			$table->string('key', 50)->nullable();
			$table->string('default')->nullable();
			$table->boolean('user_editable')->nullable()->default(0);
			$table->nullableTimestamps();
			$table->index(['key','user_editable'], 'key_usereditable');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('usettings');
	}

}
