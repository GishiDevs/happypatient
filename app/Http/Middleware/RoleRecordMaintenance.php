<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class RoleRecordMaintenance
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
        if($request->is('role/index') || $request->is('role/roles'))
        {
            if(Auth::user()->hasPermissionTo('role-list'))
            {
                return $next($request);
            }
            else
            {
                return response()->json("You don't have permission!", 200);
            }
        }

        if($request->is('role/create') || $request->is('role/store'))
        {
            if(Auth::user()->hasPermissionTo('role-create'))
            {
                return $next($request);
            }
            else
            {
                return response()->json("You don't have permission!", 200);
            }
        }

        if($request->is('role/edit') || $request->is('role/update'))
        {
            if(Auth::user()->hasPermissionTo('role-edit'))
            {
                return $next($request);
            }
            else
            {
                return response()->json("You don't have permission!", 200);
            }
        }

        if($request->is('role/delete'))
        {
            if(Auth::user()->hasPermissionTo('role-delete'))
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
