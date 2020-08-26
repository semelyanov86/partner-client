<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLoanMemfeeSchedulesTable extends Migration
{
    public function up()
    {
        Schema::create('loan_memfee_schedules', function (Blueprint $table) {
            $table->increments('id');
            $table->date('date_plan');
            $table->decimal('mem_fee_plan', 15, 2);
            $table->decimal('mem_fee_fact', 15, 2);
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
