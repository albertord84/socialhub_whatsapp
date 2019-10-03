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
			$table->integer('contact_id')->index('fk_chats_contact');
			$table->integer('attendant_id')->index('fk_chats_attendant');
			$table->text('message', 65535)->nullable();
			$table->integer('type_id')->nullable()->index('fk_chats_type');
			$table->string('data', 45)->nullable();
			$table->integer('status_id')->nullable()->index('fk_chats_status');
			$table->integer('socialnetwork_id')->nullable()->index('fk_chats_socialnetwork');
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