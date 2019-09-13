<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUsersManagersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users_managers', function(Blueprint $table)
		{
			$table->integer('user_id')->primary();
			$table->string('CNPJ', 45)->nullable();
			$table->string('whatsapp_id', 45)->nullable();
			$table->string('facebook_id', 45)->nullable();
			$table->string('instagram_id', 45)->nullable();
			$table->string('linkedin_id', 45)->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('users_managers');
	}

}
