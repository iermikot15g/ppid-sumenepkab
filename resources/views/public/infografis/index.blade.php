@extends('layouts.app')

@section('title', 'Infografis - PPID Kabupaten Sumenep')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- ============================================================ -->
    <!-- HEADER HALAMAN INFOGRAFIS                                    -->
    <!-- ============================================================ -->
    <div class="mb-8">
        <h1 class="text-2xl md:text-3xl font-bold text-blue-900">Infografis</h1>
        <p class="text-gray-600 mt-2">Kumpulan infografis informasi publik Kabupaten Sumenep</p>
    </div>

    <!-- ============================================================ -->
    <!-- BREADCRUMB NAVIGASI                                          -->
    <!-- ============================================================ -->
    <div class="text-sm text-gray-500 mb-4">
        <a href="{{ route('home') }}" class="hover:text-maroon-600">Beranda</a> / 
        <span class="text-gray-700">Infografis</span>
    </div>

    <!-- ============================================================ -->
    <!-- INFOGRAFIS GRID - 4 kolom                                    -->
    <!-- ============================================================ -->
    @if($infografis->count() > 0)
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @foreach($infografis as $item)
        <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition group cursor-pointer" 
             onclick="openInfografisModal('{{ asset('storage/' . $item->thumbnail) }}', '{{ addslashes($item->title) }}')">
            <!-- Thumbnail infografis -->
            @if($item->thumbnail && Storage::disk('public')->exists($item->thumbnail))
                <img src="{{ asset('storage/' . $item->thumbnail) }}" alt="{{ $item->title }}" 
                     class="w-full h-56 object-cover group-hover:scale-105 transition duration-300">
            @else
                <div class="w-full h-56 bg-gray-200 flex items-center justify-center">
                    <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
            @endif
            <div class="p-3 bg-white">
                <h3 class="font-semibold text-gray-800 text-sm line-clamp-2">{{ $item->title }}</h3>
                <p class="text-xs text-gray-500 mt-1">{{ $item->published_at ? $item->published_at->format('d/m/Y') : '-' }}</p>
            </div>
        </div>
        @endforeach
    </div>

    <!-- ============================================================ -->
    <!-- PAGINATION                                                   -->
    <!-- ============================================================ -->
    <div class="mt-8">
        {{ $infografis->links() }}
    </div>
    @else
    <!-- Empty state jika belum ada infografis -->
    <div class="bg-gray-50 rounded-lg p-12 text-center">
        <svg class="mx-auto h-16 w-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
        </svg>
        <p class="mt-4 text-gray-500">Belum ada infografis yang dipublikasikan.</p>
    </div>
    @endif
</div>

<!-- ============================================================ -->
<!-- INFOGRAFIS MODAL - Preview gambar (ukuran menyesuaikan)      -->
<!-- ============================================================ -->
<div id="infografisModal" class="fixed inset-0 z-50 hidden bg-black bg-opacity-90 items-center justify-center p-4" onclick="closeInfografisModal()">
    <div class="relative max-w-full max-h-full" onclick="event.stopPropagation()">
        <!-- Tombol close di pojok kanan atas -->
        <button onclick="closeInfografisModal()" class="absolute -top-12 right-0 text-white hover:text-gray-300 text-3xl z-10">
            &times;
        </button>
        
        <!-- Container gambar dengan max-height 90vh dan max-width 90vw -->
        <div class="flex items-center justify-center">
            <img id="infografisModalImage" src="" alt="" 
                 class="max-w-[90vw] max-h-[90vh] w-auto h-auto object-contain rounded-lg shadow-2xl">
        </div>
        
        <!-- Caption di bawah gambar -->
        <p id="infografisModalCaption" class="text-center text-white mt-4 text-sm"></p>
    </div>
</div>

<script>
    // ================================================================
    // INFOGRAFIS MODAL - Preview gambar dengan ukuran menyesuaikan
    // ================================================================
    function openInfografisModal(imageUrl, title) {
        const modal = document.getElementById('infografisModal');
        const modalImage = document.getElementById('infografisModalImage');
        const modalCaption = document.getElementById('infografisModalCaption');
        
        // Set gambar dan caption
        modalImage.src = imageUrl;
        modalCaption.textContent = title;
        
        // Tampilkan modal
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        
        // Nonaktifkan scroll pada body
        document.body.style.overflow = 'hidden';
    }

    function closeInfografisModal() {
        const modal = document.getElementById('infografisModal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        document.body.style.overflow = 'auto';
    }

    // Tutup modal dengan tombol Escape
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            closeInfografisModal();
        }
    });
</script>
@endsection