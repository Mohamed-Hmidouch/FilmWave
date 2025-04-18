<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // Check if the user is authenticated
        if (!auth()->check()) {
            return redirect('/login');
        }
        
        // Get the user and their roles
        $user = auth()->user();
        $userRoles = $user->roles()->pluck('name')->toArray();
        
        // Convert all roles to lowercase for case-insensitive comparison
        $userRoles = array_map('strtolower', $userRoles);
        $allowedRoles = array_map('strtolower', $roles);
        
        // Check if the user has ANY of the required roles (OR logic)
        $hasPermission = false;
        foreach ($allowedRoles as $role) {
            if (in_array($role, $userRoles)) {
                $hasPermission = true;
                break;
            }
        }
        
        if ($hasPermission) {
            return $next($request);
        }
        
        // If we get here, the user doesn't have any of the required roles
        if ($request->expectsJson()) {
            abort(403, 'Access forbidden');
        }
        
        // Redirect based on highest role the user has
        if (in_array('admin', $userRoles)) {
            return redirect()->route('admin.dashboard')
                ->with('error', 'You do not have permission to access this page');
        } else if (in_array('premiumuser', $userRoles)) {
            return redirect()->route('user.homme')
                ->with('error', 'You do not have permission to access this page');
        } else {
            return redirect()->route('user.homme')
                ->with('error', 'You do not have permission to access this page');
        }
    }
}
