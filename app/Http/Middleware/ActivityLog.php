<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class ActivityLog
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
        if($request->is('logs'))
        {
            if(Auth::user()->can('activity-log'))
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
