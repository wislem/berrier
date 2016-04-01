<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePageTranslationsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('page_translations', function(Blueprint $table)
		{
			$table->increments('t_id');
			$table->integer('page_id')->unsigned()->nullable();
			$table->string('slug')->nullable()->index('slug');
			$table->string('title')->nullable();
			$table->text('content', 65535)->nullable();
			$table->string('locale');
			$table->string('meta_desc')->nullable();
			$table->unique(['page_id','locale'], 'page_id');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('page_translations');
	}

}
