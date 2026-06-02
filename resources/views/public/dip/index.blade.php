@extends('layouts.app')

@section('title', 'Daftar Informasi Publik')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-2xl md:text-3xl font-bold text-blue-900">Daftar Informasi Publik</h1>
        <p class="text-gray-600 mt-2">Temukan dokumen informasi publik yang tersedia</p>
    </div>

    <!-- Filter Section -->
    <div class="bg-gray-50 rounded-lg p-4 mb-6">
        <form method="GET" action="{{ route('dip.index') }}" class="flex flex-col md:flex-row gap-4">
            <!-- Search Input -->
            <div class="flex-1">
                <input type="text" name="search" placeholder="Cari judul atau deskripsi..." 
                       value="{{ request('search') }}"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-maroon-500 focus:border-maroon-500">
            </div>
            
            <!-- Filter OPD -->
            <div class="w-full md:w-64">
                <select name="opd" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-maroon-500 focus:border-maroon-500">
                    <option value="">Semua OPD</option>
                    @foreach($opds as $opd)
                        <option value="{{ $opd->id }}" {{ request('opd') == $opd->id ? 'selected' : '' }}>
                            {{ $opd->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            
            <!-- Filter Tahun -->
            <div class="w-full md:w-32">
                <select name="year" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-maroon-500 focus:border-maroon-500">
                    <option value="">Semua Tahun</option>
                    @foreach($years as $year)
                        <option value="{{ $year }}" {{ request('year') == $year ? 'selected' : '' }}>{{ $year }}</option>
                    @endforeach
                </select>
            </div>
            
            <!-- Submit Button -->
            <button type="submit" class="px-6 py-2 bg-maroon-600 text-white rounded-lg hover:bg-maroon-700 transition">
                Cari
            </button>
            
            <!-- Reset Button -->
            @if(request()->anyFilled(['search', 'opd', 'year']))
                <a href="{{ route('dip.index') }}" class="px-6 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition text-center">
                    Reset
                </a>
            @endif
        </form>
    </div>

    <!-- Category Tabs -->
    <div class="border-b border-gray-200 mb-6 overflow-x-auto">
        <nav class="flex space-x-4">
            <a href="{{ route('dip.index', array_merge(request()->except('category'), ['category' => 'all'])) }}" 
               class="py-2 px-3 border-b-2 whitespace-nowrap {{ (request('category', 'all') == 'all') ? 'border-maroon-500 text-maroon-600' : 'border-transparent text-gray-500 hover:text-gray-700' }}">
                Semua
            </a>
            @foreach($categories as $category)
            <a href="{{ route('dip.index', array_merge(request()->except('category'), ['category' => $category->slug])) }}" 
               class="py-2 px-3 border-b-2 whitespace-nowrap {{ (request('category') == $category->slug) ? 'border-maroon-500 text-maroon-600' : 'border-transparent text-gray-500 hover:text-gray-700' }}">
                {{ $category->name }}
            </a>
            @endforeach
        </nav>
    </div>

    <!-- Results Count -->
    <div class="mb-4 text-sm text-gray-500">
        Menampilkan {{ $documents->firstItem() ?? 0 }} - {{ $documents->lastItem() ?? 0 }} dari {{ $documents->total() }} dokumen
    </div>

    <!-- Document Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($documents as $document)
        <div class="bg-white rounded-lg shadow-md hover:shadow-lg transition overflow-hidden">
            <div class="p-4">
                <div class="flex items-start justify-between gap-2">
                    <h3 class="font-semibold text-gray-900 line-clamp-2 flex-1">{{ $document->title }}</h3>
                    <span class="px-2 py-1 text-xs rounded-full whitespace-nowrap {{ $document->classification === 'open' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                        {{ $document->classification === 'open' ? 'Terbuka' : 'Dikecualikan' }}
                    </span>
                </div>
                
                <p class="text-xs text-gray-500 mt-2">
                    {{ $document->opd->name }} • {{ $document->year }}
                </p>
                
                <p class="text-sm text-gray-600 mt-2 line-clamp-3">
                    {{ $document->description ?? 'Tidak ada deskripsi' }}
                </p>
                
                <div class="flex items-center justify-between mt-4 pt-3 border-t border-gray-100">
                    <span class="text-xs text-gray-400">
                        {{ $document->created_at->format('d/m/Y') }}
                    </span>
                    
                    <div class="flex gap-2">
                        <!-- Preview Button -->
                        <button onclick="previewDocument({{ $document->id }})" 
                                class="text-maroon-600 hover:text-maroon-800 text-sm font-medium">
                            Preview
                        </button>
                        
                        <!-- Download Button -->
                        @if($document->classification === 'open')
                            @auth
                                <a href="{{ route('dip.download', $document) }}" 
                                   class="text-green-600 hover:text-green-800 text-sm font-medium">
                                    Unduh
                                </a>
                            @else
                                <a href="{{ route('login') }}" 
                                   class="text-gray-500 hover:text-gray-700 text-sm font-medium">
                                    Login to Download
                                </a>
                            @endauth
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-full text-center py-12">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
            <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ada dokumen</h3>
            <p class="mt-1 text-sm text-gray-500">Belum ada dokumen yang dipublikasikan.</p>
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="mt-8">
        {{ $documents->withQueryString()->links() }}
    </div>
</div>

<!-- Preview Modal -->
<div id="previewModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" onclick="closePreview()"></div>
        
        <div class="relative bg-white rounded-lg shadow-xl max-w-4xl w-full max-h-[90vh] overflow-hidden">
            <div class="flex justify-between items-center px-6 py-4 border-b border-gray-200">
                <h3 id="modalTitle" class="text-lg font-semibold text-gray-900">Preview Dokumen</h3>
                <button onclick="closePreview()" class="text-gray-400 hover:text-gray-500">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <div class="p-6 overflow-y-auto" style="max-height: calc(90vh - 80px);">
                <div id="modalContent">
                    <div class="text-center py-8">
                        <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600 mx-auto"></div>
                        <p class="mt-4 text-gray-600">Memuat preview...</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // ========== PREVIEW DOKUMEN ==========
    function previewDocument(id) {
        const modal = document.getElementById('previewModal');
        const modalContent = document.getElementById('modalContent');
        
        modal.classList.remove('hidden');
        modalContent.innerHTML = '<div class="text-center py-8"><div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600 mx-auto"></div><p class="mt-4 text-gray-600">Memuat preview...</p></div>';
        
        fetch(`/dip/preview/${id}`)
            .then(response => {
                if (response.status === 401) {
                    return response.json().then(data => {
                        throw { type: 'login_required', message: data.message, login_url: data.login_url };
                    });
                }
                return response.json();
            })
            .then(data => {
                // Cek apakah perlu login
                if (data.error === 'login_required') {
                    modalContent.innerHTML = `
                        <div class="text-center py-8">
                            <svg class="mx-auto h-16 w-16 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                            <h3 class="mt-4 text-lg font-semibold text-gray-900">Login Diperlukan</h3>
                            <p class="mt-2 text-gray-600">${data.message || 'Silakan login terlebih dahulu untuk melihat preview dokumen.'}</p>
                            <div class="mt-6 flex justify-center gap-3">
                                <a href="${data.login_url}" class="px-4 py-2 bg-maroon-600 text-white rounded-lg hover:bg-maroon-700">Login</a>
                                <a href="/register" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">Daftar</a>
                            </div>
                        </div>
                    `;
                    return;
                }
                
                // Tampilkan preview untuk user yang login
                modalContent.innerHTML = `
                    <div class="space-y-4">
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <p class="text-sm text-gray-600"><strong>Judul:</strong> ${data.title}</p>
                            <p class="text-sm text-gray-600"><strong>OPD:</strong> ${data.opd}</p>
                            <p class="text-sm text-gray-600"><strong>Tahun:</strong> ${data.year}</p>
                            <p class="text-sm text-gray-600"><strong>Kategori:</strong> ${data.category}</p>
                            <p class="text-sm text-gray-600 mt-2"><strong>Deskripsi:</strong></p>
                            <p class="text-sm text-gray-600">${data.description || 'Tidak ada deskripsi'}</p>
                        </div>
                        <div>
                            <iframe src="${data.file_url}" class="w-full h-96 border border-gray-200 rounded-lg" title="Preview Dokumen"></iframe>
                            <p class="text-xs text-gray-400 text-center mt-2">*PDF dapat dilihat di sini. Untuk mengunduh, silakan gunakan tombol Unduh di halaman utama.</p>
                        </div>
                    </div>
                `;
            })
            .catch(error => {
                if (error.type === 'login_required') {
                    modalContent.innerHTML = `
                        <div class="text-center py-8">
                            <svg class="mx-auto h-16 w-16 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                            <h3 class="mt-4 text-lg font-semibold text-gray-900">Login Diperlukan</h3>
                            <p class="mt-2 text-gray-600">${error.message}</p>
                            <div class="mt-6 flex justify-center gap-3">
                                <a href="${error.login_url}" class="px-4 py-2 bg-maroon-600 text-white rounded-lg hover:bg-maroon-700">Login</a>
                                <a href="/register" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">Daftar</a>
                            </div>
                        </div>
                    `;
                } else {
                    modalContent.innerHTML = `<div class="text-center py-8 text-red-600">Gagal memuat preview: ${error.message || 'Terjadi kesalahan'}</div>`;
                }
            });
    }

    function closePreview() {
        document.getElementById('previewModal').classList.add('hidden');
    }
    
    // Close modal with Escape key
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            closePreview();
        }
    });
</script>
@endsection