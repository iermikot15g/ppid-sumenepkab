@extends('layouts.app')

@section('title', $opd->name)

@php use Illuminate\Support\Facades\Storage; @endphp

@section('content')
<div class="bg-gray-50 min-h-screen py-8">
    <div class="container mx-auto px-4">
        <!-- Breadcrumb -->
        <div class="mb-4 text-sm text-gray-500">
            <a href="{{ url('/') }}" class="hover:text-maroon-600">Beranda</a> >
            <a href="{{ route('direktori.opd') }}" class="hover:text-maroon-600">Direktori OPD</a> >
            <span class="text-gray-700">{{ $opd->name }}</span>
        </div>

        <!-- Header OPD -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <div class="flex flex-col md:flex-row items-center md:items-start gap-4">
                @if($opd->logo && Storage::disk('public')->exists($opd->logo))
                    <img src="{{ Storage::url($opd->logo) }}" alt="{{ $opd->name }}" class="w-24 h-24 object-cover rounded-lg border">
                @else
                    <div class="w-24 h-24 bg-gray-200 rounded-lg flex items-center justify-center">
                        <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                    </div>
                @endif
                <div class="flex-1 text-center md:text-left">
                    <h1 class="text-2xl font-bold text-gray-800">{{ $opd->name }}</h1>
                    <p class="text-gray-500 mt-1">{{ $opd->short_name }}</p>
                    <div class="flex flex-wrap justify-center md:justify-start gap-4 mt-3 text-sm">
                        @if($opd->phone)
                        <span class="flex items-center text-gray-600">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                            </svg>
                            {{ $opd->phone }}
                        </span>
                        @endif
                        @if($opd->email)
                        <span class="flex items-center text-gray-600">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                            {{ $opd->email }}
                        </span>
                        @endif
                        @if($opd->address)
                        <span class="flex items-center text-gray-600">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            {{ $opd->address }}
                        </span>
                        @endif
                    </div>
                </div>
                <div class="text-center md:text-right">
                    <div class="text-2xl font-bold text-maroon-600">{{ $totalDocuments }}</div>
                    <div class="text-sm text-gray-500">Dokumen Publik</div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Konten Utama -->
            <div class="lg:col-span-2 space-y-6">
                <!-- ========== TENTANG OPD ========== -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-semibold text-gray-800 border-b pb-3 mb-4">Tentang OPD</h2>
                    <div class="prose max-w-none text-gray-700">
                        {!! $opd->tentang_content ?? '<p class="text-gray-500">Belum ada deskripsi tentang OPD ini.</p>' !!}
                    </div>
                    @if($opd->tentang_pdf && Storage::disk('public')->exists($opd->tentang_pdf))
                    <div class="mt-4 pt-3 border-t">
                        <a href="{{ Storage::url($opd->tentang_pdf) }}" target="_blank" class="inline-flex items-center text-maroon-600 hover:underline">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                            </svg>
                            Download Dokumen Profil OPD (PDF)
                        </a>
                    </div>
                    @endif
                </div>

                <!-- ========== TUGAS DAN FUNGSI ========== -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-semibold text-gray-800 border-b pb-3 mb-4">Tugas dan Fungsi</h2>
                    <div class="prose max-w-none text-gray-700">
                        {!! $opd->tugas_fungsi_content ?? '<p class="text-gray-500">Belum ada data tugas dan fungsi.</p>' !!}
                    </div>
                    @if($opd->tugas_fungsi_pdf && Storage::disk('public')->exists($opd->tugas_fungsi_pdf))
                    <div class="mt-4 pt-3 border-t">
                        <a href="{{ Storage::url($opd->tugas_fungsi_pdf) }}" target="_blank" class="inline-flex items-center text-maroon-600 hover:underline">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                            </svg>
                            Download Dokumen Tugas dan Fungsi (PDF)
                        </a>
                    </div>
                    @endif
                </div>

                <!-- ========== STRUKTUR ORGANISASI ========== -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-semibold text-gray-800 border-b pb-3 mb-4">Struktur Organisasi</h2>
                    <div class="prose max-w-none text-gray-700">
                        {!! $opd->struktur_content ?? '<p class="text-gray-500">Belum ada data struktur organisasi.</p>' !!}
                    </div>
                    @if($opd->struktur_pdf && Storage::disk('public')->exists($opd->struktur_pdf))
                    <div class="mt-4 pt-3 border-t">
                        <a href="{{ Storage::url($opd->struktur_pdf) }}" target="_blank" class="inline-flex items-center text-maroon-600 hover:underline">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                            </svg>
                            Download Dokumen Struktur Organisasi (PDF)
                        </a>
                    </div>
                    @endif
                </div>

                <!-- ========== DASAR HUKUM ========== -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-semibold text-gray-800 border-b pb-3 mb-4">Dasar Hukum</h2>
                    <div class="prose max-w-none text-gray-700">
                        {!! $opd->dasar_hukum_content ?? '<p class="text-gray-500">Belum ada data dasar hukum.</p>' !!}
                    </div>
                    @if($opd->dasar_hukum_pdf && Storage::disk('public')->exists($opd->dasar_hukum_pdf))
                    <div class="mt-4 pt-3 border-t">
                        <a href="{{ Storage::url($opd->dasar_hukum_pdf) }}" target="_blank" class="inline-flex items-center text-maroon-600 hover:underline">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                            </svg>
                            Download Dokumen Dasar Hukum (PDF)
                        </a>
                    </div>
                    @endif
                </div>

                <!-- ========== LOKASI (GOOGLE MAPS) ========== -->
                @if($opd->google_maps_link)
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-semibold text-gray-800 border-b pb-3 mb-4">Lokasi</h2>
                    <iframe 
                        src="{{ $opd->google_maps_link }}" 
                        width="100%" 
                        height="300" 
                        style="border:0" 
                        allowfullscreen 
                        loading="lazy">
                    </iframe>
                </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Media Sosial -->
                @if($opd->social_media && count($opd->social_media) > 0)
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-lg font-semibold text-gray-800 border-b pb-3 mb-4">Media Sosial</h2>
                    <div class="flex flex-wrap gap-3">
                        @foreach($opd->social_media as $platform => $url)
                            @if($url)
                            <a href="{{ $url }}" target="_blank" class="text-gray-600 hover:text-maroon-600 transition">
                                @if($platform == 'facebook')
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"/>
                                </svg>
                                @elseif($platform == 'instagram')
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/>
                                </svg>
                                @else
                                <span class="capitalize">{{ $platform }}</span>
                                @endif
                            </a>
                            @endif
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Dokumen Terbaru -->
                @if($recentDocuments->count() > 0)
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-lg font-semibold text-gray-800 border-b pb-3 mb-4">Dokumen Terbaru</h2>
                    <ul class="space-y-3">
                        @foreach($recentDocuments as $doc)
                        <li>
                            <a href="{{ route('dip.preview', $doc->id) }}" class="text-gray-700 hover:text-maroon-600 text-sm">
                                {{ $doc->title }}
                            </a>
                            <div class="text-xs text-gray-400">{{ $doc->published_at->format('d/m/Y') }}</div>
                        </li>
                        @endforeach
                    </ul>
                    <div class="mt-4 pt-3 border-t">
                        <a href="{{ route('dip.index') }}?opd={{ $opd->id }}" class="text-sm text-maroon-600 hover:underline">Lihat semua dokumen →</a>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection