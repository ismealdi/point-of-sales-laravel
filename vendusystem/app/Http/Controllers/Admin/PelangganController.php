<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Pelanggan;
use App\Role;
use App\TipePelanggan;
use App\User;
use Illuminate\Http\Request;
use Session;
use DB;
use Auth;
use File;

class PelangganController extends Controller
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
     * Show the form for view a list of pelanggan.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $pelanggans = new Pelanggan();
        $no = (($request->page - 1) * $this->perpage) + 1;
        $no = ($no < 1) ? 1 : $no;
        if($request->search)
            $pelanggans = $pelanggans->where('nama', 'LIKE', '%'.$request->search."%");

        $pelanggans = $pelanggans->orderBy('nama', "ASC");

        $pelanggans = $pelanggans->paginate($this->perpage);
        $appends = $request->except("page");
        return view('admin.page.pelanggan.index', compact('pelanggans', 'appends', 'no'));
    }

    /**
     * Show the form for creating a new pelanggan.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $tipes = TipePelanggan::pluck('nama', 'id')->prepend('Pilih Tipe Pelanggan', 0);

        return view('admin.page.pelanggan.create', compact('tipes'));
    }

    /**
     * Store the specified pelanggan in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'nama' => 'required',
            'tipe' => 'required|min:1',
        ]);

        $request["toko"] = null;
        $requestData = $request->all();

        $information = Pelanggan::create($requestData);

        return redirect('admin/pelanggan');
    }

    /**
     * Show the form for editing the specified pelanggan.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $information = Pelanggan::findOrFail($id);
        $tipes = TipePelanggan::pluck('nama', 'id')->prepend('Pilih Tipe Pelanggan', 0);

        return view('admin.page.pelanggan.edit', compact("information", "tipes"));
    }


    /**
     * Show the form for detail of pelanggan.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $pelanggan = Pelanggan::findOrFail($id);

        return view('admin.page.pelanggan.show', compact("pelanggan"));
    }

    /**
     * Update the specified pelanggan in storage.
     *
     * @param  int  $id
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update($id, Request $request)
    {

        $this->validate($request, [
            'nama' => 'required',
            'tipe' => 'required|min:1',
        ]);

        $information = Pelanggan::findOrFail($id);

        $requestData = $request->all();

        $information->update($requestData);

        if($request->back == 'detail') {
            return redirect('admin/pelanggan/'.$information->id);
        }

        return redirect('admin/pelanggan');
    }

    /**
     * Retrieve destroy with id to delete the specified pelanggan.
     *
     * @param  int  $id
     *
     * @return int status
     */
    public function destroy($id)
    {
        $information = Pelanggan::destroy($id);
        $user = User::wherePelanggan($id)->delete();

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
