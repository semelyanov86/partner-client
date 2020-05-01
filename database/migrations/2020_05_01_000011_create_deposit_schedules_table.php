<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDepositSchedulesTable extends Migration
{
    public function up()
    {
        Schema::create('deposit_schedules', function (Blueprint $table) {
            $table->increments('id');
            $table->date('date_plan');
            $table->date('date_fact')->nullable();
            $table->string('period')->nullable();
            $table->integer('days')->nullable();
            $table->float('main_amt_debt', 15, 2);
            $table->string('main_amt_fact');
            $table->decimal('ndfl_amt', 15, 2)->nullable();
            $table->float('percent_available', 15, 2)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

    }
}
