<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStatusFieldsColumnToSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('socialhub_mvp.sales')->table('sales', function (Blueprint $table) {
            $table->integer('status_id')->nullable();

        
        });
    }
    
}
