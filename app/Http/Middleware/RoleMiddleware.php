<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle($request, Closure $next, $role)
    {
        if (Auth::guard('admin')->check() && Auth::guard('admin')->user()->role === $role) {
            return $next($request);
        }

        return redirect('/admin/login')->with('error', 'Unauthorized access.');
    }
}
