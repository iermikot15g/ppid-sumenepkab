@extends('layouts.dashboard')

@section('title', 'Profil Saya')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Profil Saya</h1>
            <a href="{{ url('/dashboard/' . (auth()->user()->hasRole('ppid_pembantu') ? 'pembantu' : 'utama')) }}" 
               class="text-gray-600 hover:text-gray-800">← Kembali ke Dashboard</a>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 rounded">
                {{ session('success') }}
            </div>
        @endif

        <!-- Form Edit Profil -->
        <form method="POST" action="{{ route('profile.update') }}">
            @csrf
            @method('PUT')

            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                    <input type="text" name="name" class="w-full border-gray-300 rounded-md shadow-sm" 
                           value="{{ old('name', $user->name) }}" required>
                    @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" name="email" class="w-full border-gray-300 rounded-md shadow-sm" 
                           value="{{ old('email', $user->email) }}" required>
                    @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nomor Telepon</label>
                    <input type="text" name="phone" class="w-full border-gray-300 rounded-md shadow-sm" 
                           value="{{ old('phone', $user->phone) }}">
                    @error('phone') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Role</label>
                    <input type="text" class="w-full border-gray-300 rounded-md shadow-sm bg-gray-100" 
                           value="{{ $user->getRoleNames()->implode(', ') }}" readonly disabled>
                </div>
            </div>

            <div class="mt-6 flex justify-end">
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                    Simpan Perubahan
                </button>
            </div>
        </form>

        <div class="border-t border-gray-200 mt-8 pt-6">
            <div class="flex justify-between items-center">
                <div>
                    <h2 class="text-lg font-semibold text-gray-800">Ganti Password</h2>
                    <p class="text-sm text-gray-500">Perbarui password akun Anda</p>
                </div>
                <a href="{{ route('profile.password') }}" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                    Ganti Password
                </a>
            </div>
        </div>
    </div>
</div>
@endsection