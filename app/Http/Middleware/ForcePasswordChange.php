<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ForcePasswordChange
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check() && auth()->user()->must_change_password) {
            // Allow access to the change password page and the logout route
            if (!$request->routeIs('dashboard.password.*') && !$request->routeIs('logout')) {
                return redirect()->route('dashboard.password.index')
                    ->with('warning', 'Harap ganti password default Anda untuk melanjutkan.');
            }
        }

        return $next($request);
    }
}
