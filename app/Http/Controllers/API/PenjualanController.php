<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Penjualan;
use App\DetailPenjualan;
use App\Persediaan;
use Carbon\Carbon;
use DB;

class PenjualanController extends Controller
{
    public function index($perPage)
    {
        $data = Penjualan::orderBy('tanggal', 'desc')->orderBy('nomor_faktur', 'desc')->withCount('detailPenjualan')->with('user')->paginate($perPage);
        return response()->json($data);
    }

    public function store(Request $request, $perPage)
    {
        $request->validate([
            'nomor_faktur'  => 'required|string',
            'tanggal'       => 'required|date',
            'jumlah_bayar'  => 'required|numeric',
            'total'         => 'required|numeric'
        ]);

        Penjualan::create([
            'nomor_faktur'  => $request->nomor_faktur,
            'tanggal'       => $request->tanggal,
            'jumlah_bayar'  => $request->jumlah_bayar,
            'total'         => $request->total,
            'user_id'       => $request->user_id
        ]);

        for ($i=0; $i < count($request->detail_penjualan); $i++) { 
            DetailPenjualan::create([
                'penjualan_id'      => $this->getPenjualanID($request->nomor_faktur),
                'produk_id'         => $request->detail_penjualan[$i]['produk_id'],
                'kuantitas'         => $request->detail_penjualan[$i]['kuantitas'],
                'harga_satuan'      => $request->detail_penjualan[$i]['harga_satuan'],
            ]);

            $produk_id = $request->detail_penjualan[$i]['produk_id'];
            $kuantitas = $request->detail_penjualan[$i]['kuantitas'];

            $persediaan = Persediaan::where('produk_id', $produk_id)->get();

            $n = 0;
            for($j = 0; $j < count($persediaan); $j++){
                $stok = $persediaan[$j]['stok'];
                if(($n + $stok) > $kuantitas) {
                    $terkurangi = $stok - (($n + $stok) - $kuantitas);
                    Persediaan::where('id', $persediaan[$j]['id'])->update([
                        'stok' => ($stok - $terkurangi)
                    ]);
                    break;
                }
                $n += $persediaan[$j]['stok'];
                Persediaan::where('id', $persediaan[$j]['id'])->delete();
            }
        }

        return $this->index($perPage);
    }

    public function detail($nomorFaktur)
    {
        $penjualan = Penjualan::withCount('detailPenjualan')->with('user')->where('nomor_faktur', $nomorFaktur)->first();
        $detail = DetailPenjualan::join('penjualans', 'detail_penjualans.penjualan_id', '=', 'penjualans.id')
                ->join('produks', 'detail_penjualans.produk_id', '=', 'produks.id')
                ->join('jenis_produks', 'produks.jenis_produk_id', '=', 'jenis_produks.id')
                ->where('penjualans.nomor_faktur', $nomorFaktur)
                ->get();
        return response()->json(['penjualan' => $penjualan, 'detail' => $detail]);
    } 

    public function getPenjualanID($nomor_faktur) {
        $data = Penjualan::where('nomor_faktur', $nomor_faktur)->first();
        return $data->id;
    }

    public function getPenjualan() {
        $data = Penjualan::getAllDataPenjualan();
        $periode = $data['periode'];
        $penjualan = Penjualan::getTotal($data['periode'],$data['data']);
        return response()->json(['periode' => $periode, 'penjualan' => $penjualan]);
    }

    public function getNomorFaktur() {
        $nextNomorFaktur = '';
        $data = Penjualan::orderBy('id', 'desc')->first();
        $year = Carbon::today()->year;

        if(empty($data)){
            $nextNomorFaktur = 'RM'.substr($year, 2) . $this->addLeadingZero(1);
        }else{
            // $number = explode('-', $data); //RM17-00001
            $number = substr($data->nomor_faktur, 4);
            $before = $this->removeLeadingZero($number);
            $new = $this->addLeadingZero($before + 1);
            $nextNomorFaktur = 'RM'.substr($year, 2) . $new;
        }

        return response()->json($nextNomorFaktur);
    }

    public function addLeadingZero($value, $threshold = 5) {
        return sprintf('%0' . $threshold . 's', $value);
    }

    public function removeLeadingZero($value) {
        return (int)ltrim($value, '0');
    }
}
