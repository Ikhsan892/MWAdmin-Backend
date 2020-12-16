<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSparepartIdToKerusakans extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('kerusakans', function (Blueprint $table) {
            $table->foreignId('sparepart_id')->nullable()->after('nama_kerusakan');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('kerusakans', function (Blueprint $table) {
            $table->dropColumn('sparepart_id');
        });
    }
}
