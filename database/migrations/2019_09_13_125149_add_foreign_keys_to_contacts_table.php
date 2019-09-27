<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToContactsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('contacts', function(Blueprint $table)
		{
			$table->foreign('company_id', 'fk_contacts_company')->references('id')->on('companies')->onUpdate('CASCADE')->onDelete('CASCADE');
			$table->foreign('status_id', 'fk_contacts_status')->references('id')->on('contacts_status')->onUpdate('CASCADE')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('contacts', function(Blueprint $table)
		{
			$table->dropForeign('fk_contacts_company');
			$table->dropForeign('fk_contacts_status');
		});
	}

}
