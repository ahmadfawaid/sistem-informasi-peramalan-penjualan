<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

Route::get('/', function(){
    return redirect('dashboard');
});

Route::get('register', function() {
    return redirect('login');
})->name('register');

Route::group(['middleware' => 'auth'], function() {
    Route::get('dashboard', 'DashboardController@index');

    Route::group(['middleware' => 'akses:manager'], function() {
        Route::get('user', 'DashboardController@index');
        Route::get('data-pembelian', 'DashboardController@index');
        Route::get('data-pembelian/detail/{nomorFaktur}', 'DashboardController@index');
        Route::get('data-penjualan', 'DashboardController@index');
        Route::get('data-pembelian/detail/{nomorFaktur}', 'DashboardController@index');
        Route::get('data-persediaan', 'DashboardController@index');
        Route::get('data-persediaan/detail/{nomorRak}', 'DashboardController@index');
    });

    Route::group(['middleware' => 'akses:apoteker'], function() {
        Route::get('peramalan', 'DashboardController@index');
        Route::get('tes', 'API\PeramalanController@tes');
        Route::get('pembelian', 'DashboardController@index');
        Route::get('pembelian/transaksi', 'DashboardController@index');
        Route::get('pembelian/detail/{nomorFaktur}', 'DashboardController@index');
        Route::get('pembelian/edit/{nomorFaktur}', 'DashboardController@index');
        Route::get('penjualan', 'DashboardController@index');
        Route::get('penjualan/transaksi', 'DashboardController@index');
        Route::get('penjualan/detail/{nomorFaktur}', 'DashboardController@index');
        Route::get('penjualan/edit/{nomorFaktur}', 'DashboardController@index');
        Route::get('persediaan', 'DashboardController@index');
        Route::get('persediaan/detail/{nomorRak}', 'DashboardController@index');
        Route::get('produk', 'DashboardController@index');
        Route::get('jenis', 'DashboardController@index');
        Route::get('satuan/pembelian', 'DashboardController@index');
        Route::get('satuan/penjualan', 'DashboardController@index');
        Route::get('vendor', 'DashboardController@index');
    });

    Route::get('redirect', function() {
        return 'access denied!!! | <a href="dashboard">kembali ke dashboard</a>';
    });

    Route::get('nonaktif', function() {
        return view('layouts.nonaktif');
    });
});
