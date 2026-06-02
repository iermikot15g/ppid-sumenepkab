@extends('layouts.dashboard')

@section('title', 'Dashboard Monitoring - Pimpinan OPD')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Dashboard Monitoring</h1>
                <p class="mt-1 text-sm text-gray-600">
                    Selamat datang, <span class="font-semibold">{{ auth()->user()->name }}</span>
                </p>
                <p class="text-sm text-gray-600">
                    OPD: <span class="font-semibold text-maroon-600">{{ $opd->name }}</span>
                </p>
            </div>
            <div class="text-right">
                <p class="text-sm text-gray-500">Terakhir diperbarui</p>
                <p class="text-sm font-semibold">{{ now()->format('d/m/Y H:i') }}</p>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-maroon-100 rounded-full p-3">
                    <svg class="h-6 w-6 text-maroon-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Total Dokumen</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ number_format($totalDocuments) }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-green-100 rounded-full p-3">
                    <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Dipublikasikan</p>
                    <p class="text-2xl font-semibold text-green-600">{{ number_format($publishedDocuments) }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-yellow-100 rounded-full p-3">
                    <svg class="h-6 w-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Belum Dipublikasi</p>
                    <p class="text-2xl font-semibold text-yellow-600">{{ number_format($unpublishedDocuments) }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-red-100 rounded-full p-3">
                    <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Force Unpublish</p>
                    <p class="text-2xl font-semibold text-red-600">{{ number_format($forceUnpublishedDocuments) }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Second Row Stats -->
    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Klasifikasi Informasi</h3>
            <div class="space-y-3">
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600">Informasi Terbuka (Open)</span>
                    <span class="text-sm font-semibold text-green-600">{{ number_format($openDocuments) }}</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div class="bg-green-600 h-2 rounded-full" style="width: {{ $totalDocuments > 0 ? ($openDocuments / $totalDocuments) * 100 : 0 }}%"></div>
                </div>
                <div class="flex justify-between items-center mt-3">
                    <span class="text-sm text-gray-600">Informasi Dikecualikan (Excluded)</span>
                    <span class="text-sm font-semibold text-red-600">{{ number_format($excludedDocuments) }}</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div class="bg-red-600 h-2 rounded-full" style="width: {{ $totalDocuments > 0 ? ($excludedDocuments / $totalDocuments) * 100 : 0 }}%"></div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Statistik per Kategori Utama</h3>
            <div class="space-y-3">
                @foreach($categoryStats as $stat)
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600">{{ $stat->name }}</span>
                    <span class="text-sm font-semibold text-gray-900">{{ number_format($stat->total) }}</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div class="bg-maroon-600 h-2 rounded-full" style="width: {{ $totalDocuments > 0 ? ($stat->total / $totalDocuments) * 100 : 0 }}%"></div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Monthly Trend Chart -->
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Tren Publikasi 6 Bulan Terakhir</h3>
        @if($monthlyStats->count() > 0)
        <canvas id="trendChart" class="w-full h-64"></canvas>
        @else
        <p class="text-center text-gray-500 py-8">Belum ada data publikasi dalam 6 bulan terakhir.</p>
        @endif
    </div>

    <!-- Recent Documents -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
            <h3 class="text-lg font-medium text-gray-900">Dokumen Terbaru</h3>
            <a href="{{ route('pimpinan.documents.index') }}" class="text-sm text-maroon-600 hover:text-maroon-800">Lihat semua →</a>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Judul</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kategori</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Unduhan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($recentDocuments as $document)
                    <tr>
                        <td class="px-6 py-4 text-sm text-gray-900">{{ Str::limit($document->title, 50) }}</td>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ $document->category->name ?? '-' }}</td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 text-xs rounded-full 
                                {{ $document->status === 'published' ? 'bg-green-100 text-green-800' : 
                                   ($document->status === 'archived' ? 'bg-gray-100 text-gray-800' : 'bg-yellow-100 text-yellow-800') }}">
                                {{ ucfirst($document->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ number_format($document->download_count) }}</td>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ $document->created_at->format('d/m/Y') }}</td>
                        <td class="px-6 py-4 text-right text-sm">
                            <a href="{{ route('pimpinan.documents.show', $document) }}" class="text-maroon-600 hover:text-blue-900">Detail</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">Belum ada dokumen.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Most Downloaded Documents -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">5 Dokumen Paling Banyak Diunduh</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Judul</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Unduhan</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($mostDownloaded as $document)
                    <tr>
                        <td class="px-6 py-4 text-sm text-gray-900">{{ Str::limit($document->title, 60) }}</td>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ number_format($document->download_count) }} kali</td>
                        <td class="px-6 py-4 text-right text-sm">
                            <a href="{{ route('pimpinan.documents.show', $document) }}" class="text-maroon-600 hover:text-blue-900">Detail</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="px-6 py-4 text-center text-gray-500">Belum ada data unduhan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('styles')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endpush

@push('scripts')
<script>
    // Chart untuk tren publikasi
    @if($monthlyStats->count() > 0)
    const ctx = document.getElementById('trendChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: {!! json_encode($monthlyStats->pluck('month')->map(function($m) { 
                return \Carbon\Carbon::createFromFormat('Y-m', $m)->format('M Y'); 
            })) !!},
            datasets: [{
                label: 'Jumlah Publikasi',
                data: {!! json_encode($monthlyStats->pluck('total')) !!},
                borderColor: '#c41e3a',
                backgroundColor: 'rgba(196, 30, 58, 0.1)',
                tension: 0.4,
                fill: true
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    position: 'top',
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });
    @endif
</script>
@endpush