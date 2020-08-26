<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToDepositSchedulesTable extends Migration
{
    public function up()
    {
        Schema::table('deposit_schedules', function (Blueprint $table) {
            $table->unsignedInteger('deposit_id');
            $table->foreign('deposit_id', 'deposit_fk_1404488')->references('id')->on('deposit_contracts');
            $table->unsignedInteger('shareholder_id')->nullable();
            $table->foreign('shareholder_id', 'shareholder_fk_1404489')->references('id')->on('shareholders');
        });
    }
}
