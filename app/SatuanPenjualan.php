<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Produk;

class SatuanPenjualan extends Model
{
    protected $fillable = ['satuan'];
    public $timestamps = false;

    public function produk()
    {
        return $this->hasMany(Produk::class);
    }
}
