<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Persediaan extends Model
{
    protected $fillable = ['rak_id', 'produk_id', 'stok', 'tanggal_kadaluarsa'];
    public $timestamps = false;
    protected $dateFormat = 'd-m-Y';

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'produk_id');
    }

    public function Rak()
    {
        return $this->belongsTo(Rak::class, 'rak_id');
    }
}
