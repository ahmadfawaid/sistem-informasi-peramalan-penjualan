<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Persediaan;
use App\Rak;
use DB;

class PersediaanController extends Controller
{
    public function index($nomorRak, $perPage)
    {
        $data = Persediaan::select('persediaans.id', 'persediaans.rak_id', 'raks.nomor_rak', 'persediaans.produk_id', 'produks.nama_produk', 'produks.kode_produk', 'satuan_penjualans.satuan', 'produks.harga_beli', 'produks.harga_jual', 'persediaans.stok', 'persediaans.tanggal_kadaluarsa')
                ->join('raks', 'persediaans.rak_id', '=', 'raks.id')
                ->join('produks', 'persediaans.produk_id', '=', 'produks.id')
                ->join('satuan_penjualans', 'produks.satuan_penjualan_id', '=', 'satuan_penjualans.id')
                ->where('raks.nomor_rak', $nomorRak)
                ->orderBy('tanggal_kadaluarsa', 'asc')
                ->paginate($perPage);

        return response()->json($data);
    }

    public function getPerRak($nomorRak)
    {
        $data = Persediaan::select('persediaans.id', 'persediaans.rak_id', 'raks.nomor_rak', 'persediaans.produk_id', 'persediaans.stok')
                ->join('raks', 'persediaans.rak_id', '=', 'raks.id')
                ->join('produks', 'persediaans.produk_id', '=', 'produks.id')
                ->where('raks.nomor_rak', $nomorRak)
                ->orderBy('tanggal_kadaluarsa', 'asc')
                ->get();

        return response()->json($data);
    }

    public function store(Request $request, $nomorRak, $perPage)
    {
        $request->validate([
            'produk_id'             => 'required|numeric',
            'stok'                  => 'required|numeric',
            'tanggal_kadaluarsa'    => 'nullable|date',
        ]);

        $rak = Rak::where('nomor_rak', '=', $nomorRak)->first();

        Persediaan::create([
            'rak_id'                => $rak->id,
            'produk_id'             => $request->produk_id,
            'stok'                  => $request->stok,
            'tanggal_kadaluarsa'    => $request->tanggal_kadaluarsa,
        ]);

        return $this->index($nomorRak, $perPage);
    }

    public function update(Request $request, $nomorRak, $perPage)
    {
        $request->validate([
            'produk_id'             => 'required|numeric',
            'stok'                  => 'required|numeric',
            'tanggal_kadaluarsa'    => 'nullable|date',
        ]);

        Persediaan::where('id', $request->id)->update([
            'produk_id'             => $request->produk_id,
            'stok'                  => $request->stok,
            'tanggal_kadaluarsa'    => $request->tanggal_kadaluarsa,
        ]);

        return $this->index($nomorRak, $perPage);
    }

    public function move(Request $request, $newRakID, $nomorRak, $perPage)
    {
        foreach($request->all() as $key => $value){
            Persediaan::where('id', $request[$key]['id'])->update([
                'rak_id'    => $newRakID
            ]);
        }
        return $this->index($nomorRak, $perPage);
    }

    public function checkForm(Request $request, $form)
    {
        if($form == 'produk_id'){
            $request->validate([
                'produk_id'             => 'required|numeric',
            ]);
        }elseif($form == 'stok'){
            $request->validate([
                'stok'                  => 'required|numeric',
            ]);
        }elseif($form == 'tanggal_kadaluarsa'){
            $request->validate([
                'tanggal_kadaluarsa'    => 'nullable|date',
            ]);
        }
    }

    public function getList()
    {
        $data = DB::select('SELECT `persediaans`.id, produk_id, kode_produk, nama_produk, harga_jual, jenis, satuan, sum(stok) as stok FROM `persediaans` JOIN produks ON `persediaans`.produk_id = `produks`.id JOIN jenis_produks ON `produks`.jenis_produk_id = `jenis_produks`.id JOIN satuan_penjualans ON `produks`.satuan_penjualan_id = `satuan_penjualans`.id GROUP BY produk_id');
        return response()->json($data);
    }

    public function getTotalPersediaan()
    {
        $data = DB::select('SELECT COUNT(produk_id) as produk, SUM(stok) as total FROM `persediaans`');
        return response()->json($data);
    }
}
