<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePostTranslationsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('post_translations', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('post_id')->unsigned()->nullable();
			$table->string('slug')->nullable()->index('slug');
			$table->string('title')->nullable();
			$table->text('content', 65535)->nullable();
			$table->string('locale');
			$table->string('meta_desc')->nullable();
			$table->unique(['post_id','locale'], 'post_id');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('post_translations');
	}

}
