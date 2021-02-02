<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOriginalFileLocationToAttachments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('attachments', function (Blueprint $table) {
            //
            $table->boolean('is_water_marked')->default(false)->after('location');
            $table->string('original_file_location')->nullable()->after('is_water_marked')->default(null);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('attachments', function (Blueprint $table) {
            //
            $table->dropColumn('is_water_marked');
            $table->dropColumn('original_file_location');
        });
    }
}
