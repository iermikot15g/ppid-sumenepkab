@extends('layouts.dashboard')

@section('title', 'CMS Standar Layanan')

@section('content')
<div class="space-y-6">
    <div>
        <h1 class="text-2xl font-semibold text-gray-900">CMS Standar Layanan</h1>
        <p class="mt-1 text-sm text-gray-600">Kelola konten halaman standar layanan PPID</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        @php
            $sections = [
                'standar_maklumat' => ['title' => 'Maklumat Pelayanan', 'icon' => '📢'],
                'standar_prosedur_permohonan' => ['title' => 'Prosedur Permohonan Informasi', 'icon' => '📝'],
                'standar_prosedur_keberatan' => ['title' => 'Prosedur Pengajuan Keberatan', 'icon' => '⚖️'],
                'standar_prosedur_sengketa' => ['title' => 'Prosedur Sengketa Informasi', 'icon' => '🏛️'],
                'standar_jalur_waktu' => ['title' => 'Jalur dan Waktu Layanan', 'icon' => '⏰'],
                'standar_biaya' => ['title' => 'Biaya Layanan', 'icon' => '💰'],
            ];
        @endphp

        @foreach($pages as $page)
            @php
                $info = $sections[$page->page_key] ?? ['title' => $page->title, 'icon' => '📄'];
            @endphp
            <a href="{{ route('utama.cms.standar.edit', $page->page_key) }}" 
               class="block bg-white rounded-lg shadow hover:shadow-md transition p-6">
                <div class="flex items-center">
                    <div class="text-3xl mr-4">{{ $info['icon'] }}</div>
                    <div class="flex-1">
                        <h3 class="font-semibold text-gray-800">{{ $info['title'] }}</h3>
                        <p class="text-sm text-gray-500 mt-1">
                            Terakhir diperbarui: {{ $page->updated_at ? $page->updated_at->format('d/m/Y H:i') : 'Belum diperbarui' }}
                        </p>
                    </div>
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </div>
            </a>
        @endforeach
    </div>
</div>
@endsection