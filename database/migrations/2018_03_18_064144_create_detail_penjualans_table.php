<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDetailPenjualansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_penjualans', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('penjualan_id');
            $table->unsignedInteger('produk_id');
            $table->unsignedInteger('kuantitas');
            $table->unsignedInteger('harga_satuan');
        });

        Schema::table('detail_penjualans', function (Blueprint $table) {
            $table->foreign('penjualan_id')->references('id')->on('penjualans')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('produk_id')->references('id')->on('produks')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detail_penjualans');
    }
}
