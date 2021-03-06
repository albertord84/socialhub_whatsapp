<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUsersAttendantsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users_attendants', function(Blueprint $table)
		{
			$table->integer('user_id')->primary();
			$table->integer('user_manager_id')->nullable()->index('fk_users_attendants_users_manager');
			$table->integer('code')->nullable();
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
		Schema::drop('users_attendants');
	}

}
