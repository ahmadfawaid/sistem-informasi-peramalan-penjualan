<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    protected $fillable = ['nomor_faktur', 'tanggal', 'jumlah_bayar', 'total', 'user_id'];
    public $timestamps = false;

    public function detailPenjualan()
    {
        return $this->hasMany(DetailPenjualan::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getDetailPenjualanCountAttribute($value)
    {
        $pcsCount = 0;
        foreach ($this->detailPenjualan as $data) {
            $pcsCount += $data->kuantitas;
        }

        return count($this->detailPenjualan).' item, '.$pcsCount.' pcs';
    }

    public static function getPeriode($request)
    {
        $array= array();
        $month = $request->from;
        $i = 0;
        while(date('Y-m', strtotime($month)) <= date('Y-m', strtotime($request->to))) {
            $array[$i] = $month;
            $month = date('Y-m', strtotime("+1 month", strtotime(date($month))));
            $i++;
        }

        return $array;
    }

    public static function getTotal($periode, $data)
    {
        $array = array();
        for($i=0; $i<count($periode); $i++) {
            for($j=0; $j<count($data); $j++) {
                if($periode[$i] == $data[$j]['periode']){
                    $array[$i] = intval($data[$j]['total']);
                    break;
                }else{
                    $array[$i] = 0;
                }
            }
        }
        return $array;
    }


    public static function getDataPenjualan($request)
    {
        $produk_id = $request->produk_id;
        $from = $request->from;
        $to = $request->to;

        $data = Penjualan::selectRaw('DATE_FORMAT(penjualans.tanggal, "%Y-%m") as periode, sum(kuantitas) as total')
            ->join('detail_penjualans', 'penjualans.id', '=', 'detail_penjualans.penjualan_id')
            ->where('detail_penjualans.produk_id', $produk_id)
            ->whereRaw("DATE_FORMAT(penjualans.tanggal, '%Y-%m') >= '$from' AND DATE_FORMAT(penjualans.tanggal, '%Y-%m') <= '$to'")
            ->groupBy('periode')
            ->get();

        return $data;
    }

    public static function getAllDataPenjualan()
    {
        $array = [];
        for($i = 0; $i < 12; $i++) {
            $array[$i] = '';
        }
        // $array[11] = '2018-02'; // diganti get month bulan sekarang
        $array[11] = date('Y-m');
        $i = 10;
        while($i >= 0) {
            $array[$i] = date('Y-m', strtotime("-1 month", strtotime(date($array[$i + 1]))));
            $i--;
        }

        $data = Penjualan::selectRaw('DATE_FORMAT(tanggal, "%Y-%m") as periode, sum(total) as total')
            ->whereRaw("DATE_FORMAT(tanggal, '%Y-%m') >= '$array[0]' AND DATE_FORMAT(tanggal, '%Y-%m') <= '$array[11]'")
            ->groupBy('periode')
            ->get();

        return ['periode' => $array, 'data' => $data];
    }

    // public static function getData($type, $request)
    // {
    //     if ($request->produk_id == null) {
    //         $data = Penjualan::selectRaw('DATE_FORMAT(penjualans.tanggal, "%Y-%m") as periode, sum(kuantitas) as total')
    //             ->join('detail_penjualans', 'penjualans.id', '=', 'detail_penjualans.penjualan_id')
    //             ->whereRaw("DATE_FORMAT(penjualans.tanggal, '%Y-%m') >= '$request->from' AND DATE_FORMAT(penjualans.tanggal, '%Y-%m') <= '$request->to'")
    //             ->groupBy('periode')
    //             ->get();
    //     } else {
    //         $data = Penjualan::selectRaw('DATE_FORMAT(penjualans.tanggal, "%Y-%m") as periode, sum(kuantitas) as total')
    //             ->join('detail_penjualans', 'penjualans.id', '=', 'detail_penjualans.penjualan_id')
    //             ->where('detail_penjualans.produk_id', $request->produk_id)
    //             ->whereRaw("DATE_FORMAT(penjualans.tanggal, '%Y-%m') >= '$request->from' AND DATE_FORMAT(penjualans.tanggal, '%Y-%m') <= '$request->to'")
    //             ->groupBy('periode')
    //             ->get();
    //     }

    //     $array = array();
    //     foreach($data as $key => $value) {
    //         $array[$key] = $value[$type];
    //     }

    //     return $array;
    // }
}
