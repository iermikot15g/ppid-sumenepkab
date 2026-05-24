{{-- resources/views/dashboard/pembantu/index.blade.php --}}
@extends('layouts.dashboard')

@section('title', 'Dashboard PPID Pembantu')

@section('content')
<div class="bg-white rounded-lg shadow p-6">
    <div class="border-b border-gray-200 pb-4 mb-4">
        <h1 class="text-2xl font-bold text-gray-900">Dashboard PPID Pembantu</h1>
    </div>
    
    <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-6">
        <p class="text-green-800">
            ✅ Login berhasil sebagai <strong>{{ $user->name }}</strong>
        </p>
        <p class="text-green-700 text-sm mt-1">
            OPD: {{ $opd->name ?? 'Belum terdaftar' }}
        </p>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="bg-blue-50 p-4 rounded-lg">
            <p class="text-blue-800 font-semibold">Dashboard Pembantu</p>
            <p class="text-blue-600 text-sm">Sprint 1 - Berhasil</p>
        </div>
        <div class="bg-gray-50 p-4 rounded-lg">
            <p class="text-gray-800 font-semibold">Manajemen Dokumen</p>
            <p class="text-gray-600 text-sm">Akan datang di Sprint 2</p>
        </div>
        <div class="bg-gray-50 p-4 rounded-lg">
            <p class="text-gray-800 font-semibold">Profil OPD</p>
            <p class="text-gray-600 text-sm">Akan datang di Sprint 2</p>
        </div>
    </div>
</div>
@endsection