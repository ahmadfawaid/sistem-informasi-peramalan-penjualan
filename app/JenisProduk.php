<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JenisProduk extends Model
{
    protected $fillable = ['jenis'];
    public $timestamps = false;

    public function produk()
    {
        return $this->hasMany(Produk::class);
    }
}
