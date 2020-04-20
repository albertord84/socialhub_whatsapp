<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTrackingFliedsColumnToCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->string('tracking_user', 500)->nullable();
            $table->string('tracking_pass', 500)->nullable();
            $table->string('tracking_message', 1000)->nullable();
            $table->integer('tracking_contrated')->nullable()->default(0);
        });
    }
    
}
