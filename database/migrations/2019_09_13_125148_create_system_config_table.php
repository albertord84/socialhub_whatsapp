<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSystemConfigTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('system_config', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('name', 100);
			$table->string('value', 1000)->nullable();
			$table->string('description', 100)->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('system_config');
	}

}
