<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Vendor;

class VendorController extends Controller
{
    public function index($perPage)
    {
        $data = Vendor::orderBy('id', 'desc')->withCount('pembelian')->paginate($perPage);
        return response()->json($data);
    }

    public function store(Request $request, $perPage)
    {
        $request->validate([
            'nama_vendor'   => 'required|string|unique:vendors,nama_vendor',
            'kota'          => 'required|string',
            'telepon'       => 'nullable|numeric'
        ]);

        Vendor::create([
            'nama_vendor'   => $request->nama_vendor,
            'kota'          => $request->kota,
            'telepon'       => $request->telepon,
        ]);

        return $this->index($perPage);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_vendor'   => 'required|string|unique:vendors,nama_vendor,'.$request->id.'',
            'kota'          => 'required|string',
            'telepon'       => 'nullable|numeric',
        ]);

        Vendor::where('id', $id)->update([
            'nama_vendor'   => $request->nama_vendor,
            'kota'          => $request->kota,
            'telepon'       => $request->telepon,
        ]);

        $data = Vendor::where('id', $id)->withCount('pembelian')->first();
        return response()->json($data);
    }

    public function destroy(Request $request, $perPage)
    {
        foreach($request->all() as $key => $value){
            Vendor::where('id', $request[$key]['id'])->delete();
        }
        return $this->index($perPage);
    }

    public function checkForm(Request $request, $form)
    {
        if($form == 'nama_vendor'){
            $request->validate([
                'nama_vendor'    => 'required|string|unique:vendors,nama_vendor,'.$request->id.'',
            ]);
        }elseif($form == 'kota'){
            $request->validate([
                'kota'          => 'required|string',
            ]);
        }elseif($form == 'telepon'){
            $request->validate([
                'telepon'       => 'nullable|numeric',
            ]);
        }
    }

    public function getOptions()
    {
        $data = Vendor::select('id as value', 'nama_vendor as text')->orderBy('nama_vendor', 'asc')->get();
        return response()->json($data);
    }
}
