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
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|array  $role  Role(s) allowed to access the route
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next, string|array $role): Response
    {
        if (!Auth::check()) {
            abort(403, 'Unauthorized: You must be logged in');
        }

        $userRole = Auth::user()->role ?? null;

        // If multiple roles are allowed, check if user role exists in array
        if ((is_array($role) && !in_array($userRole, $role)) || (!is_array($role) && $userRole !== $role)) {
            abort(403, 'Unauthorized: You do not have permission');
        }

        return $next($request);
    }
}
