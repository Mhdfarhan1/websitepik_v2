<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!$request->user()) {
            return redirect('/login');
        }

        foreach ($roles as $role) {
            if ($request->user()->role === $role) {
                return $next($request);
            }
        }

        // If not authorized, logout and redirect with error for extra security
        auth()->logout();
        return redirect('/login')->withErrors([
            'email' => 'Akses ditolak. Anda tidak memiliki izin untuk masuk ke area ini.',
        ]);
    }
}
