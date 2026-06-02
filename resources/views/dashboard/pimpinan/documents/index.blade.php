@extends('layouts.dashboard')

@section('title', 'Manajemen Dokumen - Pimpinan OPD')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Manajemen Dokumen</h1>
                <p class="mt-1 text-sm text-gray-600">
                    Menampilkan semua dokumen DIP milik OPD {{ auth()->user()->opd->name }}
                </p>
                <p class="text-xs text-gray-500 mt-1">*Mode Baca Saja - Anda tidak dapat menambah/mengubah data</p>
            </div>
        </div>
    </div>

    <!-- Filter Form -->
    <div class="bg-white rounded-lg shadow p-6">
        <form method="GET" action="{{ route('pimpinan.documents.index') }}" class="grid grid-cols-1 md:grid-cols-5 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Cari</label>
                <input type="text" name="search" value="{{ request('search') }}" 
                       placeholder="Judul atau deskripsi..."
                       class="w-full rounded-md border-gray-300 shadow-sm focus:border-maroon-500 focus:ring-maroon-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                <select name="status" class="w-full rounded-md border-gray-300 shadow-sm focus:border-maroon-500 focus:ring-maroon-500">
                    <option value="">Semua</option>
                    <option value="published" {{ request('status') == 'published' ? 'selected' : '' }}>Published</option>
                    <option value="unpublished" {{ request('status') == 'unpublished' ? 'selected' : '' }}>Unpublished</option>
                    <option value="archived" {{ request('status') == 'archived' ? 'selected' : '' }}>Archived</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Klasifikasi</label>
                <select name="classification" class="w-full rounded-md border-gray-300 shadow-sm focus:border-maroon-500 focus:ring-maroon-500">
                    <option value="">Semua</option>
                    <option value="open" {{ request('classification') == 'open' ? 'selected' : '' }}>Terbuka</option>
                    <option value="excluded" {{ request('classification') == 'excluded' ? 'selected' : '' }}>Dikecualikan</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                <select name="category_id" class="w-full rounded-md border-gray-300 shadow-sm focus:border-maroon-500 focus:ring-maroon-500">
                    <option value="">Semua</option>
                    @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Tahun</label>
                <select name="year" class="w-full rounded-md border-gray-300 shadow-sm focus:border-maroon-500 focus:ring-maroon-500">
                    <option value="">Semua</option>
                    @foreach($years as $year)
                    <option value="{{ $year }}" {{ request('year') == $year ? 'selected' : '' }}>{{ $year }}</option>
                    @endforeach
                </select>
            </div>
            <div class="md:col-span-5 flex justify-end space-x-2">
                <button type="submit" class="px-4 py-2 bg-maroon-600 text-white rounded-md hover:bg-maroon-700">
                    Filter
                </button>
                <a href="{{ route('pimpinan.documents.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600">
                    Reset
                </a>
            </div>
        </form>
    </div>

    <!-- Documents Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Judul</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kategori</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Klasifikasi</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tahun</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Unduhan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($documents as $document)
                    <tr>
                        <td class="px-6 py-4 text-sm text-gray-900">{{ Str::limit($document->title, 60) }}</td>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ $document->category->name ?? '-' }}</td>
                        <td class="px-6 py-4">
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
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 text-xs rounded-full {{ $document->classification === 'open' ? 'bg-maroon-100 text-maroon-800' : 'bg-purple-100 text-purple-800' }}">
                                {{ $document->classification === 'open' ? 'Terbuka' : 'Dikecualikan' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ $document->year }}</td>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ number_format($document->download_count) }}</td>
                        <td class="px-6 py-4 text-sm">
                            <div class="flex space-x-2">
                                <a href="{{ route('pimpinan.documents.show', $document) }}" class="text-maroon-600 hover:text-blue-900">
                                    Detail
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-8 text-center text-gray-500">
                            Tidak ada dokumen yang ditemukan.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $documents->links() }}
        </div>
    </div>
</div>
@endsection