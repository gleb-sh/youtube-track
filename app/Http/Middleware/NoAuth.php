<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class NoAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if ( session()->has('user') ) {
            if ( $request->is('api/*') ) {
                return response()->json(array(
                    'status'=>0,
                ));
            } else {
                return redirect('/welcome');
            }
        } else {
            return $next($request);
        }
    }
}
