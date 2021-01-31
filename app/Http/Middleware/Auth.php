<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Auth
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
        if (session()->get('user')) {
            return $next($request);
        } else {
            if ( $request->is('api/*') ) {
                return response()->json(array(
                    'status'=>0,
                ));
            }
        }
    }
}
