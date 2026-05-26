@extends('layouts.app')

@section('title', 'Direktori PPID Desa')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-8">
        <h1 class="text-2xl md:text-3xl font-bold text-blue-900">PPID Desa</h1>
        <p class="text-gray-600 mt-2">Daftar desa di Kabupaten Sumenep</p>
    </div>

    <!-- Search -->
    <div class="mb-6">
        <form method="GET" action="{{ route('direktori.desa') }}" class="max-w-md">
            <div class="flex gap-2">
                <input type="text" name="search" placeholder="Cari desa..." 
                       value="{{ request('search') }}"
                       class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    Cari
                </button>
            </div>
        </form>
    </div>

    <!-- Village Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($villages as $village)
        <div class="bg-white rounded-lg shadow-md hover:shadow-lg transition">
            <div class="p-4">
                <div class="flex items-start gap-3">
                    @if($village->logo && Storage::disk('public')->exists($village->logo))
                        <img src="{{ Storage::url($village->logo) }}" alt="{{ $village->name }}" class="w-12 h-12 object-cover rounded-lg">
                    @else
                        <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                            </svg>
                        </div>
                    @endif
                    <div class="flex-1">
                        <h3 class="font-semibold text-gray-900">{{ $village->name }}</h3>
                        @if($village->head_name)
                            <p class="text-sm text-gray-500">Kepala Desa: {{ $village->head_name }}</p>
                        @endif
                        @if($village->phone || $village->email)
                            <div class="mt-2 text-xs text-gray-400">
                                @if($village->phone)<p>📞 {{ $village->phone }}</p>@endif
                                @if($village->email)<p>✉️ {{ $village->email }}</p>@endif
                            </div>
                        @endif
                    </div>
                </div>
                @if($village->address)
                    <div class="mt-3 pt-3 border-t border-gray-100 text-sm text-gray-500">
                        <p>📍 {{ $village->address }}</p>
                    </div>
                @endif
            </div>
        </div>
        @empty
        <div class="col-span-full text-center py-12">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
            </svg>
            <p class="mt-2 text-gray-500">Belum ada data desa.</p>
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="mt-8">
        {{ $villages->withQueryString()->links() }}
    </div>
</div>
@endsection