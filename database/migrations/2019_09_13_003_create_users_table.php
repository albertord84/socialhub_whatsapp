<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('company_id')->nullable()->index('fk_users_company');
			$table->string('name', 100)->nullable();
			$table->string('email', 100)->nullable()->unique('users_email_unique');
			$table->string('whatsapp_id', 45)->nullable();
			$table->string('facebook_id', 45)->nullable();
			$table->string('instagram_id', 45)->nullable();
			$table->string('linkedin_id', 45)->nullable();
			$table->dateTime('email_verified_at')->nullable();
			$table->string('password', 300)->nullable();
			$table->string('remember_token', 100)->nullable();
			$table->string('login', 100)->nullable();
			$table->string('CPF', 15)->nullable();
			$table->string('phone', 30)->nullable();
			$table->string('image_path', 300)->default('images/user.jpg');
			$table->integer('role_id')->nullable()->index('fk_users_role');
			$table->integer('status_id')->nullable()->index('fk_users_status')->default('1');
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
		Schema::drop('users');
	}

}
