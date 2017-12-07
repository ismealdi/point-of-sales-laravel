<?php

namespace App\Http\Controllers\Web;

use App\Booking;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Information;
use App\Project;
use App\Service;
use Illuminate\Http\Request;

use App\Section;
use App\Contact;

use Session;
use DB;
use Auth;
use File;

class WebController extends Controller
{

    /**
     * Display a page.
     *
     * @return \Illuminate\View\View
     */
    public function home()
    {
        return redirect('login');
    }

}