<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToLoanContractsTable extends Migration
{
    public function up()
    {
        Schema::table('loan_contracts', function (Blueprint $table) {
            $table->unsignedInteger('shareholder_id');
            $table->foreign('shareholder_id', 'shareholder_fk_1404502')->references('id')->on('shareholders');
        });
    }
}
