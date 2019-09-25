<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateChatsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::connection('socialhub_mvp.chats')->create('chats', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('contact_id')->index('fk_chats_contact_idx');
			$table->integer('attendant_id')->index('fk_chats_attendant_idx');
			$table->text('message', 65535)->nullable();
			$table->integer('type')->nullable()->index('fk_chats_type_idx');
			$table->string('data', 45)->nullable();
			$table->integer('status_id')->nullable()->index('fk_chats_status_idx');
			$table->integer('socialnetwork_id')->nullable()->index('fk_chats_socialnetwork_idx');
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
		Schema::connection('socialhub_mvp.chats')->drop('chats');
	}

}
