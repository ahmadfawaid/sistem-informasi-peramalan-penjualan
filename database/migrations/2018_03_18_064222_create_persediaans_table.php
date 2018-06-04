<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePersediaansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('persediaans', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('rak_id');
            $table->unsignedInteger('produk_id');
            $table->unsignedInteger('stok');
            $table->date('tanggal_kadaluarsa')->nullable();
        });

        Schema::table('persediaans', function (Blueprint $table) {
            $table->foreign('produk_id')->references('id')->on('produks')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('rak_id')->references('id')->on('raks')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('persediaans');
    }
}
