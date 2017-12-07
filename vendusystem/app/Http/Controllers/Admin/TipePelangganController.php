<?php

namespace App\Http\Controllers\Admin;

use App\Pemilik;
use App\TipePelanggan;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Section;
use App\User;
use Illuminate\Http\Request;
use Session;
use DB;
use Auth;
use File;

class TipePelangganController extends Controller
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
     * Show the form for view a list of tipepelanggan.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $tipepelanggans = new TipePelanggan();
        $no = (($request->page - 1) * $this->perpage) + 1;
        $no = ($no < 1) ? 1 : $no;
        if($request->search)
            $tipepelanggans = $tipepelanggans->where('nama', 'LIKE', '%'.$request->search."%");

        $tipepelanggans = $tipepelanggans->orderBy('nama', "ASC");

        $tipepelanggans = $tipepelanggans->paginate($this->perpage);
        $appends = $request->except("page");
        return view('admin.page.tipe-pelanggan.index', compact('tipepelanggans', 'appends', 'no'));
    }

    /**
     * Show the form for creating a new tipepelanggan.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin.page.tipe-pelanggan.create');
    }

    /**
     * Store the specified tipepelanggan in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'nama' => 'required|max:50'
        ]);

        $request["toko"] = null;

        $requestData = $request->all();

        $information = TipePelanggan::create($requestData);

        return redirect('admin/tipe-pelanggan');
    }

    /**
     * Show the form for editing the specified tipepelanggan.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $information = TipePelanggan::findOrFail($id);

        return view('admin.page.tipe-pelanggan.edit', compact("information"));
    }

    /**
     * Update the specified tipepelanggan in storage.
     *
     * @param  int  $id
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update($id, Request $request)
    {
        $this->validate($request, [
            'nama' => 'required|max:50'
        ]);

        $request["toko"] = null;

        $information = TipePelanggan::findOrFail($id);

        $requestData = $request->all();

        $information->update($requestData);

        return redirect('admin/tipe-pelanggan');
    }

    /**
     * Retrieve destroy with id to delete the specified tipepelanggan.
     *
     * @param  int  $id
     *
     * @return int status
     */
    public function destroy($id)
    {
        $information = TipePelanggan::destroy($id);

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
