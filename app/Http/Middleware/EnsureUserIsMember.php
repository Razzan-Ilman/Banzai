<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsMember
{
    /**
     * Handle an incoming request.
     * 
     * Allows: 'member', 'core', and 'admin' roles (higher roles can access member routes)
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $role = strtolower(auth()->user()->role);
        
        // Admin and Core can access everything, Member can access member routes
        if (!in_array($role, ['member', 'core', 'admin'])) {
            abort(403, 'Akses hanya untuk Members.');
        }

        return $next($request);
    }
}
