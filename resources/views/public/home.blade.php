@extends('layouts.app')

@section('title', 'PPID Kabupaten Sumenep')

@section('content')
<!-- Hero Slider Section - Ukuran Gambar 965x410px -->
@php
    use App\Models\HeroSlide;
    $heroSlides = HeroSlide::active()->get();
@endphp

@if($heroSlides->count() > 0)
<style>
    .hero-slider-container {
        position: relative;
        width: 100%;
        overflow: hidden;
    }
    .hero-slides-wrapper {
        position: relative;
        width: 100%;
        aspect-ratio: 965 / 410;
        background-color: #1a3a5c;
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
    .hero-overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(to bottom, rgba(0,0,0,0.3), rgba(0,0,0,0.6));
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        color: white;
        padding: 0 1rem;
    }
    .hero-content {
        max-width: 56rem;
    }
    .hero-title {
        font-size: 1.25rem;
        font-weight: bold;
        margin-bottom: 0.5rem;
        text-shadow: 0 2px 4px rgba(0,0,0,0.5);
    }
    @media (min-width: 640px) {
        .hero-title {
            font-size: 1.5rem;
        }
    }
    @media (min-width: 768px) {
        .hero-title {
            font-size: 2rem;
        }
    }
    @media (min-width: 1024px) {
        .hero-title {
            font-size: 2.5rem;
        }
    }
    .hero-subtitle {
        font-size: 0.75rem;
        margin-bottom: 1rem;
        text-shadow: 0 1px 2px rgba(0,0,0,0.5);
    }
    @media (min-width: 640px) {
        .hero-subtitle {
            font-size: 0.875rem;
        }
    }
    @media (min-width: 768px) {
        .hero-subtitle {
            font-size: 1rem;
        }
    }
    @media (min-width: 1024px) {
        .hero-subtitle {
            font-size: 1.125rem;
        }
    }
    .hero-nav-btn {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        background: rgba(0, 0, 0, 0.5);
        color: white;
        border: none;
        cursor: pointer;
        padding: 8px 12px;
        font-size: 16px;
        border-radius: 50%;
        z-index: 10;
        transition: background 0.3s;
    }
    @media (min-width: 768px) {
        .hero-nav-btn {
            padding: 10px 15px;
            font-size: 18px;
        }
    }
    @media (min-width: 1024px) {
        .hero-nav-btn {
            padding: 12px 18px;
            font-size: 20px;
        }
    }
    .hero-nav-btn:hover {
        background: rgba(0, 0, 0, 0.8);
    }
    .hero-prev {
        left: 10px;
    }
    .hero-next {
        right: 10px;
    }
    .hero-dots {
        position: absolute;
        bottom: 12px;
        left: 0;
        right: 0;
        display: flex;
        justify-content: center;
        gap: 6px;
        z-index: 10;
    }
    @media (min-width: 768px) {
        .hero-dots {
            bottom: 15px;
            gap: 8px;
        }
    }
    @media (min-width: 1024px) {
        .hero-dots {
            bottom: 20px;
        }
    }
    .hero-dot {
        width: 8px;
        height: 8px;
        background: rgba(255, 255, 255, 0.5);
        border-radius: 50%;
        border: none;
        cursor: pointer;
        transition: all 0.3s;
    }
    @media (min-width: 768px) {
        .hero-dot {
            width: 10px;
            height: 10px;
        }
    }
    .hero-dot.active {
        background: white;
        width: 20px;
        border-radius: 5px;
    }
    @media (min-width: 768px) {
        .hero-dot.active {
            width: 24px;
        }
    }
    
    /* Infografis Rasio 9:16 */
    .infographic-item {
        aspect-ratio: 9 / 16;
        overflow: hidden;
    }
    .infographic-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: center center;
    }
</style>

<div class="hero-slider-container">
    <div class="hero-slides-wrapper">
        @foreach($heroSlides as $index => $slide)
        <div class="hero-slide-item {{ $index === 0 ? 'active' : '' }}" data-index="{{ $index }}">
            <img src="{{ asset('storage/' . $slide->image_path) }}" alt="{{ $slide->title ?? 'Slide' }}">
            <div class="hero-overlay">
                <div class="hero-content">
                    @if($slide->title)
                        <h2 class="hero-title">{{ $slide->title }}</h2>
                    @endif
                    @if($slide->subtitle)
                        <p class="hero-subtitle">{{ $slide->subtitle }}</p>
                    @endif
                </div>
            </div>
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

<!-- Quick Access Section -->
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

<!-- Welcome Section -->
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

<!-- Infografis Section (Rasio 9:16) -->
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Infografis</h2>
        <a href="{{ route('dip.index', ['category' => 'infographic']) }}" class="text-blue-600 hover:underline">Lihat Semua →</a>
    </div>
    
    @php
        $infographics = App\Models\News::where('type', 'infographic')->where('is_published', true)->latest('published_at')->take(4)->get();
    @endphp
    
    @if($infographics->count() > 0)
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        @foreach($infographics as $infographic)
        <a href="{{ route('dip.index', ['search' => $infographic->title]) }}" class="infographic-item bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition">
            @if($infographic->thumbnail && Storage::disk('public')->exists($infographic->thumbnail))
                <img src="{{ asset('storage/' . $infographic->thumbnail) }}" alt="{{ $infographic->title }}" class="w-full h-full object-cover">
            @else
                <div class="w-full h-full bg-gray-200 flex items-center justify-center">
                    <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
            @endif
        </a>
        @endforeach
    </div>
    @else
    <div class="bg-gray-50 rounded-lg p-8 text-center">
        <p class="text-gray-500">Belum ada infografis.</p>
    </div>
    @endif
</div>

<!-- Berita Terbaru Section -->
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Berita Terbaru</h2>
        <a href="{{ route('dip.index', ['category' => 'news']) }}" class="text-blue-600 hover:underline">Lihat Semua →</a>
    </div>
    
    @php
        $latestNews = App\Models\News::where('type', 'news')->where('is_published', true)->latest('published_at')->take(3)->get();
    @endphp
    
    @if($latestNews->count() > 0)
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @foreach($latestNews as $news)
        <a href="{{ route('dip.index', ['search' => $news->title]) }}" class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition">
            @if($news->thumbnail && Storage::disk('public')->exists($news->thumbnail))
                <img src="{{ asset('storage/' . $news->thumbnail) }}" alt="{{ $news->title }}" class="w-full h-48 object-cover">
            @else
                <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                    <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9.5a2.5 2.5 0 00-2.5-2.5H15" />
                    </svg>
                </div>
            @endif
            <div class="p-4">
                <h3 class="font-semibold text-gray-800 mb-2 line-clamp-2">{{ $news->title }}</h3>
                <p class="text-sm text-gray-500 mb-2">{{ $news->published_at ? $news->published_at->format('d F Y') : '-' }}</p>
                <p class="text-gray-600 text-sm line-clamp-3">{{ Str::limit(strip_tags($news->content), 100) }}</p>
            </div>
        </a>
        @endforeach
    </div>
    @else
    <div class="bg-gray-50 rounded-lg p-8 text-center">
        <p class="text-gray-500">Belum ada berita terbaru.</p>
    </div>
    @endif
</div>

<!-- Galeri Foto Section -->
<div class="container mx-auto px-4 py-8 bg-gray-50 rounded-lg my-4">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Galeri Foto</h2>
        <a href="{{ route('dip.index', ['category' => 'gallery']) }}" class="text-blue-600 hover:underline">Lihat Semua →</a>
    </div>
    
    @php
        $galleries = App\Models\News::where('type', 'gallery')->where('is_published', true)->latest('published_at')->take(6)->get();
    @endphp
    
    @if($galleries->count() > 0)
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-3">
        @foreach($galleries as $gallery)
        <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition cursor-pointer" onclick="openGalleryModal('{{ asset('storage/' . $gallery->thumbnail) }}', '{{ addslashes($gallery->title) }}')">
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

<!-- Gallery Modal -->
<div id="galleryModal" class="fixed inset-0 z-50 hidden bg-black bg-opacity-90 items-center justify-center" onclick="closeGalleryModal()">
    <div class="relative max-w-4xl w-full mx-4" onclick="event.stopPropagation()">
        <button onclick="closeGalleryModal()" class="absolute -top-10 right-0 text-white hover:text-gray-300 text-2xl">&times;</button>
        <img id="modalImage" src="" alt="" class="w-full rounded-lg shadow-2xl">
        <p id="modalCaption" class="text-center text-white mt-4"></p>
    </div>
</div>

<!-- Agenda Section -->
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Agenda Kegiatan</h2>
        <a href="{{ route('dip.index', ['category' => 'agenda']) }}" class="text-blue-600 hover:underline">Lihat Semua →</a>
    </div>
    
    @php
        $agendas = App\Models\News::where('type', 'agenda')->where('is_published', true)->where('event_date', '>=', now())->orderBy('event_date')->take(5)->get();
    @endphp
    
    @if($agendas->count() > 0)
    <div class="space-y-3">
        @foreach($agendas as $agenda)
        <a href="{{ route('dip.index', ['search' => $agenda->title]) }}" class="block bg-white rounded-lg p-4 shadow-sm hover:shadow-md transition border-l-4 border-blue-500">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
                <div class="flex-1">
                    <h3 class="font-semibold text-gray-800">{{ $agenda->title }}</h3>
                    <div class="flex flex-wrap gap-3 text-sm text-gray-500 mt-1">
                        <span class="flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            {{ \Carbon\Carbon::parse($agenda->event_date)->format('d F Y') }}
                        </span>
                        @if($agenda->location)
                        <span class="flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            {{ $agenda->location }}
                        </span>
                        @endif
                    </div>
                </div>
            </div>
        </a>
        @endforeach
    </div>
    @else
    <div class="bg-gray-50 rounded-lg p-8 text-center">
        <p class="text-gray-500">Belum ada agenda kegiatan terdekat.</p>
    </div>
    @endif
</div>

<script>
    function openGalleryModal(imageUrl, title) {
        const modal = document.getElementById('galleryModal');
        const modalImage = document.getElementById('modalImage');
        const modalCaption = document.getElementById('modalCaption');
        
        modalImage.src = imageUrl;
        modalCaption.textContent = title;
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        document.body.style.overflow = 'hidden';
    }

    function closeGalleryModal() {
        const modal = document.getElementById('galleryModal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        document.body.style.overflow = 'auto';
    }

    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            closeGalleryModal();
        }
    });
</script>
@endsection