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
                // return response()->json("You don't have permission!", 200);
                return abort(401, 'Unauthorized');
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
                // return response()->json("You don't have permission!", 200);
                return abort(401, 'Unauthorized');
            }
        }

        if($request->is('patientservice/edit/*') || $request->is('patientservice/update/*') || $request->is('patientservice/update_price') || $request->is('patientservice/add_item/*'))
        {   
            // if(Auth::user()->can('patientservices-edit'))
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

        if($request->is('patientservice/cancel/*'))
        {   
            if(Auth::user()->can('patientservices-cancel'))
            {
                return $next($request);
            }
            else
            {
                // return response()->json("You don't have permission!", 200);
                return abort(401, 'Unauthorized');
            }

        }

        if($request->is('patientservice/services-list-per-user') || $request->is('/'))
        {   

            if(Auth::user()->can('patientservices-list-ultrasound') || Auth::user()->can('patientservices-list-ecg') || Auth::user()->can('patientservices-list-checkup') || Auth::user()->can('patientservices-list-laboratory') || Auth::user()->can('patientservices-list-physicaltherapy') || Auth::user()->can('patientservices-list-xray'))
            {
                return $next($request);
            }
            else
            {
                // return response()->json("You don't have permission!", 200);
                return abort(401, 'Unauthorized');
            }
        }

        if($request->is('patientservice/update_price'))
        {
            if(Auth::user()->can('amount-edit'))
            {
                return $next($request);
            }
            else
            {
                // return response()->json("You don't have permission!", 200);
                return abort(401, 'Unauthorized');
            }
        }

        if($request->is('patientservice/remove_item'))
        {
            if(Auth::user()->can('patientservices-item-remove'))
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
