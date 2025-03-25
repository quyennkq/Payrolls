<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class ckFinderAuthentication
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
        if (Auth::guard('admin')->check()) {
            config(['ckfinder.authentication' => function () use ($request) {
                return true;
            }]);
        } else {
            config(['ckfinder.authentication' => function () use ($request) {
                return false;
            }]);
        }

        // config(['ckfinder.authentication' => function() {
        //     return true;
        // }]);

        return $next($request);
    }
}
