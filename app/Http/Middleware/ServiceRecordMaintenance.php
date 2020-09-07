<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class ServiceRecordMaintenance
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
        if($request->is('service/index') || $request->is('service/services'))
        {
            if(Auth::user()->hasPermissionTo('service-list'))
            {
                return $next($request);
            }
            else
            {
                return response()->json("You don't have permission!", 200);
            }
        }

        if($request->is('service/create') || $request->is('service/store'))
        {
            if(Auth::user()->hasPermissionTo('service-create'))
            {
                return $next($request);
            }
            else
            {
                return response()->json("You don't have permission!", 200);
            }
        }

        if($request->is('service/edit') || $request->is('service/update'))
        {
            if(Auth::user()->hasPermissionTo('service-edit'))
            {
                return $next($request);
            }
            else
            {
                return response()->json("You don't have permission!", 200);
            }
        }

        if($request->is('service/delete'))
        {
            if(Auth::user()->hasPermissionTo('service-delete'))
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
