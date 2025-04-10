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
        // Check if the user has the required roles
        $user = Auth::user();
        $user = auth()->user();
        $userRoles = $user->roles()->pluck('name')->toArray();

        foreach ($roles as $role) {
            if (in_array($role, $userRoles)) {
                return $next($request);
            }

        
            // Return a 403 Forbidden response without JSON
            if ($request->expectsJson()) {
                abort(403, 'Access forbidden');
            }

            if (in_array('admin', $userRoles)) {
                return redirect()->route('admin.dashboard')
                    ->with('error', 'You do not have permission to access this page');
            } else if (in_array('premiumUser', $userRoles)) {
                return redirect()->route('premium.homme')
                    ->with('error', 'You do not have permission to access this page');
            } else {
                return redirect()->route('user.homme')
                    ->with('error', 'You do not have permission to access this page');
            }
        }
        return $next($request);
    }
}
