<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }

    protected function redirectTo()
    {
        if(Auth::User()->theRole->name == "admin"){
            return 'admin/beranda';
        }else if(Auth::User()->theRole->name == "toko"){
            return 'toko/beranda';
        }else if(Auth::User()->theRole->name == "staff"){
            return 'staf/beranda';
        }else if(Auth::User()->theRole->name == "kasir"){
            return 'kasir/beranda';
        }else{
            return "logout";
        }
    }

    /**
     * Override the username method used to validate login
     *
     * @return string
     */
    public function username()
    {
        return 'username';
    }
}
