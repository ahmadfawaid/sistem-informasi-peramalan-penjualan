<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Pembelian;
use App\DetailPembelian;
use App\Persediaan;
use App\Produk;
use Auth;

class PembelianController extends Controller
{
    public function index($perPage)
    {
        $data = Pembelian::orderBy('tanggal', 'desc')->withCount('detailPembelian')->with('vendor')->with('user')->paginate($perPage);
        return response()->json($data);
    }

    public function store(Request $request, $rakID, $perPage)
    {
        $request->validate([
            'nomor_faktur'  => 'required|string',
            'vendor_id'     => 'required|numeric',
            'tanggal'       => 'required|date',
            'total'         => 'required|numeric',
            'user_id'       => 'required|numeric'
        ]);

        Pembelian::create([
            'nomor_faktur'  => $request->nomor_faktur,
            'vendor_id'     => $request->vendor_id,
            'tanggal'       => $request->tanggal,
            'total'         => $request->total,
            'user_id'       => $request->user_id
        ]);

        for ($i=0; $i < count($request->detail_pembelian); $i++) { 
            DetailPembelian::create([
                'pembelian_id'      => $this->getPembelianID($request->nomor_faktur),
                'produk_id'         => $request->detail_pembelian[$i]['produk_id'],
                'kuantitas'         => $request->detail_pembelian[$i]['kuantitas'],
                'harga_satuan'      => $request->detail_pembelian[$i]['harga_satuan'],
            ]);

            $isi = Produk::where('id', $request->detail_pembelian[$i]['produk_id'])->first()->isi;
            $stok = $isi * $request->detail_pembelian[$i]['kuantitas'];

            Persediaan::create([
                'rak_id'                => $rakID,
                'produk_id'             => $request->detail_pembelian[$i]['produk_id'],
                'stok'                  => $stok
            ]);

            Produk::where('id', $request->detail_pembelian[$i]['produk_id'])->update([
                'harga_beli'           => $request->detail_pembelian[$i]['harga_satuan']
            ]);
        }

        return $this->index($perPage);
    }

    public function skip(Request $request, $perPage)
    {
        $request->validate([
            'nomor_faktur'  => 'required|string',
            'vendor_id'     => 'required|numeric',
            'tanggal'       => 'required|date',
            'total'         => 'required|numeric',
            'user_id'       => 'required|numeric'
        ]);

        Pembelian::create([
            'nomor_faktur'  => $request->nomor_faktur,
            'vendor_id'     => $request->vendor_id,
            'tanggal'       => $request->tanggal,
            'total'         => $request->total,
            'user_id'       => $request->user_id
        ]);

        for ($i=0; $i < count($request->detail_pembelian); $i++) { 
            DetailPembelian::create([
                'pembelian_id'      => $this->getPembelianID($request->nomor_faktur),
                'produk_id'         => $request->detail_pembelian[$i]['produk_id'],
                'kuantitas'         => $request->detail_pembelian[$i]['kuantitas'],
                'harga_satuan'      => $request->detail_pembelian[$i]['harga_satuan'],
            ]);
        }

        return $this->index($perPage);
    }

    public function update(Request $request, $perPage)
    {
        $request->validate([
            'nomor_faktur'  => 'required|string',
            'vendor_id'     => 'required|numeric',
            'tanggal'       => 'required|date',
            'total'         => 'required|numeric',
            'user_id'       => 'required|numeric'
        ]);

        Pembelian::where('id', $request->id)->update([
            'nomor_faktur'  => $request->nomor_faktur,
            'vendor_id'     => $request->vendor_id,
            'tanggal'       => $request->tanggal,
            'total'         => $request->total,
            'user_id'       => $request->user_id
        ]);

        $detailPembelian = DetailPembelian::where('pembelian_id', $request->id)->get();

        for ($i=0; $i < count($request->detail_pembelian); $i++) { 
            if($i < count($detailPembelian)) {
                DetailPembelian::where('id', $request->id)->update([
                    'produk_id'         => $request->detail_pembelian[$i]['produk_id'],
                    'kuantitas'         => $request->detail_pembelian[$i]['kuantitas'],
                    'harga_satuan'      => $request->detail_pembelian[$i]['harga_satuan'],
                ]);
            }else{
                DetailPembelian::create([
                    'pembelian_id'      => $request->id,
                    'produk_id'         => $request->detail_pembelian[$i]['produk_id'],
                    'kuantitas'         => $request->detail_pembelian[$i]['kuantitas'],
                    'harga_satuan'      => $request->detail_pembelian[$i]['harga_satuan'],
                ]);
            }
        }

        return $this->index($perPage);
    }

    public function getPembelianID($nomorFaktur) {
        $data = Pembelian::where('nomor_faktur', $nomorFaktur)->first();
        return $data->id;
    }

    public function detail($nomorFaktur)
    {
        $pembelian = Pembelian::withCount('detailPembelian')->with('user')->with('vendor')->where('nomor_faktur', $nomorFaktur)->first();
        $detail = DetailPembelian::join('pembelians', 'detail_pembelians.pembelian_id', '=', 'pembelians.id')
                ->join('produks', 'detail_pembelians.produk_id', '=', 'produks.id')
                ->where('pembelians.nomor_faktur', $nomorFaktur)
                ->get();
        return response()->json(['pembelian' => $pembelian, 'detail' => $detail]);
    } 

    public function edit($nomorFaktur)
    {
        $data = Pembelian::withCount('detailPembelian')->where('nomor_faktur', $nomorFaktur)->first();
        return response()->json($data);
    }

    public function checkForm(Request $request, $form)
    {
        if($form == 'vendor_id'){
            $request->validate([
                'vendor_id'     => 'required|numeric',
            ]);
        }elseif($form == 'nomor_faktur'){
            $request->validate([
                'nomor_faktur'  => 'required|string|unique:pembelians,nomor_faktur,'.$request->id.'',
            ]);
        }elseif($form == 'tanggal'){
            $request->validate([
                'tanggal'       => 'required|date',
            ]);
        }
    }
}
