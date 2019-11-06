<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateChatsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up(string $table_name = "chats")
	{
		try {
			$this->down($table_name);
		} catch (\Throwable $th) {
			//throw $th;
		}
		Schema::connection('socialhub_mvp.chats')->create($table_name, function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('contact_id')->index('fk_chats_contact');
			$table->integer('attendant_id')->index('fk_chats_attendant');
			$table->boolean('from')->nullable();
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
	public function down(string $table_name = "chats")
	{
		Schema::connection('socialhub_mvp.chats')->drop($table_name);
	}

}
