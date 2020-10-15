<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAssignedToWorkerIdToProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('projects', function (Blueprint $table) {
            //
            $table->bigInteger('assigned_directly_to_id')->nullable()->after('bidding_closed');
            $table->boolean('accepted_by_assigned_worker')->default(0)->after('assigned_directly_to_id');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('projects', function (Blueprint $table) {
            //
            $table->dropColumn('assigned_directly_to_id');
            $table->dropColumn('accepted_by_assigned_worker');
        });
    }
}
