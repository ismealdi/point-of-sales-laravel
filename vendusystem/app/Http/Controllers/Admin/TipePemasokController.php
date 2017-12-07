<?php

namespace App\Http\Controllers\Admin;

use App\Pemilik;
use App\TipePemasok;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Section;
use App\User;
use Illuminate\Http\Request;
use Session;
use DB;
use Auth;
use File;

class TipePemasokController extends Controller
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
     * Show the form for view a list of tipepemasok.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $tipepemasoks = new TipePemasok();
        $no = (($request->page - 1) * $this->perpage) + 1;
        $no = ($no < 1) ? 1 : $no;
        if($request->search)
            $tipepemasoks = $tipepemasoks->where('nama', 'LIKE', '%'.$request->search."%");

        $tipepemasoks = $tipepemasoks->orderBy('nama', "ASC");

        $tipepemasoks = $tipepemasoks->paginate($this->perpage);
        $appends = $request->except("page");
        return view('admin.page.tipe-pemasok.index', compact('tipepemasoks', 'appends', 'no'));
    }

    /**
     * Show the form for creating a new tipepemasok.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin.page.tipe-pemasok.create');
    }

    /**
     * Store the specified tipepemasok in storage.
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

        $information = TipePemasok::create($requestData);

        return redirect('admin/tipe-pemasok');
    }

    /**
     * Show the form for editing the specified tipepemasok.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $information = TipePemasok::findOrFail($id);

        return view('admin.page.tipe-pemasok.edit', compact("information"));
    }

    /**
     * Update the specified tipepemasok in storage.
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

        $information = TipePemasok::findOrFail($id);

        $requestData = $request->all();

        $information->update($requestData);

        return redirect('admin/tipe-pemasok');
    }

    /**
     * Retrieve destroy with id to delete the specified tipepemasok.
     *
     * @param  int  $id
     *
     * @return int status
     */
    public function destroy($id)
    {
        $information = TipePemasok::destroy($id);

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
