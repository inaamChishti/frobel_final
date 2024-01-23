<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Auth;
class isSuperAdmin
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
        // if (auth()->user()->roles){
        //     foreach(auth()->user()->roles as $role){
        //         if ($role->name == 'Super Admin'){
        //             return $next($request);
        //         }
        //     }
        //     return redirect()->route('user.home');
        // }
        // if (Auth::check() && Auth::user()->usertype == 'Master-User')
        if (Auth::check())
            {
                return $next($request);
            }
            return redirect()->route('user.home');
    }
}
