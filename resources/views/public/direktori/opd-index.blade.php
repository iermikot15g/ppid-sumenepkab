@extends('layouts.app')

@section('title', 'Direktori PPID Pembantu')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-8">
        <h1 class="text-2xl md:text-3xl font-bold text-blue-900">PPID Pembantu</h1>
        <p class="text-gray-600 mt-2">Daftar Organisasi Perangkat Daerah (OPD) di Kabupaten Sumenep</p>
    </div>

    <!-- Search -->
    <div class="mb-6">
        <form method="GET" action="{{ route('direktori.opd') }}" class="max-w-md">
            <div class="flex gap-2">
                <input type="text" name="search" placeholder="Cari OPD..." 
                       value="{{ request('search') }}"
                       class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    Cari
                </button>
            </div>
        </form>
    </div>

    <!-- OPD Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($opds as $opd)
        <a href="{{ route('direktori.opd.show', $opd) }}" class="block bg-white rounded-lg shadow-md hover:shadow-lg transition">
            <div class="p-4">
                <div class="flex items-start gap-3">
                    @if($opd->logo)
                        <img src="{{ Storage::url($opd->logo) }}" alt="{{ $opd->name }}" class="w-12 h-12 object-cover rounded-lg">
                    @else
                        <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                        </div>
                    @endif
                    <div class="flex-1">
                        <h3 class="font-semibold text-gray-900">{{ $opd->name }}</h3>
                        <p class="text-sm text-gray-500">{{ $opd->short_name ?? '' }}</p>
                        <p class="text-xs text-gray-400 mt-1">{{ $opd->documents_count }} dokumen</p>
                    </div>
                </div>
            </div>
        </a>
        @empty
        <div class="col-span-full text-center py-12">
            <p class="text-gray-500">Belum ada data OPD.</p>
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="mt-8">
        {{ $opds->withQueryString()->links() }}
    </div>
</div>
@endsection