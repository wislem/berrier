<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToPostTranslationsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('post_translations', function(Blueprint $table)
		{
			$table->foreign('post_id', 'post_translations_ibfk_1')->references('id')->on('posts')->onUpdate('NO ACTION')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('post_translations', function(Blueprint $table)
		{
			$table->dropForeign('post_translations_ibfk_1');
		});
	}

}
