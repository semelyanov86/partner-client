<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DefValuesToLoanContracts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasColumn('loan_contracts', 'date_calculate')) {
            Schema::table('loan_contracts', function (Blueprint $table) {
                $table->dropColumn('date_calculate');
            });
        }

        Schema::table('loan_contracts', function (Blueprint $table) {
            $table->timestamp('date_calculate')->nullable()->default(null);
            $table->date('date_start')->nullable()->default(null)->change();
            $table->date('date_end')->nullable()->default(null)->change();
            $table->decimal('amount', 15, 2)->nullable()->default(null)->change();
            $table->float('percent', 15, 2)->nullable()->default(null)->change();
            $table->float('mem_fee', 15, 2)->nullable()->default(null)->change();
            $table->decimal('mainamt_per_month', 15, 2)->nullable()->default(null)->change();
        });
    }
}
