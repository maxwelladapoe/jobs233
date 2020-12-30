<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInterfaceLoggerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('interface_logger', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id');
            $table->string('authorization_code');
            $table->string('reference');
            $table->string('currency');
            $table->double('amount');
            $table->string('platform');
            $table->string('ip');
            $table->string('channel');
            $table->string('status');
            $table->text('response');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('interface_logger');
    }
}
