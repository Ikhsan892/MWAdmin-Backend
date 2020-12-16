<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMetodePembayaranIdToResis extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('resis', function (Blueprint $table) {
            $table->foreignId('metode_pembayaran_id')->nullable()->after('status_pembayaran_id');
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
            $table->dropColumn('metode_pembayaran_id');
        });
    }
}
