<?php

namespace App\Http\Controllers\Admin;

use App\Produk;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Section;
use Illuminate\Http\Request;
use Session;
use DB;
use Auth;
use File;

class ProdukController extends Controller
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
     * Show the form for view a list of produk.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $produks = new Produk();
        $no = (($request->page - 1) * $this->perpage) + 1;
        $no = ($no < 1) ? 1 : $no;
        $produks = $produks->select('produks.*');

        if($request->search) {
            $produks = $produks->where('produks.nama', 'LIKE', '%'.$request->search."%")
                ->orWhere('produks.kode', 'LIKE', '%'.$request->search);
        }

        $produks = $produks->orderBy('produks.kode', "ASC");

        $produks = $produks->paginate($this->perpage);
        $appends = $request->except("page");
        return view('admin.page.produk.index', compact('produks', 'appends', 'no'));
    }

    /**
     * Show the form for creating a new produk.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $kode = sprintf("%010s", (Produk::withTrashed()->count() + 1));
        return view('admin.page.produk.create', compact('kode'));
    }

    /**
     * Store the specified produk in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'nama' => 'required|min:3|unique:produks'
        ]);

        $request["nama"] = strtoupper($request->nama);
        $request["kode"] = ($request->kode) ? $request->kode : sprintf("%010s", (Produk::withTrashed()->count() + 1));
        $requestData = $request->all();

        $information = Produk::create($requestData);

        return redirect('admin/produk/create');
    }

    /**
     * Show the form for editing the specified produk.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $information = Produk::findOrFail($id);

        return view('admin.page.produk.edit', compact("information"));
    }

    /**
     * Update the specified produk in storage.
     *
     * @param  int  $id
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update($id, Request $request)
    {
        $this->validate($request, [
            'nama' => 'required|min:3'
        ]);

        $request["nama"] = strtoupper($request->nama);

        $information = Produk::findOrFail($id);

        $requestData = $request->all();

        $information->update($requestData);

        return redirect('admin/produk');
    }

    /**
     * Retrieve destroy with id to delete the specified produk.
     *
     * @param  int  $id
     *
     * @return int status
     */
    public function destroy($id)
    {
        $information = Produk::destroy($id);

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
