<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMainamtPerMonthToLoanContracts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('loan_contracts', function (Blueprint $table) {
            $table->decimal('mainamt_per_month', 15, 2);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('loan_contracts', function (Blueprint $table) {
            $table->dropColumn('mainamt_per_month');
        });
    }
}
