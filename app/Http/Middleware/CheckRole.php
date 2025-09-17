<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please log in to access this page.');
        }

        $user = Auth::user();
        
        // Check if user has any of the required roles
        foreach ($roles as $role) {
            if ($user->hasRole($role)) {
                return $next($request);
            }
        }

        // Enhanced error handling based on user role and attempted access
        $userRole = $user->role;
        $attemptedRoles = implode(', ', $roles);
        
        // Log the unauthorized access attempt
        \Log::warning("Unauthorized access attempt", [
            'user_id' => $user->id,
            'user_email' => $user->email,
            'user_role' => $userRole,
            'required_roles' => $attemptedRoles,
            'attempted_url' => $request->url(),
            'ip_address' => $request->ip(),
        ]);

        // Provide specific error messages based on the situation
        if ($userRole === 'guest' && in_array('organizer', $roles)) {
            $errorMessage = 'Access Denied: Only organizers can access the admin panel. You are currently logged in as a guest user.';
        } elseif ($userRole === 'organizer' && in_array('guest', $roles)) {
            $errorMessage = 'This area is restricted to guest users only.';
        } else {
            $errorMessage = "Access Denied: You need {$attemptedRoles} role(s) to access this page. Your current role is: {$userRole}.";
        }

        // For AJAX requests, return JSON error
        if ($request->expectsJson()) {
            return response()->json([
                'error' => 'Access Denied',
                'message' => $errorMessage,
                'user_role' => $userRole,
                'required_roles' => $roles
            ], 403);
        }

        // For admin panel access attempts, show dedicated error page
        if (str_contains($request->url(), '/admin/') || in_array('organizer', $roles)) {
            return redirect()->route('access.denied')->with('error', $errorMessage);
        }

        // For other cases, redirect to appropriate dashboard with error
        if ($user->isOrganizer()) {
            return redirect()->route('admin.dashboard')->with('error', $errorMessage);
        } else {
            return redirect()->route('dashboard')->with('error', $errorMessage);
        }
    }
}