<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class PatientService
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
        if($request->is('patientservice/index') || $request->is('patientservice/patientservices'))
        {
            if(Auth::user()->hasPermissionTo('patientservices-list'))
            {
                return $next($request);
            }
        }

        if($request->is('patientservice/create') || $request->is('patientservice/store'))
        {
            if(Auth::user()->hasPermissionTo('patientservices-create'))
            {
                return $next($request);
            }
        }


    }
}
