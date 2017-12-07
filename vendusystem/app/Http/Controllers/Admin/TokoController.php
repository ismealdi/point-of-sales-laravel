<?php

namespace App\Http\Controllers\Admin;

use App\Pemilik;
use App\Toko;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Section;
use App\User;
use Illuminate\Http\Request;
use Session;
use DB;
use Auth;
use File;

class TokoController extends Controller
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
     * Show the form for view a list of toko.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $tokos = new Toko();
        $no = (($request->page - 1) * $this->perpage) + 1;
        $no = ($no < 1) ? 1 : $no;
        if($request->search)
            $tokos = $tokos->where('nama', 'LIKE', '%'.$request->search."%");

        $tokos = $tokos->orderBy('nama', "ASC");

        $tokos = $tokos->paginate($this->perpage);
        $appends = $request->except("page");
        return view('admin.page.toko.index', compact('tokos', 'appends', 'no'));
    }

    /**
     * Show the form for creating a new toko.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin.page.toko.create');
    }

    /**
     * Store the specified toko in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'nama' => 'required|max:50|unique:tokos',
            'alamat' => 'required'
        ]);

        $requestData = $request->all();

        $information = Toko::create($requestData);

        return redirect('admin/toko');
    }

    /**
     * Show the form for editing the specified toko.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $information = Toko::findOrFail($id);

        return view('admin.page.toko.edit', compact("information"));
    }

    /**
     * Update the specified toko in storage.
     *
     * @param  int  $id
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update($id, Request $request)
    {

        if($request->new_nama != $request->nama) {
            $request["nama"] = $request->new_nama;
            $validation = [
                'nama' => 'required|max:50|unique:tokos',
                'alamat' => 'required'
            ];
        }else{
            $validation = [
                'alamat' => 'required'
            ];
        }

        $this->validate($request, $validation);

        $information = Toko::findOrFail($id);

        $requestData = $request->all();

        $information->update($requestData);

        return redirect('admin/toko');
    }

    /**
     * Retrieve destroy with id to delete the specified toko.
     *
     * @param  int  $id
     *
     * @return int status
     */
    public function destroy($id)
    {
        $pemiliks = Pemilik::whereToko($id)->pluck('id');
        $pemilik = Pemilik::whereToko($id)->delete();
        $users = User::whereIn('pemilik', $pemiliks)->delete();
        $information = Toko::destroy($id);

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
