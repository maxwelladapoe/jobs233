<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRatingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ratings', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id');
            $table->uuid('project_id');
            $table->bigInteger('rated_by_user_id');
            $table->double('total_average_rating',5,2)->nullable();
            $table->double('skill',5,2)->nullable();
            $table->double('qow',5,2)->nullable();
            $table->double('cooperation',5,2)->nullable();
            $table->double('communication',5,2)->nullable();
            $table->double('timeliness',5,2)->nullable();
            $table->text('review')->nullable();
            $table->string('hire_again')->nullable();
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
        Schema::dropIfExists('ratings');
    }
}
