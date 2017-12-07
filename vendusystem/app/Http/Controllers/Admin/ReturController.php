<?php

namespace App\Http\Controllers\Admin;

use App\KeluarInventori;
use App\Inventori;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\MasukInventori;
use App\Toko;
use App\Produk;
use App\Satuan;
use App\TipeToko;
use Illuminate\Http\Request;
use Session;
use DB;
use Auth;
use File;

class ReturController extends Controller
{
    private $perpage, $typetransaction;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->perpage = 25;
        $this->typetransaction = "retur";
        $this->middleware('admin');
    }

    /**
     * Show the form for view a list of stokretur.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $stokreturs = new Inventori();
        $no = (($request->page - 1) * $this->perpage) + 1;
        $no = ($no < 1) ? 1 : $no;
        if($request->tanggal_mulai && $request->tanggal_selesai){
            $mulai = Date('Y-m-d H:i:s', strtotime($request->tanggal_mulai." 00:00:00"));
            $selesai = Date('Y-m-d H:i:s', strtotime($request->tanggal_selesai." 23:59:59"));
            $stokreturs = $stokreturs->whereBetween('tanggal',
                [$mulai, $selesai]);
        }

        $stokreturs = $stokreturs->whereTransaksi($this->typetransaction);
        $stokreturs = $stokreturs->orderBy('tanggal', "DESC");

        $stokreturs = $stokreturs->paginate($this->perpage);

        $appends = $request->except("page");
        return view('admin.page.stokretur.index', compact('stokreturs', 'appends', 'no'));
    }

    /**
     * Show the form for creating a new stokretur.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $toko = Toko::pluck('nama', 'id')->prepend("Pilih Toko", 0);
        $produk = Produk::
            leftJoin('masuk_inventoris', 'masuk_inventoris.produk', '=', 'produks.id')
            ->leftJoin('inventoris', 'inventoris.id', '=', 'masuk_inventoris.inventori')
            ->select([DB::raw('SUM(masuk_inventoris.jumlah) as jumlah'), 'produks.nama', 'produks.id'])
            ->where('inventoris.transaksi', 'masuk')
            ->groupBy('produks.id')
            ->get()
            ->pluck('nama', 'id')->prepend("Pilih Produk", 0);


        return view('admin.page.stokretur.create', compact('toko', 'produk'));
    }

    /**
     * Store the specified stokretur in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {

        $this->validate($request, [
            'tanggal' => 'required'
        ]);

        $request["toko"] = ($request->toko) ? $request->toko : null;
        $request["user"] = ($request->user) ? $request->user : Auth::User()->id;
        $request["pemasok"] = ($request->pemasok) ? $request->pemasok : null;
        $request["transaksi"] = $this->typetransaction;

        $requestData = $request->except(['details']);

        $information = Inventori::create($requestData);
        if($information) {
            $details = json_decode($request->details);
            foreach($details->data as $detail) {
                $produk = MasukInventori::whereProduk($detail->produk)->orderBy('created_at', 'desc')->first();

                $req["satuan"] = $produk->satuan;
                $req["inventori"] = $information->id;
                $req["produk"] = $detail->produk;
                $req["harga"] = $produk->harga;
                $req["jumlah"] = $detail->jumlah;
                $req["total"] = $detail->jumlah * $produk->harga;

                KeluarInventori::create($req);
            }
        }

        return redirect('admin/retur');
    }

    /**
     * Retrieve destroy with id to delete the specified stokretur.
     *
     * @param  int  $id
     *
     * @return int status
     */
    public function destroy($id)
    {
        $information = Inventori::destroy($id);

        if($information) {
            $data['message'] = "Berhasil di hapus!";
            $data['status'] = 200;
            $data['data'] = null;
        }else{
            $data['message'] = "Gagal di hapus!";
            $data['status'] = 404;
            $data['data'] = null;
        }


        return response()->json($data, $data["status"]);
    }

    /**
     * Show the detail for the specified stokretur.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $information = Inventori::findOrFail($id);
        $no = 1;

        return view('admin.page.stokretur.show', compact("information", 'no'));
    }


}
