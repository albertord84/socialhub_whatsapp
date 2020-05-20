<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompaniesBlingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies_blings', function (Blueprint $table) {
            $table->increments('id');
            
            $table->integer('company_id')->nullable()->index('fk_companies_companies_blings');
            $table->string('bling_username', 500)->nullable();
            $table->string('bling_apikey', 500)->nullable();
            $table->string('bling_message', 1000)->nullable();
            $table->integer('bling_contrated')->nullable()->default(0);

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('companies_blings');
    }
}
