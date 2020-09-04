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
        if($request->is('role/index') || $request->is('role/roles') || $request->is('role/create') 
            || $request->is('role/store') || $request->is('role/edit') || $request->is('role/update') 
            || $request->is('role/delete'))
        {
            if(Auth::user())
            {
                return $next($request);
            }
        }
    }
}
