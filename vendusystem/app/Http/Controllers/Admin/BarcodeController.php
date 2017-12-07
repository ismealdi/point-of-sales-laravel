<?php

namespace App\Http\Controllers\Admin;

use App\Pemilik;
use App\Barcode;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Produk;
use App\Section;
use App\User;
use Illuminate\Http\Request;
use Session;
use DB;
use Auth;
use File;

class BarcodeController extends Controller
{
    private $perpage;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->perpage = 25;
        $this->middleware('admin');
    }

    /**
     * Show the form for view a list of barcode.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $barcodes = new Barcode();
        $no = (($request->page - 1) * $this->perpage) + 1;
        $no = ($no < 1) ? 1 : $no;
        if($request->search)
            $barcodes = $barcodes->where('barcode', 'LIKE', '%'.$request->search."%");

        $barcodes = $barcodes->orderBy('barcode', "ASC");

        $barcodes = $barcodes->paginate($this->perpage);
        $appends = $request->except("page");
        return view('admin.page.barcode.index', compact('barcodes', 'appends', 'no'));
    }

    /**
     * Show the form for creating a new barcode.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $produk = Produk::select([DB::raw('CONCAT(kode," - ", nama) as name'), 'id'])->pluck('name', 'id')->prepend('Pilih Produk', 0);
        return view('admin.page.barcode.create', compact('produk'));
    }

    /**
     * Store the specified barcode in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'barcode' => 'required|min:3'
        ]);

        $request["toko"] = null;

        $requestData = $request->all();


        $information = Barcode::create($requestData);

        return redirect('admin/barcode');
    }

    /**
     * Show the form for editing the specified barcode.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $information = Barcode::findOrFail($id);
        $produk = Produk::select([DB::raw('CONCAT(kode," - ", nama) as name'), 'id'])->pluck('name', 'id')->prepend('Pilih Produk', 0);

        return view('admin.page.barcode.edit', compact("information", "produk"));
    }

    /**
     * Update the specified barcode in storage.
     *
     * @param  int  $id
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update($id, Request $request)
    {
        $this->validate($request, [
            'barcode' => 'required|min:3'
        ]);

        $request["toko"] = null;

        $information = Barcode::findOrFail($id);

        $requestData = $request->all();

        $information->update($requestData);

        return redirect('admin/barcode');
    }

    /**
     * Retrieve destroy with id to delete the specified barcode.
     *
     * @param  int  $id
     *
     * @return int status
     */
    public function destroy($id)
    {
        $information = Barcode::destroy($id);

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


}
