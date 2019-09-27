<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAttendantsContactsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('attendants_contacts', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('attendant_id')->nullable()->index('fk_attendants_contacts_attendant');
			$table->integer('contact_id')->nullable()->index('fk_attendants_contacts_contact');
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
		Schema::drop('attendants_contacts');
	}

}
