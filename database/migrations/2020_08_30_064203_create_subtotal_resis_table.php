<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubtotalResisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subtotal_resis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('resi_id')->nullable();
            $table->string('nama_subtotal');
            $table->integer('nominal');
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
        Schema::dropIfExists('subtotal_resis');
    }
}
