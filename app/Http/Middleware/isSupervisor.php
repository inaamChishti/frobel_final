<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class isSupervisor
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
        if(auth()->user()->roles){
            foreach(auth()->user()->roles as $role){
                if($role->name == 'Supervisor' || $role->name == 'Super Admin'){
                    return $next($request);
                }
            }
            return redirect()->route('user.home');
        }
    }
}
