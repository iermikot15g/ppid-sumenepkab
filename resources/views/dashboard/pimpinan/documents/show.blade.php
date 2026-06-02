@extends('layouts.dashboard')

@section('title', 'Detail Dokumen - ' . $document->title)

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex justify-between items-start">
            <div>
                <div class="flex items-center space-x-2">
                    <a href="{{ route('pimpinan.documents.index') }}" class="text-maroon-600 hover:text-maroon-800">
                        ← Kembali ke Daftar
                    </a>
                    <span class="text-gray-400">|</span>
                    <span class="text-gray-600">Detail Dokumen</span>
                </div>
                <h1 class="text-2xl font-bold text-gray-900 mt-2">{{ $document->title }}</h1>
                <p class="text-sm text-gray-500 mt-1">
                    OPD: {{ $document->opd->name }}
                </p>
            </div>
            <div class="text-right">
                <p class="text-xs text-gray-500">Status</p>
                <span class="px-2 py-1 text-xs rounded-full 
                    {{ $document->status === 'published' ? 'bg-green-100 text-green-800' : 
                       ($document->status === 'archived' ? 'bg-gray-100 text-gray-800' : 'bg-yellow-100 text-yellow-800') }}">
                    {{ ucfirst($document->status) }}
                </span>
                @if($document->force_unpublished_by)
                <span class="ml-1 px-2 py-1 text-xs rounded-full bg-red-100 text-red-800">
                    Force Unpublish
                </span>
                @endif
            </div>
        </div>
    </div>

    <!-- Document Info & Preview -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Info Panel -->
        <div class="lg:col-span-1 space-y-6">
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Informasi Dokumen</h3>
                <dl class="space-y-3">
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Nomor Dokumen</dt>
                        <dd class="text-sm text-gray-900">{{ $document->doc_number ?? '-' }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Tahun</dt>
                        <dd class="text-sm text-gray-900">{{ $document->year }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Kategori Utama</dt>
                        <dd class="text-sm text-gray-900">{{ $document->category->name ?? '-' }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Sub Kategori</dt>
                        <dd class="text-sm text-gray-900">{{ $document->subCategory->name ?? '-' }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Klasifikasi</dt>
                        <dd class="text-sm text-gray-900">{{ $document->classification === 'open' ? 'Informasi Terbuka' : 'Informasi Dikecualikan' }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Jumlah Unduhan</dt>
                        <dd class="text-sm text-gray-900">{{ number_format($document->download_count) }} kali</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Ukuran File</dt>
                        <dd class="text-sm text-gray-900">{{ number_format($document->file_size / 1024, 2) }} KB</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Tanggal Upload</dt>
                        <dd class="text-sm text-gray-900">{{ $document->created_at->format('d/m/Y H:i') }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Terakhir Diubah</dt>
                        <dd class="text-sm text-gray-900">{{ $document->updated_at->format('d/m/Y H:i') }}</dd>
                    </div>
                    @if($document->force_unpublished_by)
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Alasan Force Unpublish</dt>
                        <dd class="text-sm text-red-600">{{ $document->force_unpublished_reason }}</dd>
                    </div>
                    @endif
                </dl>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Deskripsi</h3>
                <p class="text-sm text-gray-700">{{ $document->description ?? 'Tidak ada deskripsi.' }}</p>
            </div>
        </div>

        <!-- Preview Panel -->
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-medium text-gray-900">Preview Dokumen</h3>
                    <a href="{{ route('pimpinan.documents.preview', $document) }}" target="_blank" class="px-4 py-2 bg-maroon-600 text-white rounded-md hover:bg-maroon-700">
                        Buka di Tab Baru
                    </a>
                </div>
                <div class="border rounded-lg overflow-hidden" style="height: 600px;">
                    <iframe src="{{ route('pimpinan.documents.preview', $document) }}" 
                            class="w-full h-full" 
                            frameborder="0">
                    </iframe>
                </div>
            </div>
        </div>
    </div>

    <!-- Audit Log -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">Riwayat Aktivitas Dokumen</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Pengguna</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Keterangan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Waktu</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($logs as $log)
                    <tr>
                        <td class="px-6 py-4 text-sm">
                            <span class="px-2 py-1 text-xs rounded-full 
                                {{ $log->action === 'force_unpublish' ? 'bg-red-100 text-red-800' : 
                                   ($log->action === 'publish' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800') }}">
                                {{ str_replace('_', ' ', ucfirst($log->action)) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-900">{{ $log->user->name }}</td>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ $log->notes ?? '-' }}</td>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ $log->created_at->format('d/m/Y H:i') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-4 text-center text-gray-500">Belum ada riwayat aktivitas.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection