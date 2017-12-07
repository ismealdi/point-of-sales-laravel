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


Route::get('/', 'Web\WebController@home')->name('web.home');

Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::get('logout', 'Auth\LoginController@logout')->name('logout');

Route::group(['prefix' => 'admin'], function () {
    Route::get('setting', 'Admin\\AdminController@setting')->name('admin.setting.edit');
    Route::patch('setting', 'Admin\\AdminController@settingUpdate')->name('admin.setting.update');
    Route::get('beranda', 'Admin\\AdminController@beranda')->name('admin.beranda');
    Route::resource('toko', 'Admin\\TokoController');
    Route::resource('pemilik', 'Admin\\PemilikController');
    Route::resource('satuan', 'Admin\\SatuanController');
    Route::resource('tipe-pelanggan', 'Admin\\TipePelangganController');
    Route::resource('pelanggan', 'Admin\\PelangganController');
    Route::resource('tipe-pemasok', 'Admin\\TipePemasokController');
    Route::resource('pemasok', 'Admin\\PemasokController');
    Route::resource('jenis', 'Admin\\JenisController');
    Route::resource('grup', 'Admin\\GrupController');
    Route::resource('produk', 'Admin\\ProdukController');
    // Route::resource('paket-produk', 'Admin\\PaketProdukController');
    Route::resource('barcode', 'Admin\\BarcodeController');
    Route::resource('masuk', 'Admin\\StokMasukController');
    Route::resource('keluar', 'Admin\\StokKeluarController');
    Route::resource('retur', 'Admin\\StokReturController');
});



Route::group(['prefix' => 'marketing'], function () {
    Route::resource('blog', 'Marketing\\BlogController');
    Route::resource('blog/type', 'Marketing\\TypeBlogController');
});
