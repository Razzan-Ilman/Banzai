<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsCore
{
    /**
     * Handle an incoming request.
     * 
     * Allows: 'core' and 'admin' roles (admin has higher privilege)
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $role = strtolower(auth()->user()->role);
        
        // Admin can access everything, Core can access core routes
        if (!in_array($role, ['core', 'admin'])) {
            abort(403, 'Akses hanya untuk CORE members dan Admin.');
        }

        return $next($request);
    }
}
