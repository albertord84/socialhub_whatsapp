<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAttendentsContactsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('attendents_contacts', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('attendent_id')->nullable()->index('fk_attendents_contacts_attendent_idx');
			$table->integer('contact_id')->nullable()->index('fk_attendents_contacts_contact_idx');
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
		Schema::drop('attendents_contacts');
	}

}
