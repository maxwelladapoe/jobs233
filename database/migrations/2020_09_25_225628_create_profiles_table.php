<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id');
            $table->string('picture')->default('/storage/userimages/profile.svg');
            $table->string('gender')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('country')->nullable();
            $table->string('city')->nullable();
            $table->text('address')->nullable();
            $table->text('bio')->nullable();
            $table->string('preference');
            $table->boolean('is_occupied')->default(false);
            $table->bigInteger('preferred_currency_id')->default(1);
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
        Schema::dropIfExists('profiles');
    }
}
