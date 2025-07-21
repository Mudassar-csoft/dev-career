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
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  mixed ...$roles  Roles to authorize
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // Check if the authenticated user has one of the specified roles
        if (auth()->check() && in_array(auth()->user()->role, $roles)) {
            return $next($request); // Allow the request to proceed
        }

        // Return 403 Forbidden if the user does not have the required role
        abort(403, 'Forbidden');
    }
}
