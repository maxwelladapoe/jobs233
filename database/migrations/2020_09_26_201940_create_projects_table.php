<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->bigInteger('user_id');
            $table->bigInteger('category_id');
            $table->bigInteger('secondary_category_id')->nullable();
            $table->bigInteger('manager_id')->nullable();
            $table->bigInteger('worker_id')->nullable();
            $table->string('title');
            $table->string('slug')->nullable();
            $table->text('description');
            $table->text('additional_details')->nullable();
            $table->string('skills')->nullable();
            $table->string('complexity')->nullable();
            $table->string('currency_id');
            $table->double('budget');
            $table->string('tags')->nullable();
            $table->date('deadline')->nullable();
            $table->string('status')->default('created');
            $table->boolean('published')->default(true);
            $table->bigInteger('accepted_bid_id')->nullable();
            $table->boolean('bidding_closed')->nullable();
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
        Schema::dropIfExists('projects');
    }
}
