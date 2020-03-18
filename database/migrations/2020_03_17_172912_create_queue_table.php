<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQueueTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up(string $table_name = "queue")
	{
		try {
			$this->down($table_name);
		} catch (\Throwable $th) {
			//throw $th;
		}
		Schema::connection('socialhub_mvp.chats')->create($table_name, function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('contact_id')->nullable()->index('fk_chats_contact');
			$table->integer('attendant_id')->nullable()->index('fk_chats_attendant');
			$table->integer('company_id')->nullable();
			$table->integer('source')->nullable();
			$table->integer('response_to')->nullable(); //pointer for indicate the message thar has been answered
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
    public function down(string $table_name = "queue")
    {
        Schema::connection('socialhub_mvp.chats')->drop($table_name);
    }

}
