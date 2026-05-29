@extends('layouts.app')

@section('title', 'PPID Kabupaten Sumenep')

@section('content')
<!-- ============================================================ -->
<!-- HERO SLIDER SECTION                                          -->
<!-- Rasio gambar: 1920:815 atau 384:163                          -->
<!-- ============================================================ -->
@php
    use App\Models\HeroSlide;
    $heroSlides = HeroSlide::active()->get();
@endphp

@if($heroSlides->count() > 0)
<style>
    /* ========== HERO SLIDER STYLES ========== */
    .hero-slider-container {
        position: relative;
        width: 100%;
        overflow: hidden;
    }
    /* Rasio 1920:815 = 2.355 : 1 */
    .hero-slides-wrapper {
        position: relative;
        width: 100%;
        aspect-ratio: 1920 / 815;
        background-color: #1a3a5c;
    }
    @media (max-width: 768px) {
        .hero-slides-wrapper {
            aspect-ratio: 384 / 163;
        }
    }
    .hero-slide-item {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        opacity: 0;
        transition: opacity 0.8s ease-in-out;
    }
    .hero-slide-item.active {
        opacity: 1;
        z-index: 1;
    }
    .hero-slide-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: center center;
    }
    /* Navigasi Tombol */
    .hero-nav-btn {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        background: rgba(0, 0, 0, 0.5);
        color: white;
        border: none;
        cursor: pointer;
        padding: 12px 16px;
        font-size: 18px;
        border-radius: 50%;
        z-index: 10;
        transition: background 0.3s;
    }
    @media (min-width: 768px) {
        .hero-nav-btn {
            padding: 14px 20px;
            font-size: 20px;
        }
    }
    .hero-nav-btn:hover {
        background: rgba(0, 0, 0, 0.8);
    }
    .hero-prev {
        left: 15px;
    }
    .hero-next {
        right: 15px;
    }
    /* Dots Navigasi */
    .hero-dots {
        position: absolute;
        bottom: 20px;
        left: 0;
        right: 0;
        display: flex;
        justify-content: center;
        gap: 10px;
        z-index: 10;
    }
    .hero-dot {
        width: 10px;
        height: 10px;
        background: rgba(255, 255, 255, 0.5);
        border-radius: 50%;
        border: none;
        cursor: pointer;
        transition: all 0.3s;
    }
    .hero-dot.active {
        background: white;
        width: 24px;
        border-radius: 5px;
    }
</style>

<div class="hero-slider-container">
    <div class="hero-slides-wrapper">
        @foreach($heroSlides as $index => $slide)
        <div class="hero-slide-item {{ $index === 0 ? 'active' : '' }}" data-index="{{ $index }}">
            <img src="{{ asset('storage/' . $slide->image_path) }}" alt="{{ $slide->title ?? 'Slide ' . ($index + 1) }}">
        </div>
        @endforeach
    </div>
    
    @if($heroSlides->count() > 1)
    <button class="hero-nav-btn hero-prev" onclick="prevHeroSlide()">❮</button>
    <button class="hero-nav-btn hero-next" onclick="nextHeroSlide()">❯</button>
    
    <div class="hero-dots">
        @foreach($heroSlides as $index => $slide)
        <button class="hero-dot {{ $index === 0 ? 'active' : '' }}" onclick="goToHeroSlide({{ $index }})"></button>
        @endforeach
    </div>
    @endif
</div>

<script>
    // ========== HERO SLIDER SCRIPT ==========
    (function() {
        let currentIndex = 0;
        const totalSlides = {{ $heroSlides->count() }};
        let interval;
        
        function showSlide(index) {
            document.querySelectorAll('.hero-slide-item').forEach((slide, i) => {
                slide.classList.toggle('active', i === index);
            });
            document.querySelectorAll('.hero-dot').forEach((dot, i) => {
                dot.classList.toggle('active', i === index);
            });
            currentIndex = index;
        }
        
        function nextSlide() {
            let newIndex = currentIndex + 1;
            if (newIndex >= totalSlides) newIndex = 0;
            showSlide(newIndex);
            resetInterval();
        }
        
        function prevSlide() {
            let newIndex = currentIndex - 1;
            if (newIndex < 0) newIndex = totalSlides - 1;
            showSlide(newIndex);
            resetInterval();
        }
        
        function goToSlide(index) {
            showSlide(index);
            resetInterval();
        }
        
        function resetInterval() {
            if (interval) clearInterval(interval);
            if (totalSlides > 1) {
                interval = setInterval(nextSlide, 5000);
            }
        }
        
        window.prevHeroSlide = prevSlide;
        window.nextHeroSlide = nextSlide;
        window.goToHeroSlide = goToSlide;
        
        if (totalSlides > 1) {
            interval = setInterval(nextSlide, 5000);
        }
    })();
</script>
@else
<!-- Fallback Hero jika tidak ada slide -->
<div class="bg-gradient-to-r from-blue-800 to-blue-600 text-white py-16 md:py-24">
    <div class="container mx-auto px-4 text-center">
        <h1 class="text-3xl md:text-5xl font-bold mb-4">PPID Kabupaten Sumenep</h1>
        <p class="text-lg md:text-xl mb-6">Pejabat Pengelola Informasi dan Dokumentasi</p>
        <p class="text-blue-100 max-w-2xl mx-auto">Transparan, Cepat, dan Mudah Diakses</p>
    </div>
</div>
@endif

<!-- ============================================================ -->
<!-- QUICK ACCESS SECTION - Ikon akses cepat ke fitur utama      -->
<!-- ============================================================ -->
<div class="container mx-auto px-4 py-12">
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 max-w-4xl mx-auto">
        <a href="{{ route('dip.index') }}" class="bg-white shadow-md rounded-lg p-4 text-center hover:shadow-lg transition">
            <svg class="w-8 h-8 text-blue-600 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
            <span class="text-sm font-medium">Daftar Informasi Publik</span>
        </a>
        <a href="{{ route('direktori.opd') }}" class="bg-white shadow-md rounded-lg p-4 text-center hover:shadow-lg transition">
            <svg class="w-8 h-8 text-blue-600 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
            </svg>
            <span class="text-sm font-medium">PPID Pembantu</span>
        </a>
        <a href="#kontak" class="bg-white shadow-md rounded-lg p-4 text-center hover:shadow-lg transition" onclick="document.getElementById('footer')?.scrollIntoView({behavior: 'smooth'})">
            <svg class="w-8 h-8 text-blue-600 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
            </svg>
            <span class="text-sm font-medium">Hubungi Kami</span>
        </a>
        <a href="{{ route('login') }}" class="bg-white shadow-md rounded-lg p-4 text-center hover:shadow-lg transition">
            <svg class="w-8 h-8 text-blue-600 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
            </svg>
            <span class="text-sm font-medium">Login / Daftar</span>
        </a>
    </div>
</div>

<!-- ============================================================ -->
<!-- WELCOME SECTION - Sambutan dan informasi portal             -->
<!-- ============================================================ -->
<div class="container mx-auto px-4 py-8">
    <div class="bg-blue-50 rounded-lg p-8 max-w-4xl mx-auto text-center">
        <h2 class="text-2xl font-bold text-blue-800 mb-3">Selamat Datang di Portal PPID Kabupaten Sumenep</h2>
        <p class="text-gray-700 mb-4">
            Pejabat Pengelola Informasi dan Dokumentasi (PPID) Kabupaten Sumenep berkomitmen 
            memberikan layanan informasi publik yang transparan, cepat, dan mudah diakses sesuai 
            dengan Undang-Undang Nomor 14 Tahun 2008 tentang Keterbukaan Informasi Publik.
        </p>
        <div class="flex flex-wrap justify-center gap-3 mt-6">
            <a href="{{ route('dip.index') }}" class="inline-block px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">Lihat Daftar Informasi Publik</a>
            <a href="{{ route('login') }}" class="px-6 py-2 bg-white text-blue-600 border border-blue-600 rounded-lg hover:bg-blue-50 transition">Login ke Dashboard</a>
        </div>
    </div>
</div>

<!-- ============================================================ -->
<!-- INFOGRAFIS SECTION - Grid 4 kolom                           -->
<!-- Preview menggunakan modal gambar                             -->
<!-- ============================================================ -->
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Infografis</h2>
        <a href="{{ route('infografis.index') }}" class="text-blue-600 hover:underline">Lihat Semua →</a>
    </div>
    
    @php
        $infographics = App\Models\News::where('type', 'infographic')
            ->where('is_published', true)
            ->latest('published_at')
            ->take(4)
            ->get();
    @endphp
    
    @if($infographics->count() > 0)
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        @foreach($infographics as $infographic)
        <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition group cursor-pointer" 
             onclick="openInfografisModal('{{ asset('storage/' . $infographic->thumbnail) }}', '{{ addslashes($infographic->title) }}')">
            @if($infographic->thumbnail && Storage::disk('public')->exists($infographic->thumbnail))
                <img src="{{ asset('storage/' . $infographic->thumbnail) }}" alt="{{ $infographic->title }}" 
                     class="w-full h-64 object-cover group-hover:scale-105 transition duration-300">
            @else
                <div class="w-full h-64 bg-gray-200 flex items-center justify-center">
                    <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
            @endif
            <div class="p-3 bg-white">
                <h3 class="font-semibold text-gray-800 text-sm line-clamp-2">{{ $infographic->title }}</h3>
            </div>
        </div>
        @endforeach
    </div>
    @else
    <div class="bg-gray-50 rounded-lg p-8 text-center">
        <p class="text-gray-500">Belum ada infografis.</p>
    </div>
    @endif
</div>

<!-- ============================================================ -->
<!-- INFOGRAFIS MODAL - Preview gambar (ukuran menyesuaikan)      -->
<!-- ============================================================ -->
<div id="infografisModal" class="fixed inset-0 z-50 hidden bg-black bg-opacity-90 items-center justify-center p-4" onclick="closeInfografisModal()">
    <div class="relative max-w-full max-h-full" onclick="event.stopPropagation()">
        <button onclick="closeInfografisModal()" class="absolute -top-12 right-0 text-white hover:text-gray-300 text-3xl z-10">&times;</button>
        <div class="flex items-center justify-center">
            <img id="infografisModalImage" src="" alt="" 
                 class="max-w-[90vw] max-h-[90vh] w-auto h-auto object-contain rounded-lg shadow-2xl">
        </div>
        <p id="infografisModalCaption" class="text-center text-white mt-4 text-sm"></p>
    </div>
</div>

<!-- ============================================================ -->
<!-- GALERI FOTO SECTION - Grid 6 kolom                           -->
<!-- Klik "Lihat Semua" -> menuju ke halaman khusus galeri        -->
<!-- ============================================================ -->
<div class="container mx-auto px-4 py-8 bg-gray-50 rounded-lg my-4">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Galeri Foto</h2>
        <a href="{{ route('galeri.index') }}" class="text-blue-600 hover:underline">Lihat Semua →</a>
    </div>
    
    @php
        $galleries = App\Models\News::where('type', 'gallery')
            ->where('is_published', true)
            ->latest('published_at')
            ->take(6)
            ->get();
    @endphp
    
    @if($galleries->count() > 0)
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-3">
        @foreach($galleries as $gallery)
        <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition cursor-pointer" 
             onclick="openGaleriModal('{{ asset('storage/' . $gallery->thumbnail) }}', '{{ addslashes($gallery->title) }}')">
            @if($gallery->thumbnail && Storage::disk('public')->exists($gallery->thumbnail))
                <img src="{{ asset('storage/' . $gallery->thumbnail) }}" alt="{{ $gallery->title }}" class="w-full h-32 object-cover">
            @else
                <div class="w-full h-32 bg-gray-200 flex items-center justify-center">
                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
            @endif
        </div>
        @endforeach
    </div>
    @else
    <div class="bg-white rounded-lg p-8 text-center">
        <p class="text-gray-500">Belum ada foto galeri.</p>
    </div>
    @endif
</div>

<!-- ============================================================ -->
<!-- GALERI MODAL - Preview gambar (ukuran menyesuaikan)          -->
<!-- ============================================================ -->
<div id="galeriModal" class="fixed inset-0 z-50 hidden bg-black bg-opacity-90 items-center justify-center p-4" onclick="closeGaleriModal()">
    <div class="relative max-w-full max-h-full" onclick="event.stopPropagation()">
        <button onclick="closeGaleriModal()" class="absolute -top-12 right-0 text-white hover:text-gray-300 text-3xl z-10">&times;</button>
        <div class="flex items-center justify-center">
            <img id="galeriModalImage" src="" alt="" 
                 class="max-w-[90vw] max-h-[90vh] w-auto h-auto object-contain rounded-lg shadow-2xl">
        </div>
        <p id="galeriModalCaption" class="text-center text-white mt-4 text-sm"></p>
    </div>
</div>

<!-- ============================================================ -->
<!-- AGENDA KEGIATAN SECTION - Grid 4 kolom x 3 baris            -->
<!-- Urutan: agenda terbaru (tanggal terdekat) di paling atas     -->
<!-- Klik "Lihat Semua" -> menuju ke halaman khusus agenda        -->
<!-- ============================================================ -->
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Agenda Kegiatan</h2>
        <a href="{{ route('agenda.index') }}" class="text-blue-600 hover:underline">Lihat Semua →</a>
    </div>
    
    @php
        // Ambil 12 agenda terbaru (4 kolom x 3 baris = 12 item)
        // Urutan: event_date ASC (yang paling dekat tampil pertama)
        $agendas = App\Models\News::where('type', 'agenda')
            ->where('is_published', true)
            ->where('event_date', '>=', now()) // Hanya agenda yang belum lewat
            ->orderBy('event_date', 'asc')     // Urutan dari yang paling dekat
            ->take(12)
            ->get();
    @endphp
    
    @if($agendas->count() > 0)
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        @foreach($agendas as $agenda)
        <a href="{{ route('agenda.index') }}?search={{ urlencode($agenda->title) }}" 
           class="block bg-white rounded-lg shadow-md hover:shadow-lg transition border-l-4 border-blue-500 overflow-hidden group">
            <div class="p-4">
                <!-- Tanggal - Format dengan hari, tanggal, bulan, tahun -->
                <div class="flex items-center text-blue-600 mb-2">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <span class="text-sm font-medium">{{ \Carbon\Carbon::parse($agenda->event_date)->translatedFormat('l, d F Y') }}</span>
                </div>
                
                <!-- Judul -->
                <h3 class="font-semibold text-gray-800 mb-2 line-clamp-2 group-hover:text-blue-600 transition">
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
                
                <!-- Sisa hari (countdown) -->
                @php
                    $daysLeft = now()->diffInDays(\Carbon\Carbon::parse($agenda->event_date), false);
                @endphp
                <div class="mt-3">
                    <span class="inline-block px-2 py-1 text-xs rounded-full bg-green-100 text-green-600">
                        @if($daysLeft == 0)
                            Hari Ini
                        @elseif($daysLeft == 1)
                            Besok
                        @else
                            {{ $daysLeft }} hari lagi
                        @endif
                    </span>
                </div>
            </div>
        </a>
        @endforeach
    </div>
    
    <!-- Jika agenda kurang dari 12, tampilkan pesan info -->
    @if($agendas->count() < 12)
    <div class="mt-4 text-center text-gray-500 text-sm">
        Menampilkan {{ $agendas->count() }} agenda terdekat
    </div>
    @endif
    
    @else
    <div class="bg-gray-50 rounded-lg p-8 text-center">
        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
        </svg>
        <p class="mt-2 text-gray-500">Belum ada agenda kegiatan terdekat.</p>
    </div>
    @endif
</div>

<!-- ============================================================ -->
<!-- SCRIPTS - Modal preview untuk infografis dan galeri          -->
<!-- ============================================================ -->
<script>
    // ================================================================
    // INFOGRAFIS MODAL
    // ================================================================
    function openInfografisModal(imageUrl, title) {
        const modal = document.getElementById('infografisModal');
        const modalImage = document.getElementById('infografisModalImage');
        const modalCaption = document.getElementById('infografisModalCaption');
        
        if (modal && modalImage && modalCaption) {
            modalImage.src = imageUrl;
            modalCaption.textContent = title;
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            document.body.style.overflow = 'hidden';
        }
    }

    function closeInfografisModal() {
        const modal = document.getElementById('infografisModal');
        if (modal) {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            document.body.style.overflow = 'auto';
        }
    }
    
    // ================================================================
    // GALERI MODAL
    // ================================================================
    function openGaleriModal(imageUrl, title) {
        const modal = document.getElementById('galeriModal');
        const modalImage = document.getElementById('galeriModalImage');
        const modalCaption = document.getElementById('galeriModalCaption');
        
        if (modal && modalImage && modalCaption) {
            modalImage.src = imageUrl;
            modalCaption.textContent = title;
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            document.body.style.overflow = 'hidden';
        }
    }

    function closeGaleriModal() {
        const modal = document.getElementById('galeriModal');
        if (modal) {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            document.body.style.overflow = 'auto';
        }
    }

    // Tutup semua modal dengan tombol Escape
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            closeInfografisModal();
            closeGaleriModal();
        }
    });
</script>
@endsection