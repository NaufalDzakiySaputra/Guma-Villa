<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // 1. Cek apakah user sudah login
        if (!Auth::check()) {
            return redirect()->route('login')
                ->with('error', 'Please login to access this page.');
        }

        // 2. Cek apakah user adalah admin
        if (Auth::user()->role !== 'admin') {
            // User biasa: BLOCK TOTAL dengan 403 Forbidden
            abort(403, 'Unauthorized access. Admin privileges required.');
        }

        return $next($request);
    }
}