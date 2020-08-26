<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNoFieldToSchedules extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('deposit_schedules', function (Blueprint $table) {
            $table->integer('no')->default(0);
        });

        Schema::table('loan_main_schedules', function (Blueprint $table) {
            $table->integer('no')->default(0);
        });

        Schema::table('loan_memfee_schedules', function (Blueprint $table) {
            $table->integer('no')->default(0);
        });
    }
}
