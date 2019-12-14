<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class AuthorizedAsAdmin
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
        if (!Auth::guard('admin')->user())
        {
            return redirect()->route('login')->with('alert_info', 'Your session has expired. Please relogin');
        }

        return $next($request);
    }
}
