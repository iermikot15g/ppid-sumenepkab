@extends('layouts.app')

@section('title', 'Agenda Kegiatan - PPID Kabupaten Sumenep')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- ============================================================ -->
    <!-- HEADER HALAMAN AGENDA                                        -->
    <!-- ============================================================ -->
    <div class="mb-8">
        <h1 class="text-2xl md:text-3xl font-bold text-blue-900">Agenda Kegiatan</h1>
        <p class="text-gray-600 mt-2">Kumpulan agenda kegiatan Kabupaten Sumenep</p>
    </div>

    <!-- ============================================================ -->
    <!-- BREADCRUMB NAVIGASI                                          -->
    <!-- ============================================================ -->
    <div class="text-sm text-gray-500 mb-4">
        <a href="{{ route('home') }}" class="hover:text-maroon-600">Beranda</a> / 
        <span class="text-gray-700">Agenda Kegiatan</span>
    </div>

    <!-- ============================================================ -->
    <!-- FILTER STATUS (Coming Soon, Expired, All)                    -->
    <!-- ============================================================ -->
    <div class="flex flex-wrap gap-2 mb-6">
        <a href="{{ route('agenda.index') }}" 
           class="px-4 py-2 text-sm rounded-full {{ !isset($activeFilter) || $activeFilter == 'all' ? 'bg-maroon-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
            Semua Agenda
        </a>
        <a href="{{ route('agenda.filter', ['status' => 'upcoming']) }}" 
           class="px-4 py-2 text-sm rounded-full {{ isset($activeFilter) && $activeFilter == 'upcoming' ? 'bg-maroon-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
            Akan Datang
        </a>
        <a href="{{ route('agenda.filter', ['status' => 'expired']) }}" 
           class="px-4 py-2 text-sm rounded-full {{ isset($activeFilter) && $activeFilter == 'expired' ? 'bg-maroon-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
            Telah Lewat
        </a>
    </div>

    <!-- ============================================================ -->
    <!-- AGENDA LIST - 4 kolom                                        -->
    <!-- ============================================================ -->
    @if($agendas->count() > 0)
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        @foreach($agendas as $agenda)
        @php
            $isExpired = \Carbon\Carbon::parse($agenda->event_date)->isPast();
        @endphp
        <a href="{{ route('dip.index', ['search' => $agenda->title]) }}" 
           class="block bg-white rounded-lg shadow-md hover:shadow-lg transition border-l-4 {{ $isExpired ? 'border-gray-300' : 'border-maroon-500' }} overflow-hidden group">
            <div class="p-4">
                <!-- Tanggal -->
                <div class="flex items-center {{ $isExpired ? 'text-gray-400' : 'text-maroon-600' }} mb-2">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <span class="text-sm font-medium">{{ \Carbon\Carbon::parse($agenda->event_date)->translatedFormat('d F Y') }}</span>
                </div>
                
                <!-- Judul -->
                <h3 class="font-semibold text-gray-800 mb-2 line-clamp-2 group-hover:text-maroon-600 transition">
                    {{ $agenda->title }}
                </h3>
                
                <!-- Lokasi -->
                @if($agenda->location)
                <div class="flex items-center text-gray-500 text-sm mt-2">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <span class="text-xs line-clamp-1">{{ $agenda->location }}</span>
                </div>
                @endif
                
                <!-- Status Badge -->
                @if($isExpired)
                <div class="mt-3">
                    <span class="inline-block px-2 py-1 text-xs rounded-full bg-gray-100 text-gray-500">
                        Sudah Berlalu
                    </span>
                </div>
                @else
                <div class="mt-3">
                    <span class="inline-block px-2 py-1 text-xs rounded-full bg-green-100 text-green-600">
                        Akan Datang
                    </span>
                </div>
                @endif
            </div>
        </a>
        @endforeach
    </div>

    <!-- ============================================================ -->
    <!-- PAGINATION                                                   -->
    <!-- ============================================================ -->
    <div class="mt-8">
        {{ $agendas->links() }}
    </div>
    @else
    <!-- ============================================================ -->
    <!-- EMPTY STATE - Jika belum ada agenda                          -->
    <!-- ============================================================ -->
    <div class="bg-gray-50 rounded-lg p-12 text-center">
        <svg class="mx-auto h-16 w-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
        </svg>
        <p class="mt-4 text-gray-500">Belum ada agenda kegiatan yang dipublikasikan.</p>
        <p class="text-sm text-gray-400">Agenda akan ditampilkan di sini setelah dipublikasikan oleh administrator.</p>
    </div>
    @endif
</div>
@endsection