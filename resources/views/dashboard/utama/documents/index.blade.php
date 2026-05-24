@extends('layouts.dashboard')

@section('title', 'Manajemen Dokumen Global')

@section('content')
<div class="space-y-6">
    <div>
        <h1 class="text-2xl font-semibold text-gray-900">Manajemen Dokumen Global</h1>
        <p class="mt-1 text-sm text-gray-600">Kelola semua dokumen dari seluruh OPD</p>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded">
            {{ session('success') }}
        </div>
    @endif

    <!-- Filter -->
    <div class="bg-white shadow rounded-lg p-4">
        <form method="GET" class="flex flex-wrap gap-4">
            <div class="flex-1 min-w-[200px]">
                <input type="text" name="search" placeholder="Cari judul dokumen..." 
                       value="{{ request('search') }}"
                       class="w-full px-3 py-2 border border-gray-300 rounded-md">
            </div>
            <div class="w-64">
                <select name="opd_id" class="w-full px-3 py-2 border border-gray-300 rounded-md">
                    <option value="">Semua OPD</option>
                    @foreach($opds as $opd)
                        <option value="{{ $opd->id }}" {{ request('opd_id') == $opd->id ? 'selected' : '' }}>
                            {{ $opd->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="w-40">
                <select name="status" class="w-full px-3 py-2 border border-gray-300 rounded-md">
                    <option value="">Semua Status</option>
                    <option value="published" {{ request('status') == 'published' ? 'selected' : '' }}>Published</option>
                    <option value="unpublished" {{ request('status') == 'unpublished' ? 'selected' : '' }}>Unpublished</option>
                    <option value="archived" {{ request('status') == 'archived' ? 'selected' : '' }}>Archived</option>
                </select>
            </div>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">Filter</button>
            <a href="{{ route('utama.documents.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600">Reset</a>
        </form>
    </div>

    <!-- Tabel Dokumen -->
    <div class="bg-white shadow rounded-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Judul</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">OPD</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kategori</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Klasifikasi</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Upload Oleh</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($documents as $doc)
                    <tr>
                        <td class="px-6 py-4 text-sm text-gray-900">{{ Str::limit($doc->title, 50) }}</td>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ $doc->opd->name ?? '-' }}</td>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ $doc->category->name ?? '-' }}</td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 text-xs rounded-full {{ $doc->classification === 'open' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $doc->classification === 'open' ? 'Terbuka' : 'Dikecualikan' }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 text-xs rounded-full 
                                {{ $doc->status === 'published' ? 'bg-green-100 text-green-800' : 
                                   ($doc->status === 'archived' ? 'bg-gray-100 text-gray-800' : 'bg-yellow-100 text-yellow-800') }}">
                                {{ ucfirst($doc->status) }}
                            </span>
                            @if($doc->force_unpublished_by)
                                <span class="ml-1 px-1 py-0.5 text-xs rounded-full bg-red-100 text-red-800">Force Unpublish</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ $doc->creator->name ?? '-' }}</td>
                        <td class="px-6 py-4 text-right text-sm">
                            <button onclick="forceUnpublish({{ $doc->id }}, '{{ addslashes($doc->title) }}')" 
                                    class="text-orange-600 hover:text-orange-900 mr-3 {{ $doc->status === 'unpublished' ? 'opacity-50 cursor-not-allowed' : '' }}"
                                    {{ $doc->status === 'unpublished' ? 'disabled' : '' }}>
                                Force Unpublish
                            </button>
                            <a href="{{ route('utama.documents.edit', $doc) }}" class="text-blue-600 hover:text-blue-900 mr-3">Edit</a>
                            <button onclick="deleteDocument({{ $doc->id }})" class="text-red-600 hover:text-red-900">Hapus</button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-4 text-center text-gray-500">Belum ada dokumen</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4">
            {{ $documents->links() }}
        </div>
    </div>
</div>

<!-- Modal Force Unpublish -->
<div id="forceUnpublishModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" onclick="closeModal()"></div>
        
        <div class="relative bg-white rounded-lg shadow-xl max-w-md w-full">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">Force Unpublish Dokumen</h3>
            </div>
            <form id="forceUnpublishForm" method="POST">
                @csrf
                @method('PATCH')
                <div class="px-6 py-4">
                    <p class="text-sm text-gray-600 mb-4" id="documentTitle"></p>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Alasan Force Unpublish</label>
                        <textarea name="reason" rows="3" class="w-full border-gray-300 rounded-md" 
                                  placeholder="Masukkan alasan mengapa dokumen ini di-force unpublish..." required></textarea>
                    </div>
                </div>
                <div class="px-6 py-4 bg-gray-50 rounded-b-lg flex justify-end space-x-3">
                    <button type="button" onclick="closeModal()" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-orange-600 text-white rounded-md hover:bg-orange-700">Force Unpublish</button>
                </div>
            </form>
        </div>
    </div>
</div>

<form id="delete-form" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>

<script>
    function forceUnpublish(id, title) {
        const modal = document.getElementById('forceUnpublishModal');
        const form = document.getElementById('forceUnpublishForm');
        const titleSpan = document.getElementById('documentTitle');
        
        titleSpan.innerHTML = '<strong>' + title + '</strong>';
        form.action = `/dashboard/utama/documents/${id}/force-unpublish`;
        modal.classList.remove('hidden');
    }

    function closeModal() {
        document.getElementById('forceUnpublishModal').classList.add('hidden');
    }

    function deleteDocument(id) {
        if (confirm('Apakah Anda yakin ingin menghapus dokumen ini? Tindakan ini tidak dapat dibatalkan.')) {
            const form = document.getElementById('delete-form');
            form.action = `/dashboard/utama/documents/${id}`;
            form.submit();
        }
    }

    // Close modal with Escape key
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            closeModal();
        }
    });
</script>
@endsection