<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLoanContractsTable extends Migration
{
    public function up()
    {
        Schema::create('loan_contracts', function (Blueprint $table) {
            $table->increments('id');
            $table->date('date_calculate');
            $table->string('agreement');
            $table->date('date_start');
            $table->date('date_end');
            $table->decimal('amount', 15, 2);
            $table->float('percent', 15, 2);
            $table->float('mem_fee', 15, 2);
            $table->decimal('actual_debt', 15, 2)->nullable();
            $table->decimal('full_debt', 15, 2)->nullable();
            $table->boolean('is_open')->default(0)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
