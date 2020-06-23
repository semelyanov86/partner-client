<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequestsFieldsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('request_fields', function (Blueprint $table) {
            $table->increments('id');
            $table->string('key')->unique();
            $table->integer('no');
            $table->string('title');
            $table->string('placeholder')->nullable();
            $table->boolean('required')->default(0)->nullable();
            $table->string('type');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('requests_fields');
    }
}
