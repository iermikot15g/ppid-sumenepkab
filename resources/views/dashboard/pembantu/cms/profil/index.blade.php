@extends('layouts.dashboard')

@section('title', 'CMS Profil OPD')

@section('content')
<div class="space-y-6">
    <div>
        <h1 class="text-2xl font-semibold text-gray-900">CMS Profil OPD</h1>
        <p class="mt-1 text-sm text-gray-600">Kelola konten profil OPD {{ $opd->name }}</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Tentang OPD -->
        <a href="{{ route('pembantu.cms.profil.tentang') }}" 
           class="block bg-white rounded-lg shadow hover:shadow-md transition p-6 text-center">
            <div class="text-4xl mb-3">🏢</div>
            <h3 class="font-semibold text-gray-800">Tentang OPD</h3>
            <p class="text-xs text-gray-500 mt-1">Logo, Google Maps, Konten HTML</p>
        </a>

        <!-- Tugas dan Fungsi -->
        <a href="{{ route('pembantu.cms.profil.tugas-fungsi') }}" 
           class="block bg-white rounded-lg shadow hover:shadow-md transition p-6 text-center">
            <div class="text-4xl mb-3">📋</div>
            <h3 class="font-semibold text-gray-800">Tugas dan Fungsi</h3>
            <p class="text-xs text-gray-500 mt-1">Konten HTML + PDF</p>
        </a>

        <!-- Struktur Organisasi -->
        <a href="{{ route('pembantu.cms.profil.struktur') }}" 
           class="block bg-white rounded-lg shadow hover:shadow-md transition p-6 text-center">
            <div class="text-4xl mb-3">📊</div>
            <h3 class="font-semibold text-gray-800">Struktur Organisasi</h3>
            <p class="text-xs text-gray-500 mt-1">Konten HTML + PDF</p>
        </a>

        <!-- Dasar Hukum -->
        <a href="{{ route('pembantu.cms.profil.dasar-hukum') }}" 
           class="block bg-white rounded-lg shadow hover:shadow-md transition p-6 text-center">
            <div class="text-4xl mb-3">📜</div>
            <h3 class="font-semibold text-gray-800">Dasar Hukum</h3>
            <p class="text-xs text-gray-500 mt-1">Konten HTML + PDF</p>
        </a>

        <!-- Media Sosial -->
        <a href="{{ route('pembantu.cms.profil.media-sosial') }}" 
        class="block bg-white rounded-lg shadow hover:shadow-md transition p-6 text-center">
            <div class="text-4xl mb-3">🌐</div>
            <h3 class="font-semibold text-gray-800">Media Sosial</h3>
            <p class="text-xs text-gray-500 mt-1">Facebook, Instagram, Twitter, YouTube, TikTok, WhatsApp</p>
        </a>

    </div>

    <div class="bg-maroon-50 rounded-lg p-4 mt-6">
        <div class="flex items-start">
            <svg class="w-5 h-5 text-blue-500 mr-2 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <div class="text-sm text-maroon-700">
                <p class="font-medium">Informasi</p>
                <p>Konten yang diisi akan ditampilkan di halaman publik <strong>{{ route('direktori.opd.show', $opd) }}</strong></p>
            </div>
        </div>
    </div>
</div>
@endsection