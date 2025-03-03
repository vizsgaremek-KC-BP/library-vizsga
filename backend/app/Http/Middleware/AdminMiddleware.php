<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Ellenőrizzük, hogy a felhasználó admin-e
        if (auth()->check() && auth()->user()->role === 'admin') {
            return $next($request);
        }

        // Ha nem admin, akkor 403-as hibát dobunk
        return response()->json(['message' => 'Access denied. Admins only.'], 403);
    }
}
