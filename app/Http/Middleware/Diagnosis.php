<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class Diagnosis
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
        if($request->is('diagnosis/create/*') || $request->is('diagnosis/store')){
            if(Auth::user()->can('patientservices-list-ultrasound') || Auth::user()->can('patientservices-list-ecg') || Auth::user()->can('patientservices-list-checkup') || Auth::user()->can('patientservices-list-laboratory') || Auth::user()->can('patientservices-list-physicaltherapy') || Auth::user()->can('patientservices-list-xray'))
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
