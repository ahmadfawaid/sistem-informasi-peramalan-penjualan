<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rak extends Model
{
    protected $fillable = ['nomor_rak'];
    public $timestamps = false;

    public function persediaan()
    {
        return $this->hasMany(Persediaan::class);
    }
}
