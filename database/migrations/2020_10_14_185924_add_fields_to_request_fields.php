<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToRequestFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('request_fields', function (Blueprint $table) {
            $table->boolean('personal_data')->default(0)->nullable();
            $table->boolean('read_only')->default(0)->nullable();
        });
    }

}
