@extends('layouts.dashboard')

@section('title', 'Hasil Laporan Statistik')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex justify-between items-start">
            <div>
                <div class="flex items-center space-x-2">
                    <a href="{{ route('pimpinan.laporan.index') }}" class="text-blue-600 hover:text-blue-800">
                        ← Kembali ke Form
                    </a>
                    <span class="text-gray-400">|</span>
                    <span class="text-gray-600">Hasil Laporan</span>
                </div>
                <h1 class="text-2xl font-bold text-gray-900 mt-2">Laporan Statistik Dokumen DIP</h1>
                <p class="text-sm text-gray-600 mt-1">OPD: {{ $data['opd_name'] }}</p>
                <p class="text-xs text-gray-500">Dibuat pada: {{ $data['generated_at']->format('d/m/Y H:i') }}</p>
            </div>
            <div class="flex space-x-2">
                <a href="{{ route('pimpinan.laporan.export-pdf') }}" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">
                    📄 Export PDF
                </a>
                <a href="{{ route('pimpinan.laporan.export-excel') }}" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">
                    📊 Export Excel
                </a>
            </div>
        </div>
    </div>

    <!-- Filter Info -->
    @if($data['period']['start'] || $data['period']['end'] || $data['year'])
    <div class="bg-blue-50 rounded-lg p-4 border border-blue-200">
        <p class="text-sm text-blue-800">
            <strong>Filter yang diterapkan:</strong>
            @if($data['period']['start']) Periode: {{ \Carbon\Carbon::parse($data['period']['start'])->format('d/m/Y') }} 
                @if($data['period']['end']) s.d. {{ \Carbon\Carbon::parse($data['period']['end'])->format('d/m/Y') }} @endif
            @endif
            @if($data['year']) | Tahun: {{ $data['year'] }} @endif
        </p>
    </div>
    @endif

    <!-- Statistik Cards -->
    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-blue-100 rounded-full p-3">
                    <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Total Dokumen</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ number_format($data['total_documents']) }}</p>
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
                    <p class="text-2xl font-semibold text-green-600">{{ number_format($data['published_documents']) }}</p>
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
                    <p class="text-2xl font-semibold text-yellow-600">{{ number_format($data['unpublished_documents']) }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-purple-100 rounded-full p-3">
                    <svg class="h-6 w-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Total Unduhan</p>
                    <p class="text-2xl font-semibold text-purple-600">{{ number_format($data['total_downloads']) }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Klasifikasi & Kategori Stats -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Klasifikasi Informasi</h3>
            <div class="space-y-3">
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600">Informasi Terbuka (Open)</span>
                    <span class="text-sm font-semibold text-green-600">{{ number_format($data['open_documents']) }}</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div class="bg-green-600 h-2 rounded-full" style="width: {{ $data['total_documents'] > 0 ? ($data['open_documents'] / $data['total_documents']) * 100 : 0 }}%"></div>
                </div>
                <div class="flex justify-between items-center mt-3">
                    <span class="text-sm text-gray-600">Informasi Dikecualikan (Excluded)</span>
                    <span class="text-sm font-semibold text-red-600">{{ number_format($data['excluded_documents']) }}</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div class="bg-red-600 h-2 rounded-full" style="width: {{ $data['total_documents'] > 0 ? ($data['excluded_documents'] / $data['total_documents']) * 100 : 0 }}%"></div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Statistik per Kategori Utama</h3>
            <div class="space-y-3">
                @foreach($data['category_stats'] as $stat)
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600">{{ $stat->name }}</span>
                    <span class="text-sm font-semibold text-gray-900">{{ number_format($stat->total) }}</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div class="bg-blue-600 h-2 rounded-full" style="width: {{ $data['total_documents'] > 0 ? ($stat->total / $data['total_documents']) * 100 : 0 }}%"></div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Monthly Trend Chart -->
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Tren Publikasi & Unduhan per Bulan</h3>
        @if($data['monthly_stats']->count() > 0)
        <canvas id="trendChart" class="w-full h-80"></canvas>
        @else
        <p class="text-center text-gray-500 py-8">Belum ada data publikasi dalam periode yang dipilih.</p>
        @endif
    </div>

    <!-- Top 10 Most Downloaded Documents -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">10 Dokumen Paling Banyak Diunduh</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">No</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Judul Dokumen</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Jumlah Unduhan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal Upload</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($data['top_documents'] as $index => $doc)
                    <tr>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ $index + 1 }}</td>
                        <td class="px-6 py-4 text-sm text-gray-900">{{ Str::limit($doc->title, 60) }}</td>
                        <td class="px-6 py-4 text-sm font-semibold text-purple-600">{{ number_format($doc->download_count) }}</td>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ \Carbon\Carbon::parse($doc->created_at)->format('d/m/Y') }}</td>
                    </tr>
                    @endforeach
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
    @if($data['monthly_stats']->count() > 0)
    const ctx = document.getElementById('trendChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: {!! json_encode($data['monthly_stats']->pluck('month')->map(function($m) { 
                return \Carbon\Carbon::createFromFormat('Y-m', $m)->format('M Y'); 
            })) !!},
            datasets: [
                {
                    label: 'Jumlah Publikasi',
                    data: {!! json_encode($data['monthly_stats']->pluck('total')) !!},
                    borderColor: 'rgb(59, 130, 246)',
                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
                    tension: 0.4,
                    fill: true,
                    yAxisID: 'y'
                },
                {
                    label: 'Jumlah Unduhan',
                    data: {!! json_encode($data['monthly_stats']->pluck('downloads')) !!},
                    borderColor: 'rgb(168, 85, 247)',
                    backgroundColor: 'rgba(168, 85, 247, 0.1)',
                    tension: 0.4,
                    fill: true,
                    yAxisID: 'y1'
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    position: 'top',
                },
                tooltip: {
                    mode: 'index',
                    intersect: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Jumlah Publikasi'
                    },
                    ticks: {
                        stepSize: 1
                    }
                },
                y1: {
                    beginAtZero: true,
                    position: 'right',
                    title: {
                        display: true,
                        text: 'Jumlah Unduhan'
                    },
                    ticks: {
                        stepSize: 1
                    },
                    grid: {
                        drawOnChartArea: false
                    }
                }
            }
        }
    });
    @endif
</script>
@endpush