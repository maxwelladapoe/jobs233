<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPaymentTypeToProjectPayments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('project_payments', function (Blueprint $table) {
            $table->bigInteger('currency_id')->after('payment_id');
            $table->double('balance_after')->nullable()->after('amount');
            $table->string('type')->after('balance_after');
            $table->string('description')->after('type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('project_payments', function (Blueprint $table) {
            $table->dropColumn('currency_id');
            $table->dropColumn('balance_after');
            $table->dropColumn('type');
            $table->dropColumn('description');

        });
    }
}
