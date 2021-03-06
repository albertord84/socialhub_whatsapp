<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToUsersAttendantsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('users_attendants', function(Blueprint $table)
		{
			$table->foreign('user_manager_id', 'fk_users_attendants_users_manager')->references('id')->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('user_id', 'fk_users_attendants_user')->references('id')->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('users_attendants', function(Blueprint $table)
		{
			$table->dropForeign('fk_users_attendants_users_manager');
			$table->dropForeign('fk_users_attendants_user');
		});
	}

}
