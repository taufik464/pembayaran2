<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
/**
 * Middleware to check if the user is an admin.
 */ 



class CekStaff
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if the user is authenticated and has the 'staff' role
        if (auth::check() && auth::user()->role === 'staff') {
            return $next($request);
        }

        // If not, redirect to the login page or show an unauthorized response
        return redirect()->route('login')->with('error', 'You do not have access to this resource.');
    }
}
