<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAttendantFieldsColumnToSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('socialhub_mvp.sales')->table('sales', function (Blueprint $table) {
            $table->integer('has_attendant')->nullable()->default(0);
            $table->integer('attendant_id')->nullable();
            $table->integer('chat_id')->nullable();

        
        });
    }
    
}
