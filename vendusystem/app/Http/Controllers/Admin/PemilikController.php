<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Pemilik;
use App\Role;
use App\Toko;
use App\User;
use Illuminate\Http\Request;
use Session;
use DB;
use Auth;
use File;

class PemilikController extends Controller
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
     * Show the form for view a list of pemilik.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $pemiliks = new Pemilik();
        $no = (($request->page - 1) * $this->perpage) + 1;
        $no = ($no < 1) ? 1 : $no;
        if($request->search)
            $pemiliks = $pemiliks->where('nama', 'LIKE', '%'.$request->search."%");

        $pemiliks = $pemiliks->orderBy('nama', "ASC");

        $pemiliks = $pemiliks->paginate($this->perpage);
        $appends = $request->except("page");
        return view('admin.page.pemilik.index', compact('pemiliks', 'appends', 'no'));
    }

    /**
     * Show the form for creating a new pemilik.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $tokos = Toko::whereStatus("1")->pluck('nama', 'id')->prepend("Pilih Toko", 0);

        return view('admin.page.pemilik.create', compact('tokos'));
    }

    /**
     * Store the specified pemilik in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|max:50|unique:users',
            'username' => 'required|max:50|unique:users',
            'password' => 'required|min:6',
            'toko' => 'required|min:1',
        ]);


        $request["role"] = Role::whereName("toko")->first()->id;
        $request["name"] = $request->nama;
        $request["password"] = bcrypt($request->password);

        $requestData = $request->all();
        $user = User::create($requestData);

        if($user) {
            $request["user"] = $user->id;
            $requestData = $request->all();

            $information = Pemilik::create($requestData);
        }

        return redirect('admin/pemilik');
    }

    /**
     * Show the form for editing the specified pemilik.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $information = Pemilik::findOrFail($id);
        $tokos = Toko::whereStatus("1")->pluck('nama', 'id')->prepend("Pilih Toko", 0);

        return view('admin.page.pemilik.edit', compact("information", "tokos"));
    }


    /**
     * Show the form for detail of pemilik.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $pemilik = Pemilik::findOrFail($id);

        return view('admin.page.pemilik.show', compact("pemilik"));
    }

    /**
     * Update the specified pemilik in storage.
     *
     * @param  int  $id
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update($id, Request $request)
    {

        if($request->password != "") {
            $request["password"] = bcrypt($request->password);
            $validation = [
                'password' => 'required|min:6',
                'toko' => 'required|min:1',
            ];
        }else{
            $validation = [
                'toko' => 'required|min:1',
            ];
        }

        $this->validate($request, $validation);

        $information = Pemilik::findOrFail($id);

        $requestData = $request->all();

        $information->update($requestData);

        if($information) {
            $request["role"] = Role::whereName("toko")->first()->id;
            $request["name"] = $request->nama;
            $request["password"] = bcrypt($request->password);

            $user = User::wherePemilik($information->id)->first();

            $requestData = $request->all();
            $user->update($requestData);
        }

        if($request->back == 'detail') {
            return redirect('admin/pemilik/'.$information->id);
        }

        return redirect('admin/pemilik');
    }

    /**
     * Retrieve destroy with id to delete the specified pemilik.
     *
     * @param  int  $id
     *
     * @return int status
     */
    public function destroy($id)
    {
        $pemilik = Pemilik::findOrFail($id);
        $user = User::destroy($pemilik->user);
        $information = Pemilik::destroy($id);

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
