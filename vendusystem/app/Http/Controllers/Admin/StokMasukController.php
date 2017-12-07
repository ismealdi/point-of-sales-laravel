<?php

namespace App\Http\Controllers\Admin;


use App\Inventori;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\MasukInventori;
use App\Pemasok;
use App\Produk;
use App\Satuan;
use App\TipePemasok;
use Illuminate\Http\Request;
use Session;
use DB;
use Auth;
use File;

class StokMasukController extends Controller
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
        $this->typetransaction = "masuk";
        $this->middleware('admin');
    }

    /**
     * Show the form for view a list of stokmasuk.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $stokmasuks = new Inventori();
        $no = (($request->page - 1) * $this->perpage) + 1;
        $no = ($no < 1) ? 1 : $no;
        if($request->tanggal_mulai && $request->tanggal_selesai){
            $mulai = Date('Y-m-d H:i:s', strtotime($request->tanggal_mulai." 00:00:00"));
            $selesai = Date('Y-m-d H:i:s', strtotime($request->tanggal_selesai." 23:59:59"));
            $stokmasuks = $stokmasuks->whereBetween('tanggal',
                [$mulai, $selesai]);
        }

        $stokmasuks = $stokmasuks->whereTransaksi($this->typetransaction);
        $stokmasuks = $stokmasuks->orderBy('tanggal', "DESC");

        $stokmasuks = $stokmasuks->paginate($this->perpage);

        $appends = $request->except("page");
        return view('admin.page.stokmasuk.index', compact('stokmasuks', 'appends', 'no'));
    }

    /**
     * Show the form for creating a new stokmasuk.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $pemasok = Pemasok::pluck('nama', 'id')->prepend("Pilih Pemasok", 0);
        $produk = Produk::pluck('nama', 'id')->prepend("Pilih Produk", 0);
        $satuan = Satuan::pluck('nama', 'id')->prepend("Pilih Satuan", 0);
        $tipepemasoks = TipePemasok::pluck('nama', 'id')->prepend("Pilih Tipe Pemasok", 0);

        return view('admin.page.stokmasuk.create', compact('pemasok', 'produk', 'satuan', 'tipepemasoks'));
    }

    /**
     * Store the specified stokmasuk in storage.
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
                $req["inventori"] = $information->id;
                $req["produk"] = $detail->produk;
                $req["satuan"] = $detail->satuan;
                $req["harga"] = $detail->harga;
                $req["jumlah"] = $detail->jumlah;
                $req["total"] = $detail->jumlah * $detail->harga;

                MasukInventori::create($req);
            }
        }

        return redirect('admin/masuk');
    }

    /**
     * Retrieve destroy with id to delete the specified stokmasuk.
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
     * Show the detail for the specified stokmasuk.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $information = Inventori::findOrFail($id);
        $no = 1;

        return view('admin.page.stokmasuk.show', compact("information", 'no'));
    }


}
