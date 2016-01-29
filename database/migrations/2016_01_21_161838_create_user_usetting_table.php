<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUserUsettingTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('user_usetting', function(Blueprint $table)
		{
			$table->integer('user_id')->unsigned()->index('user_id');
			$table->integer('usetting_id')->unsigned()->index('usetting_id');
			$table->string('value')->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('user_usetting');
	}

}
