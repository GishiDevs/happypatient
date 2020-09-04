<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class UserRecordMaintenance
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
        //User Record
        if($request->is('user/index') || $request->is('user/users')){
            if(Auth::user()){
                return $next($request); 
            }
            else
            {
                return response()->json("You don't have permission!", 200);
            }
        }
        
        //User Create
        if($request->is('user/create') || $request->is('user/store')){
            if(Auth::user()){
                return $next($request);
            }
            else
            {
                return response()->json("You don't have permission!", 200);
            }
        }

        //User Edit
        if($request->is('user/edit/*') || $request->is('user/update/*')){
            if(Auth::user()){
                return $next($request);
            }
            else
            {
                return response()->json("You don't have permission!", 200);
            }
        }

        //User Delete
        if($request->is('user/delete')){
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
