<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                $user = Auth::guard($guard)->user();
                
                if (!$user) {
                    Auth::guard($guard)->logout();
                    return $next($request);
                }
                
                // Check if user has valid role
                if (!$user->role || ($user->role !== 'admin' && $user->role !== 'intern')) {
                    Auth::guard($guard)->logout();
                    return $next($request);
                }
                
                // Redirect based on role
                if ($user->role === 'admin') {
                    return redirect()->route('admin.dashboard');
                } elseif ($user->role === 'intern') {
                    return redirect()->route('intern.dashboard');
                } elseif ($user->role === 'mentor') {
                    return redirect()->route('mentor.dashboard');
                }
            }
        }

        return $next($request);
    }
}
