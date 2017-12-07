<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Pemasok;
use App\Role;
use App\TipePemasok;
use App\User;
use Illuminate\Http\Request;
use Session;
use DB;
use Auth;
use File;

class PemasokController extends Controller
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
     * Show the form for view a list of pemasok.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $pemasoks = new Pemasok();
        $no = (($request->page - 1) * $this->perpage) + 1;
        $no = ($no < 1) ? 1 : $no;
        if($request->search)
            $pemasoks = $pemasoks->where('nama', 'LIKE', '%'.$request->search."%");

        $pemasoks = $pemasoks->orderBy('nama', "ASC");

        $pemasoks = $pemasoks->paginate($this->perpage);
        $appends = $request->except("page");
        return view('admin.page.pemasok.index', compact('pemasoks', 'appends', 'no'));
    }

    /**
     * Show the form for creating a new pemasok.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $tipes = TipePemasok::pluck('nama', 'id')->prepend("Pilih Tipe Pemasok", 0);

        return view('admin.page.pemasok.create', compact('tipes'));
    }

    /**
     * Store the specified pemasok in storage.
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

        $information = Pemasok::create($requestData);

        return redirect('admin/pemasok');
    }

    /**
     * Show the form for editing the specified pemasok.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $information = Pemasok::findOrFail($id);
        $tipes = TipePemasok::pluck('nama', 'id')->prepend("Pilih Tipe Pemasok", 0);

        return view('admin.page.pemasok.edit', compact("information", "tipes"));
    }


    /**
     * Show the form for detail of pemasok.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $pemasok = Pemasok::findOrFail($id);

        return view('admin.page.pemasok.show', compact("pemasok"));
    }

    /**
     * Update the specified pemasok in storage.
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

        $information = Pemasok::findOrFail($id);

        $requestData = $request->all();

        $information->update($requestData);

        if($request->back == 'detail') {
            return redirect('admin/pemasok/'.$information->id);
        }

        return redirect('admin/pemasok');
    }

    /**
     * Retrieve destroy with id to delete the specified pemasok.
     *
     * @param  int  $id
     *
     * @return int status
     */
    public function destroy($id)
    {
        $information = Pemasok::destroy($id);
        $user = User::wherePemasok($id)->delete();

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
