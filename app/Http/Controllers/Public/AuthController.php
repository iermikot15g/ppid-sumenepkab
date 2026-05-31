<?php
// app/Http/Controllers/Public/AuthController.php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('public.auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $remember = $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            $user = Auth::user();
            
            // Check if user is active
            if (!$user->is_active) {
                Auth::logout();
                return back()->withErrors([
                    'email' => 'Akun Anda telah dinonaktifkan. Silakan hubungi administrator.',
                ])->onlyInput('email');
            }

            // ========== REDIRECT BERDASARKAN ROLE ==========
            
            // Super Admin & PPID Utama -> Dashboard Utama
            if ($user->hasRole('super_admin') || $user->hasRole('ppid_utama')) {
                return redirect()->intended('/dashboard/utama');
            }
            
            // PPID Pembantu -> Dashboard Pembantu
            if ($user->hasRole('ppid_pembantu')) {
                return redirect()->intended('/dashboard/pembantu');
            }
            
            // PIMPINAN OPD (READ-ONLY) -> Dashboard Pimpinan
            // PERUBAHAN: sebelumnya ke /dashboard/utama, sekarang ke /dashboard/pimpinan
            if ($user->hasRole('pimpinan')) {
                return redirect()->intended('/dashboard/pimpinan');
            }

            // Default untuk masyarakat dan role lainnya
            return redirect()->intended('/');
        }

        return back()->withErrors([
            'email' => 'Email atau password yang dimasukkan salah.',
        ])->onlyInput('email');
    }

    public function showRegisterForm()
    {
        return view('public.auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => ['required', 'string', 'max:15', 'unique:users'],
            'password' => ['required', 'confirmed', Password::min(8)->mixedCase()->numbers()],
            'terms' => ['required', 'accepted'],
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'password' => Hash::make($validated['password']),
            'is_active' => true,
        ]);

        $user->assignRole('masyarakat');
        Auth::login($user);

        return redirect('/')->with('success', 'Selamat datang! Anda berhasil mendaftar.');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}