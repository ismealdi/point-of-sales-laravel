<?php

namespace App\Http\Middleware;

use Closure;

class RequiredParameterJson
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
		if (!$request->isJson()) {
			return response()->json([
				'status' => 500,
				'message' => 'Parameters must be json.',
				'data' => array()
			]);
		}
		
        return $next($request);
    }
}
