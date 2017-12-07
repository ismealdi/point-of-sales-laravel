<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Section;
use App\User;
use Illuminate\Http\Request;
use Session;
use DB;
use Auth;
use File;

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('admin');
    }

    /**
     * Display a beranda page.
     *
     * @return \Illuminate\View\View
     */
    public function beranda()
    {
        return view('admin.page.beranda.index');
    }

    /**
     * Show the form for editing the specified user.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function setting()
    {
        $information = User::findOrFail(Auth::User()->id);

        return view('admin.page.user.edit', compact("information"));
    }

    /**
     * Update the specified user in storage.
     *
     * @param  int  $id
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function settingUpdate(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
        ]);

        $request["password"] = ($request->password == "") ? $request->password_old : bcrypt($request->password);

        $requestData = $request->all();

        $information = User::findOrFail(Auth::User()->id);
        $information->update($requestData);

        return redirect('admin/setting');
    }

    /**
     * Show the form for creating a new slider.
     *
     * @return \Illuminate\View\View
     */
    public function sliderCreate()
    {
        $order = Section::whereSectionUnique("sliders")->count() + 1;
        return view('admin.page.beranda.slider.create', compact('order'));
    }

    /**
     * Store the specified slider in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function sliderStore(Request $request)
    {

        $request["section_unique"] = "sliders";
        $order = Section::whereSectionUnique("sliders")->count() + 1;
        if($request->section_order < $order) {
            $update = Section::whereSectionUnique('sliders')->whereSectionOrder($request->section_order)->first();
            $update->update(["section_order" => $order]);
        }

        $requestData = $request->all();

        $information = Section::create($requestData);

        return redirect('admin/beranda');
    }

    /**
     * Show the form for editing the specified slider.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function sliderEdit($id)
    {
        $information = Section::findOrFail($id);

        return view('admin.page.beranda.slider.edit', compact("information"));
    }

    /**
     * Update the specified slider in storage.
     *
     * @param  int  $id
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function sliderUpdate($id, Request $request)
    {
        $requestData = $request->all();

        $order = Section::whereSectionUnique("sliders")->count() + 1;
        if($request->section_order < $order) {
            $update = Section::whereSectionUnique('sliders')->whereSectionOrder($request->section_order)->first();
            $update->update(["section_order" => $order]);
        }

        $information = Section::findOrFail($id);
        $information->update($requestData);

        return redirect('admin/beranda');
    }

    /**
     * Remove the specified resource from slider.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function sliderDelete($id)
    {
        $information = Section::findOrFail($id);
        if($information->section_image){
            $destinationPath = 'files/sections/'.$information->section_unique;
            $old = $destinationPath."/".$information->section_image;

            if(File::exists($old))
                File::delete($old);
        }

        Section::destroy($id);

        return "success";
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function aboutEdit($id)
    {
        $information = Section::findOrFail($id);
        $title = "Title";
        $subtitle = "Sub Title";
        $description = true;

        if($information->section_unique == "client" || $information->section_unique == "team")
            return view('admin.page.beranda.caption.edit', compact('information', 'title', 'subtitle', 'description'));
        else if($information->section_unique == "beranda")
            return view('admin.page.beranda.meta.edit', compact('information', 'title', 'subtitle', 'description'));
        else
            return view('admin.page.beranda.about.edit', compact('information', 'title', 'subtitle', 'description'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function aboutUpdate($id, Request $request)
    {
        $information = Section::findOrFail($id);

        if($request->file('section_images')){
            $file = $request -> file('section_images');

            $destinationPath = 'files/sections/about';

            $ext = File::extension($file->getClientOriginalName());
            $filename = strtolower('about-'.str_random(3)).".".$ext;
            $file->move($destinationPath, $filename);
            $old = $destinationPath."/".$request->old_section_image;

            if(File::exists($old))
                File::delete($old);

            $request["section_image"] = $filename;
        }

        $requestData = $request->all();
        $information->update($requestData);

        return redirect('admin/beranda');
    }

    /**
     * Show the form for creating a new team.
     *
     * @return \Illuminate\View\View
     */
    public function teamCreate()
    {
        $order = Section::whereSectionUnique("teams")->count() + 1;
        return view('admin.page.beranda.team.create', compact('order'));
    }

    /**
     * Store the specified team in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function teamStore(Request $request)
    {

        $request["section_unique"] = "teams";

        $order = Section::whereSectionUnique("teams")->count() + 1;
        if($request->section_order < $order) {
            $updates = Section::whereSectionUnique('teams')->get();
            foreach ($updates as $update) {
                $updated = Section::findOrFail($update->id);
                $count = ($updated->section_order >= $request->section_order) ? $updated->section_order + 1 : $updated->section_order;
                $updated->update(["section_order" => $count]);
            }
        }

        if($request->file('section_images')){
            $file = $request -> file('section_images');

            $destinationPath = 'files/sections/teams';

            $ext = File::extension($file->getClientOriginalName());
            $filename = strtolower('teams-'.str_random(3)).".".$ext;
            $file->move($destinationPath, $filename);

            $request["section_image"] = $filename;
        }

        $requestData = $request->all();

        $information = Section::create($requestData);

        return redirect('admin/beranda');
    }

    /**
     * Show the form for editing the specified team.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function teamEdit($id)
    {
        $information = Section::findOrFail($id);

        return view('admin.page.beranda.team.edit', compact("information"));
    }

    /**
     * Update the specified team in storage.
     *
     * @param  int  $id
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function teamUpdate($id, Request $request)
    {
        $information = Section::findOrFail($id);


        if($request->section_order <> $information->section_order) {
            $updates = Section::whereSectionUnique('teams')->get();
            foreach ($updates as $update) {
                $updated = Section::findOrFail($update->id);

                $count = ($updated->section_order >= $request->section_order) ? $updated->section_order + 1 : $updated->section_order;
                $updated->update(["section_order" => $count]);
            }
        }

        if($request->file('section_images')){
            $file = $request -> file('section_images');

            $destinationPath = 'files/sections/teams';

            $ext = File::extension($file->getClientOriginalName());
            $filename = strtolower('teams-'.str_random(3)).".".$ext;
            $file->move($destinationPath, $filename);
            $old = $destinationPath."/".$request->old_section_image;

            if(File::exists($old))
                File::delete($old);

            $request["section_image"] = $filename;
        }

        $requestData = $request->all();
        $information->update($requestData);

        return redirect('admin/beranda');
    }


}
