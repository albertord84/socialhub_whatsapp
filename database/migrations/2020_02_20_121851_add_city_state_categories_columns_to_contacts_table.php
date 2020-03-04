<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCityStateCategoriesColumnsToContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('contacts', function (Blueprint $table) {
            $table->string('estado', 100)->nullable();
            $table->string('cidade', 100)->nullable();
            $table->string('categoria1', 100)->nullable();
            $table->string('categoria2', 100)->nullable();
         });
    }

    // /**
    //  * Reverse the migrations.
    //  *
    //  * @return void
    //  */
    // public function down()
    // {
    //     Schema::table('contacts', function (Blueprint $table) {
    //         //
    //     });
    // }
}
