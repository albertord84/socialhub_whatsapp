<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddBlingFliedsColumnToCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->string('bling_apikey', 500)->nullable();
            $table->string('bling_token', 500)->nullable();
            $table->string('bling_message', 1000)->nullable();
            $table->integer('bling_contrated')->nullable()->default(0);
        });
    }
    
}
