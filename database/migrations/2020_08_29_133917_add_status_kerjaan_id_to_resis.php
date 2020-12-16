<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusKerjaanIdToResis extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('resis', function (Blueprint $table) {
            $table->foreignId('status_kerjaan_id')->nullable()->after('pengiriman_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('resis', function (Blueprint $table) {
            $table->dropColumn('status_kerjaan_id');
        });
    }
}
