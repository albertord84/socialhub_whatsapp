<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateRpisTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('rpis', function(Blueprint $table)
		{
			// $table->integer('user_seller_id')->nullable()->index('fk_companies_users_seller');
			$table->integer('id', true);
			$table->integer('company_id')->nullable();
			$table->string('mac', 30)->nullable();

			$table->string('api_tunnel', 200)->nullable();
			$table->string('api_user', 100)->nullable();
			$table->string('api_password', 100)->nullable();

			$table->string('tcp_tunnel', 200)->nullable();
			$table->string('tcp_port', 10)->nullable();
			$table->string('root_user', 100)->nullable();
			$table->string('root_password', 100)->nullable();

			$table->string('ip', 30)->nullable();
			$table->string('data', 10000)->nullable();
			$table->string('soft_version', 100)->nullable();
			$table->string('soft_version_date', 100)->nullable();
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
		Schema::drop('rpis');
	}

}
