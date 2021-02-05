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
            if(Auth::user()->can('patient-list')){
                return $next($request); 
            }
            else
            {
                // return response()->json("You don't have permission!", 200);
                return abort(401, 'Unauthorized');
            }
        }
        
        //Patient Create
        if($request->is('patient/create') || $request->is('patient/store')){
            if(Auth::user()->can('patient-create')){
                return $next($request);
            }
            else
            {
                // return response()->json("You don't have permission!", 200);
                return abort(401, 'Unauthorized');
            }
        }

        //Patient Edit
        if($request->is('patient/edit/*') || $request->is('patient/update/*')){
            // if(Auth::user()->can('patient-edit')){
            //     return $next($request);
            // }
            // else
            // {
            //     // return response()->json("You don't have permission!", 200);
            //     return abort(401, 'Unauthorized');
            // }
            return $next($request);
        }

        //Patient Delete
        if($request->is('patient/delete')){
            if(Auth::user()->can('patient-delete')){
                return $next($request);
            }
            else
            {
                // return response()->json("You don't have permission!", 200);
                return abort(401, 'Unauthorized');
            }
        }

        //Patient History
        if($request->is('patient/history/*') || $request->is('patient/diagnosis/*')){
            if(Auth::user()->can('patient-history')){
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
