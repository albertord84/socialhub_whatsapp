<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSales1Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::create('sales1', function (Blueprint $table) {
        //     $table->increments('id');
        //     $table->timestamps();
        // });

        $table_name = "1";

        try {
			$this->down($table_name);
		} catch (\Throwable $th) {
			//throw $th;
		}
		Schema::connection('socialhub_mvp.sales')->create($table_name, function(Blueprint $table)
		{
			$table->string('id')->unique()->nullable(false);
			$table->integer('contact_id')->nullable();
			$table->integer('source')->nullable()->default(1);
			$table->integer('sended')->nullable()->default(0);
			$table->string('message', 1000)->nullable();
            $table->string('json_data', 10000)->nullable();
            
            $table->integer('has_attendant')->nullable()->default(0);
            $table->integer('attendant_id')->nullable();
            $table->integer('chat_id')->nullable();
            $table->integer('status_id')->nullable();
            
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
        // Schema::dropIfExists('sales1');
        $table_name = "1";
        Schema::connection('socialhub_mvp.sales')->dropIfExists($table_name);
    }
}
