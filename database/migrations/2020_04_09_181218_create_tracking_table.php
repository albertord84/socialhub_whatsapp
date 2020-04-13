<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTrackingTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::connection('socialhub_mvp.tracking')->create('tracking', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('post_card', 45)->nullable();
			$table->dateTime('post_date')->nullable();
			$table->string('service_code', 45)->nullable();
			$table->integer('items')->nullable();
			$table->string('object_code', 45)->unique('object_code_UNIQUE');
			$table->text('json_csv_data', 65535)->nullable();
			$table->integer('status_id')->nullable()->index('fk_tracking_status_idx');
			$table->text('tracking_list', 65535)->nullable();
			$table->timestamps();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::connection('socialhub_mvp.tracking')->drop('tracking');
	}

}
