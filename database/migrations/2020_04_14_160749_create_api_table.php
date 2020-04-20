<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateApiTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::connection('socialhub_mvp.api')->create('api', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('contact_id')->nullable()->index('fk_chats_contact');
			$table->integer('sended')->nullable()->default(0);
			$table->string('message', 1000)->nullable();
			$table->integer('type_id')->nullable()->index('fk_chats_type');
			$table->string('data', 2000)->nullable();
			$table->integer('status_id')->nullable()->index('fk_chats_status');
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
		Schema::connection('socialhub_mvp.api')->drop('api');
	}

}
