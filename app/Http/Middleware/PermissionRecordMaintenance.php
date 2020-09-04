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
        if($request->is('permission/index') || $request->is('permission/permissions') || $request->is('permission/create') 
            || $request->is('permission/store') || $request->is('permission/edit') || $request->is('permission/update') 
            || $request->is('permission/delete'))
        {
            if(Auth::user())
            {
                return $next($request);
            }
        }
        
    }
}
