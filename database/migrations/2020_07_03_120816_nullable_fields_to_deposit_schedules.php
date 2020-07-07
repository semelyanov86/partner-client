<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class NullableFieldsToDepositSchedules extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('deposit_schedules', function (Blueprint $table) {
            $table->date('date_plan')->nullable()->default(null)->change();;
            $table->float('main_amt_debt', 15, 2)->nullable()->default(null)->change();;
            $table->string('main_amt_fact')->nullable()->default(null)->change();;
        });
    }

}
