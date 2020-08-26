<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLoanMainSchedulesTable extends Migration
{
    public function up()
    {
        Schema::create('loan_main_schedules', function (Blueprint $table) {
            $table->increments('id');
            $table->date('date_plan');
            $table->date('date_fact');
            $table->string('period')->nullable();
            $table->integer('days')->nullable();
            $table->float('main_amt_plan', 15, 2)->nullable();
            $table->float('main_amt_fact', 15, 2)->nullable();
            $table->float('main_amt_debt_plan', 15, 2)->nullable();
            $table->float('main_amt_debt_fact', 15, 2)->nullable();
            $table->float('percent_amt_plan', 15, 2)->nullable();
            $table->float('percent_amt_fact', 15, 2)->nullable();
            $table->float('fee_plan', 15, 2)->nullable();
            $table->float('fee_fact', 15, 2)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
