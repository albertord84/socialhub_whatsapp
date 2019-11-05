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
		// Schema::connection('socialhub_mvp.chats')->table('chats', function(Blueprint $table)
		// {
		// 	$table->foreign('attendant_id', 'fk_chats_attendant')->references('user_id')->on('socialhub_mvp.users_attendants')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		// 	$table->foreign('contact_id', 'fk_chats_contact')->references('id')->on('socialhub_mvp.contacts')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		// 	$table->foreign('socialnetwork_id', 'fk_chats_socialnetwork')->references('id')->on('socialhub_mvp.socialnetworks')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		// 	$table->foreign('status_id', 'fk_messages_status')->references('id')->on('socialhub_mvp.messages_status')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		// 	$table->foreign('type_id', 'fk_messages_type')->references('id')->on('socialhub_mvp.messages_types')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		// });
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		// Schema::connection('socialhub_mvp.chats')->table('chats', function(Blueprint $table)
		// {
		// 	$table->dropForeign('fk_chats_attendant');
		// 	$table->dropForeign('fk_chats_contact');
		// 	$table->dropForeign('fk_chats_socialnetwork');
		// 	$table->dropForeign('fk_messages_status');
		// 	$table->dropForeign('fk_messages_type');
		// });
	}

}
