<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateContactsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('contacts', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('first_name', 45)->nullable();
			$table->string('last_name', 45)->nullable();
			$table->string('phone', 45)->nullable();
			$table->string('whatsapp_id', 45)->nullable();
			$table->string('facebook_id', 45)->nullable();
			$table->string('instagram_id', 45)->nullable();
			$table->string('linkedin_id', 45)->nullable();
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
		Schema::drop('contacts');
	}

}
