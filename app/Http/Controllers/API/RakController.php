<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Rak;
use DB;

class RakController extends Controller
{
    public function index()
    {
        $rak = Rak::orderBy('id', 'desc')->get();
        $data = array();
        for($i = 0; $i < count($rak); $i++) {
            $query = DB::select('SELECT rak_id, count(produk_id) as jumlah_produk, sum(stok) as total_stok FROM `persediaans` WHERE rak_id = ? GROUP BY produk_id', [$rak[$i]->id]);

            $data[$i]['id'] = $rak[$i]->id;
            $data[$i]['nomor_rak'] = $rak[$i]->nomor_rak;
            if(count($query) == 0){
                $data[$i]['jumlah_produk'] = 0;
                $data[$i]['total_stok'] = 0;
            }else{
                $data[$i]['jumlah_produk'] = count($query);
                $data[$i]['total_stok'] = 0;
                for($j = 0; $j < count($query); $j++) {
                    $data[$i]['total_stok'] += $query[$j]->total_stok;
                }
            }
        }
        return response()->json($data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nomor_rak'    => 'required|string|unique:raks,nomor_rak',
        ]);

        Rak::create([
            'nomor_rak'    => $request->nomor_rak,
        ]);

        $data['id'] = Rak::first()->id;
        $data['nomor_rak'] = $request->nomor_rak;
        $data['jumlah_produk'] = 0;
        $data['total_stok'] = 0;

        return response()->json($data);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nomor_rak'    => 'required|string|unique:raks,nomor_rak,'.$request->id.'',
        ]);

        Rak::where('id', $id)->update([
            'nomor_rak'    => $request->nomor_rak,
        ]);
        
        $data['id'] = $id;
        $data['nomor_rak'] = $request->nomor_rak;
        $data['jumlah_produk'] = 0;
        $data['total_stok'] = 0;

        return response()->json($data);
    }

    public function destroy($nomorRak)
    {
        Rak::where('nomor_rak', $nomorRak)->delete();
    }

    public function checkForm(Request $request)
    {
        $request->validate([
            'nomor_rak'    => 'required|string|unique:raks,nomor_rak,'.$request->id.'',
        ]);
    }

    public function getOptions()
    {
        $data = Rak::select('id as value', 'nomor_rak as text')->orderBy('nomor_rak', 'asc')->get();
        return response()->json($data);
    }
}
