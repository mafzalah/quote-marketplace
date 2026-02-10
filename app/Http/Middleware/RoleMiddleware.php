<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next , $role): Response
    {
        // Check if user is logged in
        if (!Auth::check()) {
            return redirect()->route('login.show');
        }

        // Check user role
        if (Auth::user()->role !== $role) {
            abort(403, 'Unauthorized'); // or redirect somewhere
        }

        return $next($request);
    }
}
