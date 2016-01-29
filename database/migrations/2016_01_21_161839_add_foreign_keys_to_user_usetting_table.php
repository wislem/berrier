<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToUserUsettingTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('user_usetting', function(Blueprint $table)
		{
			$table->foreign('user_id', 'user_usetting_ibfk_1')->references('id')->on('users')->onUpdate('CASCADE')->onDelete('CASCADE');
			$table->foreign('usetting_id', 'user_usetting_ibfk_2')->references('id')->on('usettings')->onUpdate('CASCADE')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('user_usetting', function(Blueprint $table)
		{
			$table->dropForeign('user_usetting_ibfk_1');
			$table->dropForeign('user_usetting_ibfk_2');
		});
	}

}
