@extends('layouts.app')

@section('title', ucfirst(str_replace('-', ' ', $slug)) . ' - Standar Layanan PPID')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Breadcrumb -->
    <div class="text-sm text-gray-500 mb-4">
        <a href="{{ route('home') }}" class="hover:text-blue-600">Beranda</a> / 
        <a href="{{ route('standar-layanan.index') }}" class="hover:text-blue-600">Standar Layanan</a> / 
        <span class="text-gray-700">{{ ucfirst(str_replace('-', ' ', $slug)) }}</span>
    </div>

    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-2xl md:text-3xl font-bold text-blue-900">
            {{ ucfirst(str_replace('-', ' ', $slug)) }}
        </h1>
        <p class="text-gray-600 mt-2">Standar Layanan PPID Kabupaten Sumenep</p>
    </div>

    <!-- Sub Menu Tabs -->
    <div class="border-b border-gray-200 mb-6 overflow-x-auto">
        <nav class="flex space-x-4">
            <a href="{{ route('standar-layanan.show', 'maklumat') }}" 
               class="py-2 px-3 border-b-2 whitespace-nowrap {{ $slug == 'maklumat' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700' }}">
                Maklumat Pelayanan
            </a>
            <a href="{{ route('standar-layanan.show', 'prosedur') }}" 
               class="py-2 px-3 border-b-2 whitespace-nowrap {{ $slug == 'prosedur' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700' }}">
                Prosedur Permohonan
            </a>
            <a href="{{ route('standar-layanan.show', 'keberatan') }}" 
               class="py-2 px-3 border-b-2 whitespace-nowrap {{ $slug == 'keberatan' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700' }}">
                Prosedur Keberatan
            </a>
            <a href="{{ route('standar-layanan.show', 'sengketa') }}" 
               class="py-2 px-3 border-b-2 whitespace-nowrap {{ $slug == 'sengketa' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700' }}">
                Prosedur Sengketa
            </a>
            <a href="{{ route('standar-layanan.show', 'jalur-waktu') }}" 
               class="py-2 px-3 border-b-2 whitespace-nowrap {{ $slug == 'jalur-waktu' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700' }}">
                Jalur dan Waktu
            </a>
            <a href="{{ route('standar-layanan.show', 'biaya') }}" 
               class="py-2 px-3 border-b-2 whitespace-nowrap {{ $slug == 'biaya' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700' }}">
                Biaya Layanan
            </a>
        </nav>
    </div>

    <!-- Content -->
    <div class="bg-white rounded-lg shadow-md p-6">
        @if($content && $content->content)
            <div class="prose max-w-none">
                {!! $content->content !!}
            </div>
            @if($content->pdf_file_path)
                <div class="mt-6">
                    <a href="{{ Storage::url($content->pdf_file_path) }}" target="_blank" 
                       class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3M3 17V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
                        </svg>
                        Download PDF
                    </a>
                </div>
            @endif
        @else
            <div class="text-center py-8">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <p class="mt-2 text-gray-500">Konten sedang dalam pengisian oleh administrator.</p>
            </div>
        @endif
    </div>
</div>
@endsection