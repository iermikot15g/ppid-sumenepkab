<?php
// app/Http/Controllers/Public/AuthController.php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserProfile;
use App\Models\Province;
use App\Models\Regency;
use App\Models\District;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('public.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials, $request->remember)) {
            $request->session()->regenerate();
            
            $user = Auth::user();
            
            // Redirect berdasarkan role
            if ($user->hasRole('super_admin') || $user->hasRole('ppid_utama')) {
                return redirect()->route('dashboard.utama');
            } elseif ($user->hasRole('ppid_pembantu')) {
                return redirect()->route('dashboard.pembantu');
            } elseif ($user->hasRole('pimpinan')) {
                return redirect()->route('pimpinan.dashboard');
            }
            
            return redirect()->route('home');
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    public function showRegisterForm()
    {
        $provinces = Province::orderBy('name')->get();
        $regencies = Regency::where('province_id', 35)->orderBy('name')->get(); // Default Jawa Timur
        $districts = District::where('regency_id', 3529)->orderBy('name')->get(); // Default Sumenep
        
        return view('public.register', compact('provinces', 'regencies', 'districts'));
    }

    public function register(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            // Informasi Login
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|string|max:15|unique:users',
            'password' => 'required|string|min:8|confirmed',
            
            // Informasi Pribadi
            'nik' => 'required|string|size:16|unique:user_profiles,nik',
            'address' => 'required|string|max:500',
            'province_id' => 'required|exists:provinces,id',
            'regency_id' => 'required|exists:regencies,id',
            'district_id' => 'required|exists:districts,id',
            'gender' => 'required|in:male,female',
            'birth_date' => 'required|date|before:today',
            'education' => 'required|string|max:100',
            'occupation' => 'required|string|max:100',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Buat user baru
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'is_active' => true,
        ]);

        // Assign role 'masyarakat'
        $user->assignRole('masyarakat');

        // Buat user profile
        UserProfile::create([
            'user_id' => $user->id,
            'nik' => $request->nik,
            'address' => $request->address,
            'province_id' => $request->province_id,
            'regency_id' => $request->regency_id,
            'district_id' => $request->district_id,
            'gender' => $request->gender,
            'birth_date' => $request->birth_date,
            'education' => $request->education,
            'occupation' => $request->occupation,
        ]);

        // Auto login setelah register
        Auth::login($user);

        return redirect()->route('home')
            ->with('success', 'Pendaftaran berhasil! Selamat datang di PPID Kabupaten Sumenep.');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}