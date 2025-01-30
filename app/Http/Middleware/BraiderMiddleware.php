<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class BraiderMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Allow access to the complete-profile route for authenticated users
        if ($request->routeIs('braider.complete-profile')) {
            return $next($request);
        }

        // For other routes, ensure the user is a braider or admin
        $user = $request->user();
        if ($user && ($user->role === 'braider' || $user->role === 'admin')) {
            return $next($request);
        }

        // Redirect unauthorized users
        return redirect()->route('unauthorized');
    }
}
