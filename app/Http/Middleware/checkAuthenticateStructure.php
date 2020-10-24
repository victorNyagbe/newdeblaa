<?php

namespace App\Http\Middleware;

use Closure;

class checkAuthenticateStructure
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
        if (!session()->has('id'))
        {
            return redirect()->route('structure.loginForm');
        }
        return $next($request);
    }
}
