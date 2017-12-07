<?php

namespace App\Http\Controllers\Admin;

use App\Pemilik;
use App\Jenis;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Section;
use App\User;
use Illuminate\Http\Request;
use Session;
use DB;
use Auth;
use File;

class JenisController extends Controller
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
     * Show the form for view a list of jenis.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $jeniss = new Jenis();
        $no = (($request->page - 1) * $this->perpage) + 1;
        $no = ($no < 1) ? 1 : $no;
        if($request->search)
            $jeniss = $jeniss->where('nama', 'LIKE', '%'.$request->search."%");

        $jeniss = $jeniss->orderBy('nama', "ASC");

        $jeniss = $jeniss->paginate($this->perpage);
        $appends = $request->except("page");
        return view('admin.page.jenis.index', compact('jeniss', 'appends', 'no'));
    }

    /**
     * Show the form for creating a new jenis.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin.page.jenis.create');
    }

    /**
     * Store the specified jenis in storage.
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

        $information = Jenis::create($requestData);

        return redirect('admin/jenis');
    }

    /**
     * Show the form for editing the specified jenis.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $information = Jenis::findOrFail($id);

        return view('admin.page.jenis.edit', compact("information"));
    }

    /**
     * Update the specified jenis in storage.
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

        $information = Jenis::findOrFail($id);

        $requestData = $request->all();

        $information->update($requestData);

        return redirect('admin/jenis');
    }

    /**
     * Retrieve destroy with id to delete the specified jenis.
     *
     * @param  int  $id
     *
     * @return int status
     */
    public function destroy($id)
    {
        $information = Jenis::destroy($id);

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
