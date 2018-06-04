<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    protected $fillable = ['kode_produk', 'nama_produk', 'jenis_produk_id', 'satuan_pembelian_id', 'isi', 'satuan_penjualan_id', 'harga_beli', 'harga_jual', 'stok_minimal'];
    public $timestamps = false;

    public function persediaan()
    {
        return $this->hasMany(Persediaan::class);
    }

    public function detailPenjualan()
    {
        return $this->hasMany(DetailPenjualan::class);
    }

    public function detailPembelian()
    {
        return $this->hasMany(DetailPembelian::class);
    }

    public function jenis()
    {
        return $this->belongsTo(JenisProduk::class, 'jenis_produk_id');
    }

    public function satuanPembelian()
    {
        return $this->belongsTo(satuanPembelian::class, 'satuan_pembelian_id');
    }

    public function satuanPenjualan()
    {
        return $this->belongsTo(SatuanPenjualan::class, 'satuan_penjualan_id');
    }    
}
