<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\SatuanPenjualan;

class SatuanPenjualanController extends Controller
{
    public function index($perPage)
    {
        $data = SatuanPenjualan::orderBy('id', 'desc')->withCount('produk')->paginate($perPage);
        return response()->json($data);
    }

    public function store(Request $request, $perPage)
    {
        $request->validate([
            'satuan'     => 'required|string|unique:satuan_penjualans,satuan',
        ]);

        SatuanPenjualan::create([
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
            'satuan'     => 'required|string|unique:satuan_penjualans,satuan,'.$request->id.'',
        ]);

        SatuanPenjualan::where('id', $id)->update([
            'satuan'    => $request->satuan,
        ]);

        $data = SatuanPenjualan::where('id', $id)->withCount('produk')->first();
        return response()->json($data);
    }

    public function destroy(Request $request, $perPage)
    {
        foreach($request->all() as $key => $value){
            SatuanPenjualan::where('id', $request[$key]['id'])->delete();
        }
        return $this->index($perPage);
    }

    public function checkForm(Request $request)
    {
        $request->validate([
            'satuan'     => 'required|string|unique:satuan_penjualans,satuan,'.$request->id.'',
        ]);
    }

    public function getOptions()
    {
        $data = SatuanPenjualan::select('id as value', 'satuan as text')->orderBy('satuan', 'asc')->get();
        return response()->json($data);
    }
}
