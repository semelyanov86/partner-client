<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class NullableFieldsToDepositContracts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasColumn('deposit_contracts', 'date_calculate'))
        {
            Schema::table('deposit_contracts', function (Blueprint $table) {
                $table->dropColumn('date_calculate');
            });
        }

        Schema::table('deposit_contracts', function (Blueprint $table) {
            $table->timestamp('date_calculate')->nullable()->default(null);
            $table->date('date_start')->nullable()->default(null)->change();
            $table->date('date_end')->nullable()->default(null)->change();
            $table->decimal('amount', 15, 2)->nullable()->default(null);
            $table->float('percent', 15, 2)->nullable()->default(null)->change();
        });
    }
}
