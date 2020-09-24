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
            if(Auth::user()->can('user-list')){
                return $next($request); 
            }
            else
            {
                // return response()->json("You don't have permission!", 200);
                return abort(401, 'Unauthorized');
            }
        }
        
        //User Create
        if($request->is('user/create') || $request->is('user/store')){
            if(Auth::user()->can('user-create')){
                return $next($request);
            }
            else
            {
                // return response()->json("You don't have permission!", 200);
                return abort(401, 'Unauthorized');
            }
        }

        //User Edit
        if($request->is('user/edit/*') || $request->is('user/update/*')){
            if(Auth::user()->can('user-edit')){
                return $next($request);
            }
            else
            {
                // return response()->json("You don't have permission!", 200);
                return abort(401, 'Unauthorized');
            }
        }

        //User Delete
        if($request->is('user/delete')){
            if(Auth::user()->can('user-delete')){
                return $next($request);
            }
            else
            {
                // return response()->json("You don't have permission!", 200);
                return abort(401, 'Unauthorized');;
            }
        }
    }
}
