@extends('layouts.app')

@section('title', $opd->name)

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Breadcrumb -->
    <div class="text-sm text-gray-500 mb-4">
        <a href="{{ route('direktori.opd') }}" class="hover:text-maroon-600">PPID Pembantu</a> / 
        <span class="text-gray-700">{{ $opd->name }}</span>
    </div>

    <!-- Header OPD -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <div class="flex flex-col md:flex-row gap-4">
            <!-- Logo -->
            <div>
                @if($opd->logo)
                    <img src="{{ Storage::url($opd->logo) }}" alt="{{ $opd->name }}" class="w-24 h-24 object-cover rounded-lg">
                @else
                    <div class="w-24 h-24 bg-maroon-100 rounded-lg flex items-center justify-center">
                        <svg class="w-12 h-12 text-maroon-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                    </div>
                @endif
            </div>
            
            <!-- Informasi OPD -->
            <div class="flex-1">
                <h1 class="text-2xl font-bold text-gray-900">{{ $opd->name }}</h1>
                <p class="text-gray-500">{{ $opd->short_name ?? '' }}</p>
                
                <!-- Kontak -->
                <div class="mt-2 text-sm text-gray-600">
                    @if($opd->phone)
                    <p><span class="font-medium">📞 Telepon:</span> {{ $opd->phone }}</p>
                    @endif
                    @if($opd->email)
                    <p><span class="font-medium">✉️ Email:</span> {{ $opd->email }}</p>
                    @endif
                    @if($opd->address)
                    <p><span class="font-medium">📍 Alamat:</span> {{ $opd->address }}</p>
                    @endif
                </div>
                
                <!-- ========== MEDIA SOSIAL (IKON DI BAWAH HEADER) ========== -->
                @php
                    $socialMedia = $opd->getSocialMediaLinks();
                @endphp
                
                @if(!empty($socialMedia))
                <div class="mt-4 flex flex-wrap gap-3">
                    @if(isset($socialMedia['facebook']) && !empty($socialMedia['facebook']))
                    <a href="{{ $socialMedia['facebook'] }}" target="_blank" rel="noopener noreferrer" 
                    class="text-gray-600 hover:text-maroon-700 transition" title="Facebook">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"/>
                        </svg>
                    </a>
                    @endif
                    
                    @if(isset($socialMedia['instagram']) && !empty($socialMedia['instagram']))
                    <a href="{{ $socialMedia['instagram'] }}" target="_blank" rel="noopener noreferrer" 
                    class="text-gray-600 hover:text-pink-600 transition" title="Instagram">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.272 2.695.072 7.053.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8z"/>
                        </svg>
                    </a>
                    @endif
                    
                    @if(isset($socialMedia['twitter']) && !empty($socialMedia['twitter']))
                    <a href="{{ $socialMedia['twitter'] }}" target="_blank" rel="noopener noreferrer" 
                    class="text-gray-600 hover:text-blue-400 transition" title="Twitter / X">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
                        </svg>
                    </a>
                    @endif
                    
                    @if(isset($socialMedia['youtube']) && !empty($socialMedia['youtube']))
                    <a href="{{ $socialMedia['youtube'] }}" target="_blank" rel="noopener noreferrer" 
                    class="text-gray-600 hover:text-red-600 transition" title="YouTube">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.376.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.376-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                        </svg>
                    </a>
                    @endif
                    
                    @if(isset($socialMedia['tiktok']) && !empty($socialMedia['tiktok']))
                    <a href="{{ $socialMedia['tiktok'] }}" target="_blank" rel="noopener noreferrer" 
                    class="text-gray-600 hover:text-black transition" title="TikTok">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M19.59 6.69a4.83 4.83 0 0 1-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 0 1-5.2 1.74 2.89 2.89 0 0 1 2.31-4.64 2.93 2.93 0 0 1 .88.13V9.4a6.84 6.84 0 0 0-1-.05A6.33 6.33 0 0 0 5 20.1a6.34 6.34 0 0 0 10.86-4.43v-7a8.16 8.16 0 0 0 4.77 1.52v-3.4a4.85 4.85 0 0 1-1-.1z"/>
                        </svg>
                    </a>
                    @endif
                    
                    @if(isset($socialMedia['whatsapp']) && !empty($socialMedia['whatsapp']))
                    <a href="{{ $socialMedia['whatsapp'] }}" target="_blank" rel="noopener noreferrer" 
                    class="text-gray-600 hover:text-green-600 transition" title="WhatsApp">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12.04 2c-5.46 0-9.91 4.45-9.91 9.91 0 1.75.46 3.45 1.32 4.95L2.05 22l5.25-1.38c1.45.79 3.08 1.21 4.74 1.21 5.46 0 9.91-4.45 9.91-9.91 0-5.46-4.45-9.91-9.91-9.91zm0 15.67c-1.44 0-2.84-.38-4.06-1.09l-.29-.17-3.12.82.84-3.04-.19-.3c-.77-1.22-1.17-2.63-1.17-4.06 0-4.27 3.48-7.76 7.76-7.76 4.27 0 7.76 3.48 7.76 7.76.01 4.28-3.47 7.76-7.75 7.76z"/>
                            <path d="M17.03 14.5c-.14-.23-.52-.37-1.09-.65-.57-.28-3.37-1.67-3.89-1.86-.52-.19-.9-.28-1.28.28-.38.56-1.47 1.83-1.8 2.21-.33.38-.66.43-1.23.14-.57-.28-2.41-1.33-2.95-1.86-.54-.53-.54-1.23-.12-1.92.42-.69 1.62-1.91 1.62-1.91s.57-.95.33-1.52c-.24-.56-1.33-3.18-1.82-4.26-.48-1.08-.96-.87-1.32-.87-.28 0-.86-.05-1.32-.05-.46 0-1.17.18-1.78.88-.61.7-2.33 2.28-2.33 5.56 0 3.28 2.39 6.46 2.72 6.91.33.45 4.7 7.18 11.38 5.46 1.15-.3 2.06-1.07 2.73-2.07.67-1 .86-1.94.61-2.69-.24-.75-1.04-1.2-1.19-1.33z"/>
                        </svg>
                    </a>
                    @endif
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Tabs Navigation -->
    <div class="border-b border-gray-200 mb-6 overflow-x-auto">
        <nav class="flex space-x-4">
            <button onclick="showTab('tentang')" id="tab-tentang" class="py-2 px-3 border-b-2 border-maroon-500 text-maroon-600 whitespace-nowrap">
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

    <!-- Tab Content: Tentang OPD (menggunakan tentang_content) -->
    <div id="content-tentang" class="bg-white rounded-lg shadow-md p-6">
        @if($opd->tentang_content)
            <div class="prose max-w-none">
                {!! $opd->tentang_content !!}
            </div>
        @else
            <p class="text-gray-500 text-center py-8">Konten sedang dalam pengisian oleh administrator.</p>
        @endif
        
        @if($opd->google_maps_link)
            <div class="mt-6">
                <iframe src="{{ $opd->google_maps_link }}" width="100%" height="300" style="border:0;" allowfullscreen loading="lazy"></iframe>
            </div>
        @endif
    </div>

    <!-- Tab Content: Dasar Hukum (menggunakan dasar_hukum_content dan dasar_hukum_pdf) -->
    <div id="content-dasar-hukum" class="bg-white rounded-lg shadow-md p-6 hidden">
        @if($opd->dasar_hukum_content)
            <div class="prose max-w-none">
                {!! $opd->dasar_hukum_content !!}
            </div>
        @else
            <p class="text-gray-500 text-center py-8">Konten dasar hukum sedang dalam pengisian oleh administrator.</p>
        @endif
        
        @if($opd->dasar_hukum_pdf)
            <div class="mt-6">
                <a href="{{ Storage::url($opd->dasar_hukum_pdf) }}" target="_blank" 
                   class="inline-flex items-center px-4 py-2 bg-maroon-600 text-white rounded-lg hover:bg-maroon-700">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3M3 17V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
                    </svg>
                    Download PDF
                </a>
            </div>
        @endif
    </div>

    <!-- Tab Content: Tugas dan Fungsi (menggunakan tusi_content dan tusi_pdf) -->
    <div id="content-tugas-fungsi" class="bg-white rounded-lg shadow-md p-6 hidden">
        @if($opd->tusi_content)
            <div class="prose max-w-none">
                {!! $opd->tusi_content !!}
            </div>
        @else
            <p class="text-gray-500 text-center py-8">Konten tugas dan fungsi sedang dalam pengisian oleh administrator.</p>
        @endif
        
        @if($opd->tusi_pdf)
            <div class="mt-6">
                <a href="{{ Storage::url($opd->tusi_pdf) }}" target="_blank" 
                   class="inline-flex items-center px-4 py-2 bg-maroon-600 text-white rounded-lg hover:bg-maroon-700">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3M3 17V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
                    </svg>
                    Download PDF
                </a>
            </div>
        @endif
    </div>

    <!-- Tab Content: Struktur Organisasi (menggunakan structure_content dan structure_pdf) -->
    <div id="content-struktur" class="bg-white rounded-lg shadow-md p-6 hidden">
        @if($opd->structure_content)
            <div class="prose max-w-none">
                {!! $opd->structure_content !!}
            </div>
        @else
            <p class="text-gray-500 text-center py-8">Konten struktur organisasi sedang dalam pengisian oleh administrator.</p>
        @endif
        
        @if($opd->structure_pdf)
            <div class="mt-6">
                <a href="{{ Storage::url($opd->structure_pdf) }}" target="_blank" 
                   class="inline-flex items-center px-4 py-2 bg-maroon-600 text-white rounded-lg hover:bg-maroon-700">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3M3 17V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
                    </svg>
                    Download PDF
                </a>
            </div>
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
                            <a href="{{ route('dip.download', $doc) }}" class="text-maroon-600 text-sm hover:underline">
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
                tabEl.classList.remove('border-maroon-500', 'text-maroon-600');
                tabEl.classList.add('border-transparent', 'text-gray-500');
            }
        });
        
        // Show selected content
        document.getElementById(`content-${tab}`).classList.remove('hidden');
        
        // Add active style to selected tab
        const activeTab = document.getElementById(`tab-${tab}`);
        if (activeTab) {
            activeTab.classList.remove('border-transparent', 'text-gray-500');
            activeTab.classList.add('border-maroon-500', 'text-maroon-600');
        }
    }
</script>
@endsection