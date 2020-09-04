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
        if($request->is('service/index') || $request->is('service/services') || $request->is('service/create') 
            || $request->is('service/store') || $request->is('service/edit') || $request->is('service/update') 
            || $request->is('service/delete'))
        {
            if(Auth::user())
            {
                return $next($request);
            }
        }
    }
}
