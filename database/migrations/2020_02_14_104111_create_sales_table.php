<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up(string $table_name = "sales")
	{
		try {
			$this->down($table_name);
		} catch (\Throwable $th) {
			//throw $th;
		}
		Schema::connection('socialhub_mvp.sales')->create($table_name, function(Blueprint $table)
		{
			$table->string('id')->unique()->nullable(false);
			$table->integer('contact_id')->nullable();
			$table->integer('source')->nullable()->default(1);
			$table->integer('sended')->nullable()->default(0);
			$table->string('message', 1000)->nullable();
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
	public function down(string $table_name = "sales")
	{
		Schema::connection('socialhub_mvp.sales')->drop($table_name);
	}

}