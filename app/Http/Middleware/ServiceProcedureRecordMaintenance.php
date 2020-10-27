<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class ServiceProcedureRecordMaintenance
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
        if($request->is('serviceprocedure/index') || $request->is('serviceprocedure/procedures') || $request->is('serviceprocedure/serviceprocedures'))
        {
            if(Auth::user()->can('serviceprocedure-list'))
            {
                return $next($request);
            }
            else
            {
                // return response()->json("You don't have permission!", 200);
                return abort(401, 'Unauthorized');
            }
        }

        if($request->is('serviceprocedure/create') || $request->is('serviceprocedure/store') || $request->is('serviceprocedure/content/create/*') || $request->is('serviceprocedure/content/update'))
        {
            if(Auth::user()->can('serviceprocedure-create'))
            {
                return $next($request);
            }
            else
            {
                // return response()->json("You don't have permission!", 200);
                return abort(401, 'Unauthorized');
            }
        }

        if($request->is('serviceprocedure/edit') || $request->is('serviceprocedure/update'))
        {
            if(Auth::user()->can('serviceprocedure-edit'))
            {
                return $next($request);
            }
            else
            {
                // return response()->json("You don't have permission!", 200);
                return abort(401, 'Unauthorized');
            }
        }

        if($request->is('serviceprocedure/delete'))
        {
            if(Auth::user()->can('serviceprocedure-delete'))
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
