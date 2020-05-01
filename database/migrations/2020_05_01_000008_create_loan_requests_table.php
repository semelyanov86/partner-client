<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLoanRequestsTable extends Migration
{
    public function up()
    {
        Schema::create('loan_requests', function (Blueprint $table) {
            $table->increments('id');
            $table->string('request_no');
            $table->decimal('amount', 15, 2);
            $table->string('status');
            $table->timestamps();
            $table->softDeletes();
        });

    }
}
