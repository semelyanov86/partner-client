<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShareholdersTable extends Migration
{
    public function up()
    {
        Schema::create('shareholders', function (Blueprint $table) {
            $table->increments('id');
            $table->string('phone');
            $table->string('password');
            $table->integer('code')->nullable();
            $table->datetime('sms_sended_at')->nullable();
            $table->string('doc')->nullable();
            $table->string('fio');
            $table->boolean('allow_request')->default(0)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
