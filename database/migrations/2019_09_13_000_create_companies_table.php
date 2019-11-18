<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCompaniesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('companies', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('user_seller_id')->nullable();
			// $table->integer('user_seller_id')->nullable()->index('fk_companies_users_seller');
			$table->string('CNPJ', 45)->nullable();
			$table->string('name', 100)->nullable();
			$table->string('phone', 30)->nullable();
			$table->string('email', 100)->nullable();
			$table->string('ngrok_url', 100)->nullable();
			$table->string('description', 1000)->nullable();
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
		Schema::drop('companies');
	}

}
