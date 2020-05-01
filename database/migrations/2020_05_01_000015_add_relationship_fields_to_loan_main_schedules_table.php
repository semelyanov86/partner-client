<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToLoanMainSchedulesTable extends Migration
{
    public function up()
    {
        Schema::table('loan_main_schedules', function (Blueprint $table) {
            $table->unsignedInteger('shareholder_id');
            $table->foreign('shareholder_id', 'shareholder_fk_1404523')->references('id')->on('shareholders');
            $table->unsignedInteger('loan_id');
            $table->foreign('loan_id', 'loan_fk_1404524')->references('id')->on('loan_contracts');
        });

    }
}
