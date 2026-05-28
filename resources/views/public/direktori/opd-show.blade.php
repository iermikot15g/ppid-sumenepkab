@extends('layouts.app')

@section('title', $opd->name)

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Breadcrumb -->
    <div class="text-sm text-gray-500 mb-4">
        <a href="{{ route('direktori.opd') }}" class="hover:text-blue-600">PPID Pembantu</a> / 
        <span class="text-gray-700">{{ $opd->name }}</span>
    </div>

    <!-- Header OPD -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <div class="flex flex-col md:flex-row gap-4">
            <div>
                @if($opd->logo)
                    <img src="{{ Storage::url($opd->logo) }}" alt="{{ $opd->name }}" class="w-24 h-24 object-cover rounded-lg">
                @else
                    <div class="w-24 h-24 bg-blue-100 rounded-lg flex items-center justify-center">
                        <svg class="w-12 h-12 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                    </div>
                @endif
            </div>
            <div class="flex-1">
                <h1 class="text-2xl font-bold text-gray-900">{{ $opd->name }}</h1>
                <p class="text-gray-500">{{ $opd->short_name ?? '' }}</p>
                <div class="mt-2 text-sm text-gray-600">
                    <p><span class="font-medium">Telepon:</span> {{ $opd->phone ?? '-' }}</p>
                    <p><span class="font-medium">Email:</span> {{ $opd->email ?? '-' }}</p>
                    <p><span class="font-medium">Alamat:</span> {{ $opd->address ?? '-' }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabs Navigation -->
    <div class="border-b border-gray-200 mb-6 overflow-x-auto">
        <nav class="flex space-x-4">
            <button onclick="showTab('tentang')" id="tab-tentang" class="py-2 px-3 border-b-2 border-blue-500 text-blue-600 whitespace-nowrap">
                Tentang OPD
            </button>
            <button onclick="showTab('dasar-hukum')" id="tab-dasar-hukum" class="py-2 px-3 border-b-2 border-transparent text-gray-500 hover:text-gray-700 whitespace-nowrap">
                Dasar Hukum
            </button>
            <button onclick="showTab('tugas-fungsi')" id="tab-tugas-fungsi" class="py-2 px-3 border-b-2 border-transparent text-gray-500 hover:text-gray-700 whitespace-nowrap">
                Tugas dan Fungsi
            </button>
            <button onclick="showTab('struktur')" id="tab-struktur" class="py-2 px-3 border-b-2 border-transparent text-gray-500 hover:text-gray-700 whitespace-nowrap">
                Struktur Organisasi
            </button>
            <button onclick="showTab('dokumen')" id="tab-dokumen" class="py-2 px-3 border-b-2 border-transparent text-gray-500 hover:text-gray-700 whitespace-nowrap">
                Dokumen DIP
            </button>
        </nav>
    </div>

    <!-- Tab Content: Tentang OPD -->
    <div id="content-tentang" class="bg-white rounded-lg shadow-md p-6">
        <div class="space-y-4">
            @if($opd->vision || $opd->mission)
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Visi dan Misi</h3>
                    @if($opd->vision)
                        <div class="mb-3">
                            <h4 class="font-medium text-gray-700">Visi</h4>
                            <p class="text-gray-600">{{ $opd->vision }}</p>
                        </div>
                    @endif
                    @if($opd->mission)
                        <div>
                            <h4 class="font-medium text-gray-700">Misi</h4>
                            <p class="text-gray-600 whitespace-pre-line">{{ $opd->mission }}</p>
                        </div>
                    @endif
                </div>
            @endif
            
            @if($opd->about_content)
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Profil OPD</h3>
                    <div class="text-gray-600">{!! nl2br(e($opd->about_content)) !!}</div>
                </div>
            @endif

            @if($opd->google_maps_link)
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Lokasi Kantor</h3>
                    <div class="rounded-lg overflow-hidden">
                        <iframe src="{{ $opd->google_maps_link }}" width="100%" height="300" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Tab Content: Dasar Hukum -->
    <div id="content-dasar-hukum" class="bg-white rounded-lg shadow-md p-6 hidden">
        @php
            $legalDocs = App\Models\LegalDocument::where('opd_id', $opd->id)->where('is_published', true)->latest()->get();
        @endphp
        
        @if($legalDocs->count() > 0)
            <div class="space-y-3">
                @foreach($legalDocs as $doc)
                    <div class="border-b border-gray-100 pb-3">
                        <h4 class="font-medium text-gray-800">{{ $doc->title }}</h4>
                        @if($doc->regulation_number)
                            <p class="text-sm text-gray-500">Nomor: {{ $doc->regulation_number }}</p>
                        @endif
                        @if($doc->year)
                            <p class="text-sm text-gray-500">Tahun: {{ $doc->year }}</p>
                        @endif
                        @if($doc->description)
                            <p class="text-sm text-gray-600 mt-1">{{ $doc->description }}</p>
                        @endif
                        <a href="{{ Storage::url($doc->file_path) }}" target="_blank" class="inline-block mt-2 text-blue-600 text-sm hover:underline">
                            Download PDF →
                        </a>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-gray-500 text-center py-8">Belum ada dokumen hukum.</p>
        @endif
    </div>

    <!-- Tab Content: Tugas dan Fungsi -->
    <div id="content-tugas-fungsi" class="bg-white rounded-lg shadow-md p-6 hidden">
        <div class="space-y-4">
            @if($opd->duties_content)
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Tugas</h3>
                    <div class="text-gray-600">{!! nl2br(e($opd->duties_content)) !!}</div>
                </div>
            @endif
            @if($opd->functions_content)
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Fungsi</h3>
                    <div class="text-gray-600">{!! nl2br(e($opd->functions_content)) !!}</div>
                </div>
            @endif
            @if(!$opd->duties_content && !$opd->functions_content)
                <p class="text-gray-500 text-center py-8">Konten sedang dalam pengisian oleh administrator.</p>
            @endif
        </div>
    </div>

    <!-- Tab Content: Struktur Organisasi -->
    <div id="content-struktur" class="bg-white rounded-lg shadow-md p-6 hidden">
        @if($opd->structure_image)
            <div class="flex justify-center">
                <img src="{{ Storage::url($opd->structure_image) }}" alt="Struktur Organisasi" 
                     class="max-w-full rounded-lg shadow-sm">
            </div>
        @else
            <p class="text-gray-500 text-center py-8">Struktur organisasi belum tersedia.</p>
        @endif
    </div>

    <!-- Tab Content: Dokumen DIP -->
    <div id="content-dokumen" class="bg-white rounded-lg shadow-md p-6 hidden">
        @php
            $documents = App\Models\Document::where('opd_id', $opd->id)
                ->where('status', 'published')
                ->latest('published_at')
                ->paginate(10);
        @endphp
        
        @if($documents->count() > 0)
            <div class="space-y-4">
                @foreach($documents as $doc)
                    <div class="border-b border-gray-100 pb-3">
                        <h4 class="font-medium text-gray-800">{{ $doc->title }}</h4>
                        <p class="text-sm text-gray-500">{{ $doc->year }} • {{ $doc->category->name ?? '-' }}</p>
                        <p class="text-sm text-gray-600 mt-1">{{ Str::limit($doc->description, 150) }}</p>
                        <div class="mt-2">
                            <a href="{{ route('dip.download', $doc) }}" class="text-blue-600 text-sm hover:underline">
                                Download →
                            </a>
                        </div>
                    </div>
                @endforeach
                <div class="mt-4">
                    {{ $documents->links() }}
                </div>
            </div>
        @else
            <p class="text-gray-500 text-center py-8">Belum ada dokumen yang dipublikasikan.</p>
        @endif
    </div>
</div>

<script>
    function showTab(tab) {
        // Hide all contents
        document.getElementById('content-tentang').classList.add('hidden');
        document.getElementById('content-dasar-hukum').classList.add('hidden');
        document.getElementById('content-tugas-fungsi').classList.add('hidden');
        document.getElementById('content-struktur').classList.add('hidden');
        document.getElementById('content-dokumen').classList.add('hidden');
        
        // Remove active styles from all tabs
        const tabs = ['tentang', 'dasar-hukum', 'tugas-fungsi', 'struktur', 'dokumen'];
        tabs.forEach(t => {
            const tabEl = document.getElementById(`tab-${t}`);
            if (tabEl) {
                tabEl.classList.remove('border-blue-500', 'text-blue-600');
                tabEl.classList.add('border-transparent', 'text-gray-500');
            }
        });
        
        // Show selected content
        document.getElementById(`content-${tab}`).classList.remove('hidden');
        
        // Add active style to selected tab
        const activeTab = document.getElementById(`tab-${tab}`);
        activeTab.classList.remove('border-transparent', 'text-gray-500');
        activeTab.classList.add('border-blue-500', 'text-blue-600');
    }
</script>
@endsection