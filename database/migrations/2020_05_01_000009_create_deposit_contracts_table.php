<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDepositContractsTable extends Migration
{
    public function up()
    {
        Schema::create('deposit_contracts', function (Blueprint $table) {
            $table->increments('id');
            $table->date('date_calculate');
            $table->string('agreement');
            $table->date('date_start');
            $table->date('date_end');
            $table->float('percent', 15, 2);
            $table->boolean('is_open')->default(0)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

    }
}
