<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class Dashboard
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
        //Patient Record
        if($request->is('dashboard') || $request->is('dashboard/patient-information')){
            if(Auth::user()){
                return $next($request); 
            }
            else
            {
                return response()->json("You don't have permission!", 200);
            }
        }
    }
}
