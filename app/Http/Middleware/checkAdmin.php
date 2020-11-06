<?php

namespace App\Http\Middleware;

use Closure;

class checkAdmin
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
        if (!session()->has('id')) {
            return redirect()->route('admin.loginForm');
        } else {
            if (session()->has('identity')) {
                if (session()->get('identity') == 'admin') {
                    return $next($request);
                } else {
                    abort(403);
                }
            } else {
                abort(403);
            }
        }
    }
}
