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
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is authenticated and has the appropriate role
        if ($request->user() && ($request->user()->hasRole('Supper admin') || $request->user()->hasRole('Teacher'))) {
            return $next($request);
        }

        // Redirect unauthorized users to a different route
        return redirect()->route('dashboard')->with('error', 'You do not have permission to access this page.');
    }
}
