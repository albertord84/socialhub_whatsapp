<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddApiFieldsColumnToApiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('socialhub_mvp.api')->table('api', function (Blueprint $table) {
            $table->string('file_name')->nullable();
            $table->string('file_type')->nullable();
        
        });
    }
    
}
