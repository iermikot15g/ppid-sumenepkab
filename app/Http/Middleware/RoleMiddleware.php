<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        if (!$user->is_active) {
            Auth::logout();
            return redirect()->route('login')->withErrors([
                'email' => 'Akun Anda telah dinonaktifkan.',
            ]);
        }

        // Jika tidak ada role yang dispesifikasikan, izinkan akses
        if (empty($roles)) {
            return $next($request);
        }

        // Cek apakah user memiliki salah satu role yang diizinkan
        foreach ($roles as $role) {
            if ($user->hasRole($role)) {
                return $next($request);
            }
        }

        // Tidak memiliki role yang diizinkan
        abort(403, 'Anda tidak memiliki akses ke halaman ini.');
    }
}