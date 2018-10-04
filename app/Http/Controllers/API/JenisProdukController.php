<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\JenisProduk;

class JenisProdukController extends Controller
{
    public function index($perPage)
    {
        $data = JenisProduk::orderBy('id', 'desc')->withCount('produk')->paginate($perPage);
        return response()->json($data);
    }

    public function store(Request $request, $perPage)
    {
        $request->validate([
            'jenis'     => 'required|string|unique:jenis_produks,jenis',
        ]);

        JenisProduk::create([
            'jenis'    => $request->jenis,
        ]);

        return $this->index($perPage);
    }

    public function show($id)
    {
        //code here
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'jenis'     => 'required|string|unique:jenis_produks,jenis,'.$request->id.'',
        ]);

        JenisProduk::where('id', $id)->update([
            'jenis'    => $request->jenis,
        ]);

        $data = JenisProduk::where('id', $id)->withCount('produk')->first();
        return response()->json($data);
    }

    public function destroy(Request $request, $perPage)
    {
        foreach($request->all() as $key => $value){
            JenisProduk::where('id', $request[$key]['id'])->delete();
        }
        return $this->index($perPage);
    }

    public function checkForm(Request $request)
    {
        $request->validate([
            'jenis'     => 'required|string|unique:jenis_produks,jenis,'.$request->id.'',
        ]);
    }

    public function getOptions()
    {
        $data = JenisProduk::select('id as value', 'jenis as text')->orderBy('jenis', 'asc')->get();
        return response()->json($data);
    }
}
