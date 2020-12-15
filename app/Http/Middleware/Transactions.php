<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class Transactions
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
        if($request->is('transactions') || $request->is('transactions/gettransactions') || $request->is('transactions/getreports') || $request->is('transactions/reports') || $request->is('transactions/reports/preview')){
            if(Auth::user()->can('transactions')){
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
