<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('first_name', 50);
			$table->string('last_name', 80);
			$table->string('email', 100)->unique();
			$table->string('password', 60);
			$table->boolean('gender')->nullable()->default(0);
			$table->dateTime('birthday')->nullable();
			$table->boolean('role')->default(1);
			$table->boolean('status')->default(0);
			$table->text('banned_reason', 65535)->nullable();
			$table->string('ip', 20)->nullable();
			$table->dateTime('last_login')->nullable();
			$table->string('remember_token', 100)->nullable();
			$table->nullableTimestamps();
			$table->softDeletes();
			$table->index(['email','password','deleted_at'], 'login_index');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('users');
	}

}
