<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\SatuanPembelian;

class SatuanPembelianController extends Controller
{
    public function index($perPage)
    {
        $data = SatuanPembelian::orderBy('id', 'desc')->withCount('produk')->paginate($perPage);
        return response()->json($data);
    }

    public function store(Request $request, $perPage)
    {
        $request->validate([
            'satuan'     => 'required|string|unique:satuan_pembelians,satuan',
        ]);

        SatuanPembelian::create([
            'satuan'    => $request->satuan,
        ]);

        return $this->index($perPage);
    }

    public function show($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'satuan'     => 'required|string|unique:satuan_pembelians,satuan,'.$request->id.'',
        ]);

        SatuanPembelian::where('id', $id)->update([
            'satuan'    => $request->satuan,
        ]);

        $data = SatuanPembelian::where('id', $id)->withCount('produk')->first();
        return response()->json($data);
    }

    public function destroy(Request $request, $perPage)
    {
        foreach($request->all() as $key => $value){
            SatuanPembelian::where('id', $request[$key]['id'])->delete();
        }
        return $this->index($perPage);
    }

    public function checkForm(Request $request)
    {
        $request->validate([
            'satuan'     => 'required|string|unique:satuan_pembelians,satuan,'.$request->id.'',
        ]);
    }

    public function getOptions()
    {
        $data = SatuanPembelian::select('id as value', 'satuan as text')->orderBy('satuan', 'asc')->get();
        return response()->json($data);
    }
}
