<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeysToCompaniesBlignsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('companies_blings', function (Blueprint $table) {
            $table->foreign('company_id', 'fk_companies_companies_blings')->references('id')->on('companies')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('companies_blings', function (Blueprint $table) {
            $table->dropForeign('fk_companies_companies_blings');
        });
    }
}
