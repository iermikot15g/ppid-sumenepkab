@extends('layouts.dashboard')

@section('title', 'CMS Profil OPD')

@section('content')
<div class="space-y-6">
    <div>
        <h1 class="text-2xl font-semibold text-gray-900">CMS Profil OPD</h1>
        <p class="mt-1 text-sm text-gray-600">Kelola konten profil OPD {{ $opd->name }}</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Tentang OPD -->
        <a href="{{ route('pembantu.profil-opd.edit-about') }}" 
           class="block bg-white rounded-lg shadow hover:shadow-md transition p-6">
            <div class="flex items-center">
                <div class="text-3xl mr-4">🏢</div>
                <div class="flex-1">
                    <h3 class="font-semibold text-gray-800">Tentang OPD</h3>
                    <p class="text-sm text-gray-500 mt-1">
                        Kelola visi misi, profil, alamat, kontak, dan logo
                    </p>
                </div>
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </div>
        </a>

        <!-- Tugas dan Fungsi -->
        <a href="{{ route('pembantu.profil-opd.edit-duties') }}" 
           class="block bg-white rounded-lg shadow hover:shadow-md transition p-6">
            <div class="flex items-center">
                <div class="text-3xl mr-4">📋</div>
                <div class="flex-1">
                    <h3 class="font-semibold text-gray-800">Tugas dan Fungsi</h3>
                    <p class="text-sm text-gray-500 mt-1">
                        Kelola tugas pokok dan fungsi OPD
                    </p>
                </div>
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </div>
        </a>

        <!-- Struktur Organisasi -->
        <a href="{{ route('pembantu.profil-opd.edit-structure') }}" 
           class="block bg-white rounded-lg shadow hover:shadow-md transition p-6">
            <div class="flex items-center">
                <div class="text-3xl mr-4">📊</div>
                <div class="flex-1">
                    <h3 class="font-semibold text-gray-800">Struktur Organisasi</h3>
                    <p class="text-sm text-gray-500 mt-1">
                        Upload gambar struktur organisasi (rasio 4:3)
                    </p>
                </div>
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </div>
        </a>

        <!-- Dasar Hukum -->
        <a href="{{ url('/dashboard/pembantu/legal-documents') }}" 
           class="block bg-white rounded-lg shadow hover:shadow-md transition p-6">
            <div class="flex items-center">
                <div class="text-3xl mr-4">📜</div>
                <div class="flex-1">
                    <h3 class="font-semibold text-gray-800">Dasar Hukum</h3>
                    <p class="text-sm text-gray-500 mt-1">
                        Kelola dokumen peraturan dan dasar hukum OPD
                    </p>
                </div>
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </div>
        </a>
    </div>
</div>
@endsection