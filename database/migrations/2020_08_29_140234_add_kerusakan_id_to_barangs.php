<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddKerusakanIdToBarangs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('barangs', function (Blueprint $table) {
            $table->foreignId('kerusakan_id')->nullable()->after('nama_barang');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('barangs', function (Blueprint $table) {
            $table->dropColumn('kerusakan_id');
        });
    }
}
