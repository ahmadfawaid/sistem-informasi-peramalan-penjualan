<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDetailPembeliansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_pembelians', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('pembelian_id');
            $table->unsignedInteger('produk_id');
            $table->unsignedInteger('kuantitas');
            $table->unsignedInteger('harga_satuan');
            $table->date('tanggal_kadaluarsa')->nullable();
        });

        Schema::table('detail_pembelians', function (Blueprint $table) {
            $table->foreign('pembelian_id')->references('id')->on('pembelians')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('detail_pembelians');
    }
}
