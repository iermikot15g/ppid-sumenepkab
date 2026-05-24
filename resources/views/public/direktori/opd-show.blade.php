@extends('layouts.app')

@section('title', $opd->name)

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Breadcrumb -->
    <div class="text-sm text-gray-500 mb-4">
        <a href="{{ route('direktori.opd') }}" class="hover:text-blue-600">PPID Pembantu</a> / 
        <span class="text-gray-700">{{ $opd->name }}</span>
    </div>

    <!-- Header -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <div class="flex flex-col md:flex-row gap-4">
            <div>
                @if($opd->logo)
                    <img src="{{ Storage::url($opd->logo) }}" alt="{{ $opd->name }}" class="w-24 h-24 object-cover rounded-lg">
                @else
                    <div class="w-24 h-24 bg-blue-100 rounded-lg flex items-center justify-center">
                        <svg class="w-12 h-12 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                    </div>
                @endif
            </div>
            <div class="flex-1">
                <h1 class="text-2xl font-bold text-gray-900">{{ $opd->name }}</h1>
                <p class="text-gray-500">{{ $opd->short_name ?? '' }}</p>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4 text-sm">
                    <div>
                        <p><span class="font-medium">Telepon:</span> {{ $opd->phone ?? '-' }}</p>
                        <p><span class="font-medium">Email:</span> {{ $opd->email ?? '-' }}</p>
                    </div>
                    <div>
                        <p><span class="font-medium">Alamat:</span> {{ $opd->address ?? '-' }}</p>
                        <p><span class="font-medium">Total Dokumen:</span> {{ $totalDocuments }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabs -->
    <div class="border-b border-gray-200 mb-6">
        <nav class="flex space-x-8">
            <a href="#profil" onclick="showTab('profil')" id="tab-profil" class="py-2 px-1 border-b-2 border-blue-500 text-blue-600">Profil</a>
            <a href="#dokumen" onclick="showTab('dokumen')" id="tab-dokumen" class="py-2 px-1 border-b-2 border-transparent text-gray-500 hover:text-gray-700">Dokumen Terbaru</a>
        </nav>
    </div>

    <!-- Tab Content: Profil -->
    <div id="content-profil" class="bg-white rounded-lg shadow-md p-6">
        <div class="space-y-4">
            <div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Visi dan Misi</h3>
                <div class="text-gray-700">{!! nl2br(e($opd->vision_mission ?? 'Belum ada data.')) !!}</div>
            </div>
            <div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Tugas dan Fungsi</h3>
                <div class="text-gray-700">{!! nl2br(e($opd->duties ?? 'Belum ada data.')) !!}</div>
            </div>
        </div>
    </div>

    <!-- Tab Content: Dokumen -->
    <div id="content-dokumen" class="bg-white rounded-lg shadow-md p-6 hidden">
        <div class="space-y-4">
            @forelse($recentDocuments as $doc)
            <div class="border-b border-gray-100 pb-3">
                <h4 class="font-medium text-gray-900">{{ $doc->title }}</h4>
                <p class="text-sm text-gray-500">{{ $doc->year }} • {{ $doc->category->name ?? '-' }}</p>
                <p class="text-sm text-gray-600 mt-1">{{ Str::limit($doc->description, 100) }}</p>
                <a href="{{ route('dip.index', ['search' => $doc->title]) }}" class="text-blue-600 text-sm hover:underline">Lihat Detail →</a>
            </div>
            @empty
            <p class="text-gray-500">Belum ada dokumen yang dipublikasikan.</p>
            @endforelse
            
            <a href="{{ route('dip.index', ['opd' => $opd->id]) }}" class="inline-block mt-2 text-blue-600 hover:underline">
                Lihat semua dokumen →
            </a>
        </div>
    </div>
</div>

<script>
    function showTab(tab) {
        // Hide all contents
        document.getElementById('content-profil').classList.add('hidden');
        document.getElementById('content-dokumen').classList.add('hidden');
        
        // Remove active styles from tabs
        document.getElementById('tab-profil').classList.remove('border-blue-500', 'text-blue-600');
        document.getElementById('tab-profil').classList.add('border-transparent', 'text-gray-500');
        document.getElementById('tab-dokumen').classList.remove('border-blue-500', 'text-blue-600');
        document.getElementById('tab-dokumen').classList.add('border-transparent', 'text-gray-500');
        
        // Show selected content and active tab
        if (tab === 'profil') {
            document.getElementById('content-profil').classList.remove('hidden');
            document.getElementById('tab-profil').classList.add('border-blue-500', 'text-blue-600');
            document.getElementById('tab-profil').classList.remove('border-transparent', 'text-gray-500');
        } else {
            document.getElementById('content-dokumen').classList.remove('hidden');
            document.getElementById('tab-dokumen').classList.add('border-blue-500', 'text-blue-600');
            document.getElementById('tab-dokumen').classList.remove('border-transparent', 'text-gray-500');
        }
    }
</script>
@endsection