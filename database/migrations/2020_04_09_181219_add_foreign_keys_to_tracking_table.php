<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToTrackingTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::connection('socialhub_mvp.tracking')->table('tracking', function(Blueprint $table)
		{
			$table->foreign('status_id', 'fk_tracking_status')->references('id')->on('socialhub_mvp.status')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::connection('socialhub_mvp.tracking')->table('tracking', function(Blueprint $table)
		{
			$table->dropForeign('fk_tracking_status');
		});
	}

}
