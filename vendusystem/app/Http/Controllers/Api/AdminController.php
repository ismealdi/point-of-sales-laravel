<?php

namespace App\Http\Controllers\Api;

use App\Inventori;
use App\KeluarInventori;
use App\MasukInventori;
use App\ReturInventori;
use App\Toko;
use App\Pemasok;
use App\Produk;
use App\Satuan;
use App\TipePemasok;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class AdminController extends Controller
{
    /**
     * @return type
     */
    public function pemasok()
    {
        $information = Pemasok::orderBy('created_at', 'ASC')->get();

        $data['message'] = "Berhasil mendapatkan data pemasok!";
        $data['status'] = 200;
        $data['data'] = $information;
        $data['last'] = $information->last();

        return response()->json($data, 200);
    }

    /**
     * @return type
     */
    public function pemasokProduk($id)
    {
        $information = Produk::leftJoin('masuk_inventoris', 'masuk_inventoris.produk', '=', 'produks.id')
            ->leftJoin('inventoris', 'inventoris.id', '=', 'masuk_inventoris.inventori')
            ->select([DB::raw('SUM(masuk_inventoris.jumlah) as jumlah'), 'produks.nama', 'produks.id'])
            ->where('inventoris.transaksi', 'masuk')
            ->where('inventoris.pemasok', $id)
            ->groupBy('produks.id')
            ->get();

        $data['message'] = "Berhasil mendapatkan data produk!";
        $data['status'] = 200;
        $data['data'] = $information;
        $data['last'] = $information->count();

        return response()->json($data, 200);
    }

    /**
     * @return type
     */
    public function tipepemasok()
    {
        $information = TipePemasok::orderBy('created_at', 'ASC')->get();

        $data['message'] = "Berhasil mendapatkan data tipe pemasok!";
        $data['status'] = 200;
        $data['data'] = $information;
        $data['last'] = $information->last();

        return response()->json($data, 200);
    }

    /**
     * @return type
     */
    public function satuan()
    {
        $information = Satuan::orderBy('created_at', 'ASC')->get();

        $data['message'] = "Berhasil mendapatkan data satuan!";
        $data['status'] = 200;
        $data['data'] = $information;
        $data['last'] = $information->last();

        return response()->json($data, 200);
    }

    /**
     * @return type
     */
    public function produk()
    {
        $information = Produk::orderBy('created_at', 'ASC')->get();

        $data['message'] = "Berhasil mendapatkan data produk!";
        $data['status'] = 200;
        $data['data'] = $information;
        $data['last'] = $information->last();

        return response()->json($data, 200);
    }

    /**
     * @return type
     */
    public function produkSatuan($id)
    {
        $information = MasukInventori::whereProduk($id)->orderBy('created_at', 'DESC')->first();

        $data['message'] = "Berhasil mendapatkan data produk terakhir!";
        $data['status'] = 200;
        $data['data'] = $information;
        $data['last'] = $information->satuan;

        return response()->json($data, 200);
    }

    /**
     * @return type
     */
    public function produkStok($id)
    {
        $masuk = MasukInventori::join('satuans', 'satuans.id', '=', 'masuk_inventoris.satuan')
                        ->where('masuk_inventoris.produk', $id)
                        ->select([DB::raw('SUM(masuk_inventoris.jumlah) as jumlah'),
                            DB::raw('satuans.nama as satuan'),])
                        ->first();

        $keluar = KeluarInventori::join('satuans', 'satuans.id', '=', 'keluar_inventoris.satuan')
                        ->where('keluar_inventoris.produk', $id)
                        ->select([DB::raw('SUM(keluar_inventoris.jumlah) as jumlah'),
                            DB::raw('satuans.nama as satuan'),])
                        ->first();

        $retur = ReturInventori::join('satuans', 'satuans.id', '=', 'retur_inventoris.satuan')
                        ->where('retur_inventoris.produk', $id)
                        ->select([DB::raw('SUM(retur_inventoris.jumlah) as jumlah'),
                            DB::raw('satuans.nama as satuan'),])
                        ->first();

        $information = array("jumlah" => $masuk->jumlah - $keluar->jumlah - $retur->jumlah, "satuan" => $masuk->satuan);

        $data['message'] = "Berhasil mendapatkan data produk terakhir!";
        $data['status'] = 200;
        $data['data'] = $information;
        $data['last'] = $information;

        return response()->json($data, 200);
    }

    /**
     * @return type
     */
    public function produkPembelian($id,$pemasok)
    {
        $masuk = Inventori::join('masuk_inventoris', 'masuk_inventoris.inventori', '=', 'inventoris.id')
                        ->join('satuans', 'satuans.id', '=', 'masuk_inventoris.satuan')
                        ->where('inventoris.pemasok', $pemasok)
                        ->where('inventoris.transaksi', 'masuk')
                        ->where('masuk_inventoris.produk', $id)
                        ->select([DB::raw('masuk_inventoris.jumlah as jumlah'),
                            DB::raw('satuans.nama as satuan'),])
                        ->orderBy('inventoris.created_at', 'desc')
                        ->first();

        $information = array("jumlah" => $masuk->jumlah, "satuan" => $masuk->satuan);

        $data['message'] = "Berhasil mendapatkan data pembelian produk terakhir!";
        $data['status'] = 200;
        $data['data'] = $information;
        $data['last'] = $information;

        return response()->json($data, 200);
    }

    /**
     * @return type
     */
    public function toko()
    {
        $information = Toko::orderBy('created_at', 'ASC')->get();

        $data['message'] = "Berhasil mendapatkan data toko!";
        $data['status'] = 200;
        $data['data'] = $information;
        $data['last'] = $information->last();

        return response()->json($data, 200);
    }

}
