<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Auth;

class Attendance
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
        //         if($role->name == 'Attendance' || $role->name == 'Super Admin' || $role->name == 'Admin' || $role->name == 'Supervisor'){
        //             return $next($request);
        //         }
        //     }
        //     return redirect()->route('user.home');
        // }
        if (Auth::check())
            {
                // if( Auth::user()->usertype == 'Supervisors' || Auth::user()->usertype == 'Admin' || Auth::user()->usertype == 'Master-User' || Auth::user()->usertype == 'Master-Admin')
                // {
                    return $next($request);
                // }
            }
            return redirect()->route('user.home');
    }
}
