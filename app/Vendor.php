<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    protected $fillable = ['nama_vendor', 'kota', 'telepon'];
    public $timestamps = false;

    public function pembelian()
    {
        return $this->hasMany(Pembelian::class);
    }
}
