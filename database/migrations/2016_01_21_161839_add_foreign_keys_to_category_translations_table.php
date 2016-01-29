<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToCategoryTranslationsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('category_translations', function(Blueprint $table)
		{
			$table->foreign('category_id', 'category_translations_ibfk_1')->references('id')->on('categories')->onUpdate('NO ACTION')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('category_translations', function(Blueprint $table)
		{
			$table->dropForeign('category_translations_ibfk_1');
		});
	}

}
