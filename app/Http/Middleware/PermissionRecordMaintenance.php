<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class PermissionRecordMaintenance
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
        if($request->is('permission/index') || $request->is('permission/permissions'))
        {
            if(Auth::user()->hasPermissionTo('permission-list'))
            {
                return $next($request);
            }
            else
            {
                return response()->json("You don't have permission!", 200);
            }
        }

        if($request->is('permission/create') || $request->is('permission/store'))
        {
            if(Auth::user()->hasPermissionTo('permission-create'))
            {
                return $next($request);
            }
            else
            {
                return response()->json("You don't have permission!", 200);
            }
        }

        if($request->is('permission/edit') || $request->is('permission/update'))
        {
            if(Auth::user()->hasPermissionTo('permission-edit'))
            {
                return $next($request);
            }
            else
            {
                return response()->json("You don't have permission!", 200);
            }
        }

        if($request->is('permission/delete'))
        {
            if(Auth::user()->hasPermissionTo('permission-delete'))
            {
                return $next($request);
            }
            else
            {
                return response()->json("You don't have permission!", 200);
            }
        }
        
    }
}
