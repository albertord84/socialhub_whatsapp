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
            $table->string('blingapikey', 500)->nullable();
            $table->string('blingtoken', 500)->nullable();
            $table->string('blingmessage', 1000)->nullable();
        });
    }
    
}
