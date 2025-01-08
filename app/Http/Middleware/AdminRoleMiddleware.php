<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminRoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $role)
    {
        // Pastikan user sudah login sebagai admin
        if (!Auth::guard('admin')->check()) {
            return redirect()->route('admin.login');
        }


        // Cek apakah role sesuai
        $user = Auth::guard('admin')->user();
        if ($user->role === 'admin') {
            return $next($request);
        }

        if ($user->role !== $role) {
            abort(403, 'Unauthorized access.'); // Bisa diarahkan ke halaman lain jika diperlukan
        }

        return $next($request);
    }
}
