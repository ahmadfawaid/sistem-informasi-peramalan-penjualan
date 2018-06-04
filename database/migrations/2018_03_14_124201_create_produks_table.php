<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProduksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('produks', function (Blueprint $table) {
            $table->increments('id');
            $table->string('kode_produk', 10)->unique();
            $table->string('nama_produk', 50);
            $table->unsignedInteger('jenis_produk_id');
            $table->unsignedInteger('satuan_pembelian_id');
            $table->unsignedInteger('isi');
            $table->unsignedInteger('satuan_penjualan_id');
            $table->unsignedInteger('harga_beli')->nullable();
            $table->unsignedInteger('harga_jual')->nullable();
            $table->unsignedInteger('stok_minimal')->nullable();
        });

        Schema::table('produks', function (Blueprint $table) {
            $table->foreign('jenis_produk_id')->references('id')->on('jenis_produks')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('satuan_pembelian_id')->references('id')->on('satuan_pembelians')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('satuan_penjualan_id')->references('id')->on('satuan_penjualans')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('produks');
    }
}
