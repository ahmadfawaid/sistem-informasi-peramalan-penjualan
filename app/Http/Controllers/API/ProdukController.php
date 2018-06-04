<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Produk;

class ProdukController extends Controller
{
    public function index($perPage)
    {
        $data = Produk::orderBy('id', 'desc')->with('jenis')->with('satuanPembelian')->with('satuanPenjualan')->withCount('persediaan')->withCount('detailPenjualan')->withCount('detailPembelian')->paginate($perPage);
        return response()->json($data);
    }

    public function store(Request $request, $perPage)
    {
        $request->validate([
            'kode_produk'           => 'required|string|unique:produks,kode_produk|max:10',
            'nama_produk'           => 'required|string|max:40',
            'jenis_produk_id'       => 'required|numeric',
            'satuan_pembelian_id'   => 'required|numeric',
            'isi'                   => 'required|numeric',
            'satuan_penjualan_id'   => 'required|numeric',
            'harga_beli'            => 'nullable|numeric',
            'harga_jual'            => 'nullable|numeric',
            'stok_minimal'          => 'nullable|numeric'
        ]);

        Produk::create([
            'kode_produk'           => $request->kode_produk,
            'nama_produk'           => $request->nama_produk,
            'jenis_produk_id'       => $request->jenis_produk_id,
            'satuan_pembelian_id'   => $request->satuan_pembelian_id,
            'isi'                   => $request->isi,
            'satuan_penjualan_id'   => $request->satuan_penjualan_id,
            'harga_beli'            => $request->harga_beli == null ? 0 : $request->harga_beli,
            'harga_jual'            => $request->harga_jual == null ? 0 : $request->harga_jual,
            'stok_minimal'          => $request->stok_minimal
        ]);

        return $this->index($request->per_page);
    }

    public function show($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'kode_produk'           => 'required|string|unique:produks,kode_produk,'.$request->id.'|max:10',
            'nama_produk'           => 'required|string|max:40',
            'jenis_produk_id'       => 'required|numeric',
            'satuan_pembelian_id'   => 'required|numeric',
            'isi'                   => 'required|numeric',
            'satuan_penjualan_id'   => 'required|numeric',
            'harga_beli'            => 'nullable|numeric',
            'harga_jual'            => 'nullable|numeric',
            'stok_minimal'          => 'nullable|numeric'
        ]);

        Produk::where('id', $id)->update([
            'kode_produk'           => $request->kode_produk,
            'nama_produk'           => $request->nama_produk,
            'jenis_produk_id'       => $request->jenis_produk_id,
            'satuan_pembelian_id'   => $request->satuan_pembelian_id,
            'isi'                   => $request->isi,
            'satuan_penjualan_id'   => $request->satuan_penjualan_id,
            'harga_beli'            => $request->harga_beli,
            'harga_jual'            => $request->harga_jual,
            'stok_minimal'          => $request->stok_minimal
        ]);

        $data = Produk::where('id', $id)->with('jenis')->with('satuanPembelian')->with('satuanPenjualan')->first();
        return response()->json($data);
    }

    public function destroy(Request $request, $perPage)
    {
        foreach($request->all() as $key => $value){
            Produk::where('id', $request[$key]['id'])->delete();
        }
        return $this->index($perPage);
    }

    public function checkForm(Request $request, $form)
    {
        if($form == 'nama_produk'){
            $request->validate([
                'nama_produk'           => 'required|string|max:40',
            ]);
        }elseif($form == 'jenis_produk_id'){
            $request->validate([
                'jenis_produk_id'       => 'required|numeric',
            ]);
        }elseif($form == 'satuan_pembelian_id'){
            $request->validate([
                'satuan_pembelian_id'   => 'required|numeric',
            ]);
        }elseif($form == 'isi'){
            $request->validate([
                'isi'                   => 'required|numeric',
            ]);
        }elseif($form == 'satuan_penjualan_id'){
            $request->validate([
                'satuan_penjualan_id'   => 'required|numeric',
            ]);
        }elseif($form == 'harga_beli'){
            $request->validate([
                'harga_beli'            => 'nullable|numeric',
            ]);
        }elseif($form == 'harga_jual'){
            $request->validate([
                'harga_jual'            => 'nullable|numeric',
            ]);
        }elseif($form == 'stok_minimal'){
            $request->validate([
                'stok_minimal'          => 'nullable|numeric',
            ]);
        }
    }

    public function getOptions()
    {
        $data = Produk::select('id as value', 'nama_produk as text')->orderBy('nama_produk', 'asc')->get();
        return response()->json($data);
    }

    public function getList()
    {
        $data = Produk::orderBy('nama_produk', 'asc')->with('jenis')->with('satuan')->get();
        return response()->json($data);
    }
}
