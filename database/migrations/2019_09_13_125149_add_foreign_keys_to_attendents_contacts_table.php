<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToAttendentsContactsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('attendents_contacts', function(Blueprint $table)
		{
			$table->foreign('attendent_id', 'fk_attendents_contacts_attendent')->references('user_id')->on('users_attendants')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('contact_id', 'fk_attendents_contacts_contact')->references('id')->on('contacts')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('attendents_contacts', function(Blueprint $table)
		{
			$table->dropForeign('fk_attendents_contacts_attendent');
			$table->dropForeign('fk_attendents_contacts_contact');
		});
	}

}
