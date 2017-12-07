<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use DB;
use Session;

class Kasir
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check()) {
            if(Auth::User()->role == DB::table('roles')->whereName("kasir")->value('id')
                || Auth::User()->role == DB::table('roles')->whereName("All Roles")->value('id')){
                return $next($request);
            }else{
                Auth::logout();
                return redirect('login');
            }
        }

        return redirect('login');
    }
}
