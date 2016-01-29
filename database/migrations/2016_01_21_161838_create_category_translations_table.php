<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCategoryTranslationsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('category_translations', function(Blueprint $table)
		{
			$table->integer('category_id')->unsigned();
			$table->string('locale', 2)->nullable();
			$table->string('slug')->nullable()->index('slug');
			$table->string('name', 80)->nullable();
			$table->unique(['category_id','locale'], 'category_id_2');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('category_translations');
	}

}
