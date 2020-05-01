<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFailedLoginsTable extends Migration
{
    public function up()
    {
        Schema::create('failed_logins', function (Blueprint $table) {
            $table->increments('id');
            $table->string('ip_address');
            $table->string('phone');
            $table->timestamps();
            $table->softDeletes();
        });

    }
}
