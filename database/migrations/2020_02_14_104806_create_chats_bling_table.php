<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateChatsBlingTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::connection('socialhub_mvp.chats')->create('chats_bling', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('contact_id')->nullable()->index('fk_chats_contact');
			$table->integer('attendant_id')->nullable()->index('fk_chats_attendant');
			$table->integer('company_id')->nullable();
			$table->integer('source')->nullable()->default(0);
			$table->integer('response_to')->nullable();
			$table->text('message', 65535)->nullable();
			$table->integer('type_id')->nullable()->index('fk_chats_type');
			$table->string('data', 2000)->nullable();
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
		Schema::connection('socialhub_mvp.chats')->drop('chats_bling');
	}

}
