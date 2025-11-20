<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $permission): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();
        
        // Check if user has permission directly or via role
        if ($this->hasPermission($user, $permission)) {
            return $next($request);
        }

        return response('Unauthorized action.', 403);
    }

    /**
     * Check if user has permission
     */
    private function hasPermission($user, $permission): bool
    {
        // Check user's role permissions
        if ($user->role && $user->role->permissions()->where('slug', $permission)->exists()) {
            return true;
        }

        return false;
    }
}
