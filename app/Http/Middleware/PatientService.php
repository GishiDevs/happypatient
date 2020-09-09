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
        if($request->is('patientservice/index') || $request->is('patientservice/services-list'))
        {
            if(Auth::user()->can('patientservices-list'))
            {
                return $next($request);
            }
            else
            {
                return response()->json("You don't have permission!", 200);
            }
        }

        if($request->is('patientservice/create') || $request->is('patientservice/store'))
        {
            if(Auth::user()->can('patientservices-create'))
            {
                return $next($request);
            }
            else
            {
                return response()->json("You don't have permission!", 200);
            }
        }
        if($request->is('patientservice/services-list-per-user') || $request->is('/'))
        {   

            if(Auth::user()->can('patientservices-list-ultrasound', 'patientservices-list-ecg', 'patientservices-list-checkup', 'patientservices-list-laboratory', 'patientservices-list-physicaltherapy', 'patientservices-list-xray'))
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
