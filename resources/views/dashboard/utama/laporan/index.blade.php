@extends('layouts.dashboard')

@section('title', 'Laporan Statistik DIP')

@section('content')
<div class="space-y-6">
    <div>
        <h1 class="text-2xl font-semibold text-gray-900">Laporan Statistik DIP</h1>
        <p class="mt-1 text-sm text-gray-600">Generate laporan dokumen informasi publik</p>
    </div>

    <div class="bg-white shadow rounded-lg p-6">
        <form method="POST" action="{{ route('utama.laporan.generate') }}" id="reportForm">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <!-- Filter OPD -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">OPD</label>
                    <select name="opd_id" class="w-full border-gray-300 rounded-md shadow-sm">
                        <option value="">Semua OPD</option>
                        @foreach($opds as $opd)
                            <option value="{{ $opd->id }}">{{ $opd->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Filter Tahun -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tahun</label>
                    <select name="year" class="w-full border-gray-300 rounded-md shadow-sm">
                        <option value="">Semua Tahun</option>
                        @foreach($years as $year)
                            <option value="{{ $year }}">{{ $year }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Filter Tanggal Mulai -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Mulai</label>
                    <input type="date" name="start_date" class="w-full border-gray-300 rounded-md shadow-sm">
                </div>

                <!-- Filter Tanggal Akhir -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Akhir</label>
                    <input type="date" name="end_date" class="w-full border-gray-300 rounded-md shadow-sm">
                </div>
            </div>

            <div class="mt-6 flex justify-end space-x-3">
                <button type="submit" name="format" value="pdf" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">
                    <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                    </svg>
                    Export PDF
                </button>
                <button type="submit" name="format" value="excel" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">
                    <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    Export Excel
                </button>
            </div>
        </form>
    </div>

    <!-- Informasi -->
    <div class="bg-blue-50 rounded-lg p-4">
        <div class="flex">
            <svg class="h-5 w-5 text-blue-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <div class="text-sm text-blue-700">
                <p class="font-medium">Informasi Laporan</p>
                <p>Laporan akan mencakup data dokumen yang dipublikasikan. Filter dapat dikombinasikan untuk hasil yang lebih spesifik.</p>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('reportForm').addEventListener('submit', function(e) {
        const startDate = document.querySelector('[name="start_date"]').value;
        const endDate = document.querySelector('[name="end_date"]').value;
        
        if (startDate && endDate && startDate > endDate) {
            e.preventDefault();
            alert('Tanggal mulai tidak boleh lebih besar dari tanggal akhir');
        }
    });
</script>
@endsection