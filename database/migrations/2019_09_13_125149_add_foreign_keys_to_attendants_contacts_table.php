<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToAttendantsContactsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('attendants_contacts', function(Blueprint $table)
		{
			$table->foreign('attendant_id', 'fk_attendants_contacts_attendant')->references('user_id')->on('users_attendants')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('contact_id', 'fk_attendants_contacts_contact')->references('id')->on('contacts')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('attendants_contacts', function(Blueprint $table)
		{
			$table->dropForeign('fk_attendants_contacts_attendant');
			$table->dropForeign('fk_attendants_contacts_contact');
		});
	}

}
