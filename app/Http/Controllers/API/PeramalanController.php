<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Penjualan;
use App\Produk;

class PeramalanController extends Controller
{
    public function peramalan(Request $request) {    
        // mendapatkan data penjualan dari database berdasarkan request
        $data = Penjualan::getDataPenjualan($request);

        $periode = Penjualan::getPeriode($request);
        $X = Penjualan::getTotal($periode, $data);
        $F = array();
        $e = array();
        $E = array();
        $AE = array();
        $alpha = array();
        $beta = [0.1, 0.2, 0.3, 0.4, 0.5, 0.6, 0.7, 0.8, 0.9];
        $PE = array();
        $MAPE = array();

        // perhitungan peramalan menggunakan nilai beta mulai dari 0.1 sampai 0.9
        for($i = 0; $i < count($beta); $i++) {
            // inisialisasi
            $F[$i][0] = $e[$i][0] = $E[$i][0] = $AE[$i][0] = $alpha[$i][0] = $PE[$i][0] = 0;
            $F[$i][1] = $X[0];
            $alpha[$i][1] = $beta[$i];

            for($j = 1; $j < count($periode); $j++){
                // perhitungan peramalan untuk periode berikutnya
                $F[$i][$j + 1] = ($alpha[$i][$j] * $X[$j]) + ((1 - $alpha[$i][$j]) * $F[$i][$j]);

                // menghitung selisih antara nilai aktual dengan hasil peramalan
                $e[$i][$j] = $X[$j] - $F[$i][$j]; 

                // menghitung nilai kesalahan peramalan yang dihaluskan
                $E[$i][$j] = ($beta[$i] * $e[$i][$j]) + ((1 - $beta[$i]) * $E[$i][$j - 1]);

                // menghitung nilai kesalahan absolut peramalan yang dihaluskan
                $AE[$i][$j] = ($beta[$i] * abs($e[$i][$j])) + ((1 - $beta[$i]) * $AE[$i][$j - 1]);

                // menghitung nilai alpha untuk periode berikutnya
                $alpha[$i][$j + 1] = $E[$i][$j] == 0 ? $beta[$i] : abs($E[$i][$j] / $AE[$i][$j]);

                // menghitung nilai kesalahan persentase peramalan
                $PE[$i][$j] = $X[$j] == 0 ? 0 : abs((($X[$j] - $F[$i][$j]) / $X[$j]) * 100);
            }

            // menghitung rata-rata kesalahan peramalan
            $MAPE[$i] = array_sum($PE[$i])/(count($periode) - 1);
        }

        // mendapatkan index beta dengan nilai mape terkecil
        $bestBetaIndex = array_search(min($MAPE), $MAPE);

        // menyatukan semua hasil perhitungan dan menginputkan hasil peramalan periode berikutnya
        $hasil = array();
        for ($i = 0; $i <= count($periode); $i++) {
            if ($i < count($periode)) {
                $hasil[$i] = [
                    'periode'                   => $periode[$i],
                    'aktual'                    => $X[$i],
                    'peramalan'                 => $F[$bestBetaIndex][$i],
                    'galat'                     => $e[$bestBetaIndex][$i],
                    'galat_pemulusan'           => $E[$bestBetaIndex][$i],
                    'galat_pemulusan_absolut'   => $AE[$bestBetaIndex][$i],
                    'alpha'                     => $alpha[$bestBetaIndex][$i],
                    'percentage_error'          => $PE[$bestBetaIndex][$i]
                ];
            } else {
                $nextPeriode = date('Y-m', strtotime("+1 month", strtotime(date($request->to))));
                $hasil[$i] = [
                    'periode'                   => $nextPeriode,
                    'aktual'                    => 0,
                    'peramalan'                 => $F[$bestBetaIndex][$i],
                    'galat'                     => 0,
                    'galat_pemulusan'           => 0,
                    'galat_pemulusan_absolut'   => 0,
                    'alpha'                     => $alpha[$bestBetaIndex][$i],
                    'percentage_error'          => 0
                ];
            }
        }

        $request->produk_id == null ? $produk = '' : $produk = Produk::where('id', $request->produk_id)->with('jenis')->with('satuanPembelian')->with('satuanPenjualan')->first();

        $peramalan = ['hasil' => $hasil, 'beta' => $beta[$bestBetaIndex], 'mape' => $MAPE[$bestBetaIndex], 'produk' => $produk];

        return response()->json($peramalan);
    }
}
