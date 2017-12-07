<?php

namespace App\Http\Controllers\Admin;

use App\Jenis;
use App\Pemilik;
use App\Grup;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Section;
use App\User;
use Illuminate\Http\Request;
use Session;
use DB;
use Auth;
use File;

class GrupController extends Controller
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
     * Show the form for view a list of grup.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $grups = new Grup();
        $no = (($request->page - 1) * $this->perpage) + 1;
        $no = ($no < 1) ? 1 : $no;
        $grups = $grups->select('grups.*')
            ->join('jenis', 'jenis.id', '=', 'grups.jenis');

        if($request->search) {
            $grups = $grups->where('grups.nama', 'LIKE', '%'.$request->search."%")
                ->orWhere('jenis.nama', 'LIKE', '%'.$request->search."%");
        }

        $grups = $grups->orderBy('grups.nama', "ASC");

        $grups = $grups->paginate($this->perpage);
        $appends = $request->except("page");
        return view('admin.page.grup.index', compact('grups', 'appends', 'no'));
    }

    /**
     * Show the form for creating a new grup.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $jenis = Jenis::pluck('nama', 'id')->prepend('Pilih Jenis', 0);
        return view('admin.page.grup.create', compact('jenis'));
    }

    /**
     * Store the specified grup in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'nama' => 'required|max:50',
            'jenis' => 'required|min:1'
        ]);

        $requestData = $request->all();

        $information = Grup::create($requestData);

        return redirect('admin/grup');
    }

    /**
     * Show the form for editing the specified grup.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $information = Grup::findOrFail($id);
        $jenis = Jenis::pluck('nama', 'id')->prepend('Pilih Jenis', 0);

        return view('admin.page.grup.edit', compact("information", "jenis"));
    }

    /**
     * Update the specified grup in storage.
     *
     * @param  int  $id
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update($id, Request $request)
    {
        $this->validate($request, [
            'nama' => 'required|max:50',
            'jenis' => 'required|min:1'
        ]);

        $information = Grup::findOrFail($id);

        $requestData = $request->all();

        $information->update($requestData);

        return redirect('admin/grup');
    }

    /**
     * Retrieve destroy with id to delete the specified grup.
     *
     * @param  int  $id
     *
     * @return int status
     */
    public function destroy($id)
    {
        $information = Grup::destroy($id);

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
