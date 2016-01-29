<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToPageTranslationsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('page_translations', function(Blueprint $table)
		{
			$table->foreign('page_id', 'page_translations_ibfk_1')->references('id')->on('pages')->onUpdate('NO ACTION')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('page_translations', function(Blueprint $table)
		{
			$table->dropForeign('page_translations_ibfk_1');
		});
	}

}
