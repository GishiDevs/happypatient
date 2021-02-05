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
            // if(Auth::user()->can('permission-list'))
            // {
            //     return $next($request);
            // }
            // else
            // {
            //     // return response()->json("You don't have permission!", 200);
            //     return abort(401, 'Unauthorized');
            // }
            return $next($request);
        }

        if($request->is('permission/create') || $request->is('permission/store'))
        {
            if(Auth::user()->can('permission-create'))
            {
                return $next($request);
            }
            else
            {
                // return response()->json("You don't have permission!", 200);
                return abort(401, 'Unauthorized');
            }
        }

        if($request->is('permission/edit') || $request->is('permission/update'))
        {
            if(Auth::user()->hasRole('Admin') && Auth::user()->can('permission-edit'))
            {
                return $next($request);
            }
            else
            {
                // return response()->json("You don't have permission!", 200);
                return abort(401, 'Unauthorized');
            }
        }

        if($request->is('permission/delete'))
        {
            if(Auth::user()->hasRole('Admin') && Auth::user()->can('permission-delete'))
            {
                return $next($request);
            }
            else
            {
                // return response()->json("You don't have permission!", 200);
                return abort(401, 'Unauthorized');
            }
        }
        
    }
}
