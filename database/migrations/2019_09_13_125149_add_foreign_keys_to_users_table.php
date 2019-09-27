<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('users', function(Blueprint $table)
		{
			$table->foreign('company_id', 'fk_users_company')->references('id')->on('companies')->onUpdate('CASCADE')->onDelete('CASCADE');
			$table->foreign('role_id', 'fk_users_role')->references('id')->on('roles')->onUpdate('CASCADE')->onDelete('CASCADE');
			$table->foreign('status_id', 'fk_users_status')->references('id')->on('users_status')->onUpdate('CASCADE')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('users', function(Blueprint $table)
		{
			$table->dropForeign('fk_users_company');
			$table->dropForeign('fk_users_role');
			$table->dropForeign('fk_users_status');
		});
	}

}
