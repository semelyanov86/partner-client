<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class NullableDatesToLoanMemfeeSchedules extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('loan_memfee_schedules', function (Blueprint $table) {
            $table->date('date_plan')->nullable()->default(null)->change();
            $table->date('date_fact')->nullable()->default(null);
        });
    }
}
