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

Route::group(['prefix' => 'v1', 'middleware' => ['requiredParameterJson']], function () {
    Route::group(['prefix' => 'admin'], function () {
        Route::get('/pemasok', 'Api\AdminController@pemasok');
        Route::get('/pemasok/produk/{id}', 'Api\AdminController@pemasokProduk');
        Route::get('/tipe-pemasok', 'Api\AdminController@tipepemasok');
        Route::get('/satuan', 'Api\AdminController@satuan');
        Route::get('/produk', 'Api\AdminController@produk');
        Route::get('/produk/satuan/{id}', 'Api\AdminController@produkSatuan');
        Route::get('/produk/stok/{id}', 'Api\AdminController@produkStok');
        Route::get('/produk/pembelian/{id}/{pemasok}', 'Api\AdminController@produkPembelian');
        Route::get('/toko', 'Api\AdminController@toko');
    });

});
