<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToChatsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('chats', function(Blueprint $table)
		{
			$table->foreign('`socialhub_mvp`.`contacts`.contact_id', 'fk_chats_contact')->references('id')->on('contacts')->onUpdate('CASCADE')->onDelete('CASCADE');
			$table->foreign('`socialhub_mvp`.`users_attendants`.attendant_id', 'fk_chats_attendant')->references('id')->on('users_attendants')->onUpdate('CASCADE')->onDelete('CASCADE');
			$table->foreign('`socialhub_mvp`.`chats_status`.status_id', 'fk_chats_status')->references('id')->on('chats_status')->onUpdate('CASCADE')->onDelete('CASCADE');
			$table->foreign('`socialhub_mvp`.`messages_types`.type_id', 'fk_messages_type')->references('id')->on('messages_types')->onUpdate('CASCADE')->onDelete('CASCADE');
			$table->foreign('`socialhub_mvp`.`chats_status`.socialnetwork_id', 'fk_chats_socialnetwork')->references('id')->on('messages_status')->onUpdate('CASCADE')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('chats', function(Blueprint $table)
		{
			$table->dropForeign('fk_chats_contact');
			$table->dropForeign('fk_chats_attendant');
			$table->dropForeign('fk_chats_status');
			$table->dropForeign('fk_messages_type');
			$table->dropForeign('fk_chats_socialnetwork');
		});
	}

}
