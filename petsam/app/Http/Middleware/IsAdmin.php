<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // Check if user is authenticated and has admin or editor role
        if ($request->user() && $request->user()->role && in_array($request->user()->role->name, ['Admin', 'Editor'])) {
            return $next($request);
        }

        // Redirect to home if not admin
        return redirect('/')->with('error', 'Bạn không có quyền truy cập trang này.');
    }
}
