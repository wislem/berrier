<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateWidgetablesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('widgetables', function(Blueprint $table)
		{
			$table->integer('widget_id')->unsigned();
			$table->integer('widgetable_id')->unsigned();
			$table->string('widgetable_type', 50)->nullable();
			$table->index(['widget_id','widgetable_id','widgetable_type'], 'widget_id');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('widgetables');
	}

}
