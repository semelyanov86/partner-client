<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToLoanRequestsTable extends Migration
{
    public function up()
    {
        Schema::table('loan_requests', function (Blueprint $table) {
            $table->unsignedInteger('shareholder_id')->nullable();
            $table->foreign('shareholder_id', 'shareholder_fk_1404456')->references('id')->on('shareholders');
        });
    }
}
