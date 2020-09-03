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
            if(Auth::user()){
                return $next($request); 
            }
            else
            {
                return response()->json("You don't have permission!", 200);
            }
        }
        
        //Patient Create
        if($request->is('patient/create')){
            if(Auth::user()){
                return $next($request);
            }
            else
            {
                return response()->json("You don't have permission!", 200);
            }
        }
        
        
    }

}
