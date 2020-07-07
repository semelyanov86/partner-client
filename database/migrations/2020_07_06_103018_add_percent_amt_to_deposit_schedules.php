<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPercentAmtToDepositSchedules extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('deposit_schedules', function (Blueprint $table) {
            $table->decimal('percent_amt_plan', 15, 2)->default(0);
            $table->decimal('percent_amt_fact', 15, 2)->default(0);
        });
    }
}
