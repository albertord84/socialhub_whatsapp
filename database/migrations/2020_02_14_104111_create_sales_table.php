<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSalesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::connection('socialhub_mvp.sales')->create('sales', function(Blueprint $table)
		{
			$table->integer('id')->primary();
			$table->integer('contact_id')->nullable();
			$table->integer('source')->nullable()->default(1);
			$table->integer('sended')->nullable()->default(0);
			$table->string('json_data', 10000)->nullable();
			$table->timestamps();
			$table->softDeletes();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::connection('socialhub_mvp.sales')->drop('sales');
	}

}
