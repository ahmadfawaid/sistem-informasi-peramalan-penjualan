<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// peramalan
Route::post('peramalan','Api\PeramalanController@peramalan');

// penjualan
Route::group(['prefix' => 'penjualan'], function () {
	Route::get('index/{perPage}',['uses' => 'API\PenjualanController@index']);
	Route::post('store/{perPage}',['uses' => 'API\PenjualanController@store']);
	Route::get('detail/{nomorFaktur}',['uses' => 'API\PenjualanController@detail']);
	Route::get('getNomorFaktur',['uses' => 'Api\PenjualanController@getNomorfaktur']);
	Route::get('getPenjualan',['uses' => 'Api\PenjualanController@getPenjualan']);
});

// pembelian
Route::group(['prefix' => 'pembelian'], function () {
	Route::get('index/{perPage}',['uses' => 'API\PembelianController@index']);
	Route::post('store/{rakID}/{perPage}',['uses' => 'API\PembelianController@store']);
	Route::post('skip/{perPage}',['uses' => 'API\PembelianController@skip']);
	Route::get('detail/{nomorFaktur}',['uses' => 'API\PembelianController@detail']);
	Route::get('edit/{nomorFaktur}',['uses' => 'API\PembelianController@edit']);
	Route::patch('update/{perPage}',['uses' => 'API\PembelianController@update']);
	Route::post('destroy/{perPage}',['uses' => 'API\PembelianController@destroy']);
	Route::post('checkForm/{form}',['uses' => 'Api\PembelianController@checkForm']);
});

// persediaan
Route::get('persediaan/index/{nomorRak}/{perPage}','API\PersediaanController@index');
Route::get('persediaan/getPerRak/{nomorRak}','API\PersediaanController@getPerRak');
Route::post('persediaan/store/{nomorRak}/{perPage}','API\PersediaanController@store');
Route::patch('persediaan/update/{nomorRak}/{perPage}','API\PersediaanController@update');
Route::post('persediaan/move/{rakID}/{nomorRak}/{perPage}', 'API\PersediaanController@move');
Route::post('persediaan/destroy/{nomorRak}/{perPage}', 'API\PersediaanController@destroy');
Route::post('persediaan/checkForm/{form}', 'Api\PersediaanController@checkForm');
Route::get('persediaan/getList', 'API\PersediaanController@getList');
Route::get('persediaan/getTotalPersediaan', 'API\PersediaanController@getTotalPersediaan');

// rak
Route::get('rak/index','API\RakController@index');
Route::post('rak/store','API\RakController@store');
Route::patch('rak/update/{id}','API\RakController@update');
Route::get('rak/destroy/{nomorRak}', 'API\RakController@destroy');
Route::post('rak/checkForm', 'Api\RakController@checkForm');
Route::get('rak/getOptions', 'API\RakController@getOptions');

// produk
Route::get('produk/index/{perPage}','API\ProdukController@index');
Route::post('produk/store/{perPage}','API\ProdukController@store');
Route::patch('produk/update/{id}','API\ProdukController@update');
Route::post('produk/destroy/{perPage}', 'API\ProdukController@destroy');
Route::post('produk/checkForm/{form}', 'Api\ProdukController@checkForm');
Route::get('produk/getOptions', 'API\ProdukController@getOptions');

// jenis produk
Route::get('jenis/index/{perPage}','API\JenisProdukController@index');
Route::post('jenis/store/{perPage}','API\JenisProdukController@store');
Route::patch('jenis/update/{id}','API\JenisProdukController@update');
Route::post('jenis/destroy/{perPage}', 'API\JenisProdukController@destroy');
Route::post('jenis/checkForm', 'Api\JenisProdukController@checkForm');
Route::get('jenis/getOptions', 'API\JenisProdukController@getOptions');

// satuan pembelian
Route::get('satuan/pembelian/index/{perPage}','API\SatuanPembelianController@index');
Route::post('satuan/pembelian/store/{perPage}','API\SatuanPembelianController@store');
Route::patch('satuan/pembelian/update/{id}','API\SatuanPembelianController@update');
Route::post('satuan/pembelian/destroy/{perPage}', 'API\SatuanPembelianController@destroy');
Route::post('satuan/pembelian/checkForm', 'Api\SatuanPembelianController@checkForm');
Route::get('satuan/pembelian/getOptions', 'API\SatuanPembelianController@getOptions');

// satuan penjualan
Route::get('satuan/penjualan/index/{perPage}','API\SatuanPenjualanController@index');
Route::post('satuan/penjualan/store/{perPage}','API\SatuanPenjualanController@store');
Route::patch('satuan/penjualan/update/{id}','API\SatuanPenjualanController@update');
Route::post('satuan/penjualan/destroy/{perPage}', 'API\SatuanPenjualanController@destroy');
Route::post('satuan/penjualan/checkForm', 'Api\SatuanPenjualanController@checkForm');
Route::get('satuan/penjualan/getOptions', 'API\SatuanPenjualanController@getOptions');

// vendor
Route::get('vendor/index/{perPage}','API\VendorController@index');
Route::post('vendor/store/{perPage}','API\VendorController@store');
Route::patch('vendor/update/{id}','API\VendorController@update');
Route::post('vendor/destroy/{perPage}', 'API\VendorController@destroy');
Route::post('vendor/checkForm/{form}', 'Api\VendorController@checkForm');
Route::get('vendor/getOptions', 'API\VendorController@getOptions');

// user
Route::get('user/index/{perPage}','API\UserController@index');
Route::post('user/store/{perPage}','API\UserController@store');
Route::patch('user/update/{id}','API\UserController@update');
Route::post('user/checkForm/{form}', 'Api\UserController@checkForm');
Route::post('user/setStatus/{id}', 'API\UserController@setStatus');
