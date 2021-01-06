<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class FileNumberSetting
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
        if($request->is('file_no_setting/index') || $request->is('file_no_setting/settings') || $request->is('file_no_setting/edit') || $request->is('file_no_setting/settings'))
        {
            if(Auth::user()->can('file-no-setting'))
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
