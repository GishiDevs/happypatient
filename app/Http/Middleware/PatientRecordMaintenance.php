<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
class PatientRecordMaintenance
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
        
        //Patient Record
        if($request->is('patient/index') || $request->is('patient/patients')){
            if(Auth::user()->hasPermissionTo('patient-list')){
                return $next($request); 
            }
            else
            {
                return response()->json("You don't have permission!", 200);
            }
        }
        
        //Patient Create
        if($request->is('patient/create') || $request->is('patient/store')){
            if(Auth::user()->hasPermissionTo('patient-create')){
                return $next($request);
            }
            else
            {
                return response()->json("You don't have permission!", 200);
            }
        }

        //Patient Edit
        if($request->is('patient/edit/*') || $request->is('patient/update/*')){
            if(Auth::user()->hasPermissionTo('patient-edit')){
                return $next($request);
            }
            else
            {
                return response()->json("You don't have permission!", 200);
            }
        }

        //Patient Delete
        if($request->is('patient/delete')){
            if(Auth::user()->hasPermissionTo('patient-delete')){
                return $next($request);
            }
            else
            {
                return response()->json("You don't have permission!", 200);
            }
        }
        
        
    }

}
