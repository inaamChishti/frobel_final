<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Auth;
class StudentFee
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
        // if(auth()->user()->roles){
        //     foreach(auth()->user()->roles as $role){
        //         if($role->name == 'Student Fee' || $role->name == 'Super Admin'){
        //             return $next($request);
        //         }
        //     }
        //     return redirect()->route('user.home');
        // }
        // if (Auth::check())
        // {
        //     if(Auth::user()->usertype == 'Student Fee' || Auth::user()->usertype == 'Super Admin')
        //     {
            return $next($request);

        //     }
        // }
        // return redirect()->route('user.home');
    }
}
