<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pembelian extends Model
{
    protected $fillable = ['nomor_faktur', 'vendor_id', 'tanggal', 'total', 'user_id'];
    public $timestamps = false;

    public function detailPembelian()
    {
        return $this->hasMany(DetailPembelian::class);
    }

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getDetailPembelianCountAttribute($value)
    {
        $pcsCount = 0;
        foreach ($this->detailPembelian as $data) {
            $pcsCount += $data->kuantitas;
        }

        return count($this->detailPembelian).' item, '.$pcsCount.' pcs';
    }
}
