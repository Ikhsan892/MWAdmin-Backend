<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPengirimanIdToResis extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('resis', function (Blueprint $table) {
            $table->foreignId('pengiriman_id')->nullable()->after('metode_pembayaran_id');
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
            $table->dropColumn('pengiriman_id');
        });
    }
}
