<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is authenticated first
        if (!Auth::check()) {
            return redirect('/login')->with('error', 'Please login to access this area.');
        }

        // Check if the authenticated user is an admin
        // Assuming you have an 'is_admin' column in your users table
        if (!Auth::user()->is_admin) {
            // Redirect non-admin users or show 403 error
            return redirect('/home')->with('error', 'You do not have admin access.');
            // Alternative: abort(403, 'Unauthorized action.');
        }

        // User is authenticated and is admin, proceed
        return $next($request);
    }
}