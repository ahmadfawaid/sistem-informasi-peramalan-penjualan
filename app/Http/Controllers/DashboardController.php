<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Penjualan;
use App\Produk;
use Auth;

class DashboardController extends Controller
{
    public function index()
    {
        if(Auth::user()->status == true){
            return view('app');
        }else{
            return redirect('nonaktif');
        }
    }
}
