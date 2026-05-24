@extends('layouts.dashboard')

@section('title', 'Manajemen Dokumen DIP')

@section('content')
<div class="p-6">
    <!-- Header dengan Tombol Upload -->
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">📄 Dokumen DIP</h1>
        <a href="{{ route('pembantu.documents.create') }}" 
           class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg shadow transition duration-200 flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
            </svg>
            Upload Dokumen Baru
        </a>
    </div>

    <!-- Alert Success -->
    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 rounded shadow-sm" role="alert">
            <p class="font-medium">✅ Berhasil!</p>
            <p>{{ session('success') }}</p>
        </div>
    @endif

    <!-- Tabel Dokumen -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Judul</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kategori</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tahun</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Klasifikasi</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Upload</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($documents as $doc)
                    <tr>
                        <td class="px-6 py-4 text-sm text-gray-900">{{ Str::limit($doc->title, 50) }}</td>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ $doc->category->name ?? '-' }}</td>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ $doc->year }}</td>
                        <td class="px-6 py-4">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $doc->classification === 'open' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $doc->classification === 'open' ? 'Terbuka' : 'Dikecualikan' }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <select onchange="updateStatus({{ $doc->id }}, this.value)" 
                                    class="text-xs rounded-full px-2 py-1 border-0 focus:ring-2 focus:ring-blue-500
                                        {{ $doc->status === 'published' ? 'bg-green-100 text-green-800' : 
                                           ($doc->status === 'archived' ? 'bg-gray-100 text-gray-800' : 'bg-yellow-100 text-yellow-800') }}">
                                <option value="published" {{ $doc->status === 'published' ? 'selected' : '' }}>Published</option>
                                <option value="unpublished" {{ $doc->status === 'unpublished' ? 'selected' : '' }}>Unpublished</option>
                                <option value="archived" {{ $doc->status === 'archived' ? 'selected' : '' }}>Archived</option>
                            </select>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ $doc->created_at->format('d/m/Y') }}</td>
                        <td class="px-6 py-4 text-right text-sm font-medium">
                            <a href="{{ route('pembantu.documents.edit', $doc) }}" class="text-blue-600 hover:text-blue-900 mr-3">Edit</a>
                            <button onclick="deleteDocument({{ $doc->id }})" class="text-red-600 hover:text-red-900">Hapus</button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center text-gray-500">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <p class="mt-2 font-medium">Belum ada dokumen</p>
                            <p class="text-sm">Silakan upload dokumen pertama Anda dengan klik tombol "Upload Dokumen Baru" di atas.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 bg-gray-50 border-t">
            {{ $documents->links() }}
        </div>
    </div>
</div>

<form id="delete-form" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>

<script>
    function updateStatus(id, status) {
        fetch(`/dashboard/pembantu/documents/${id}/status`, {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ status: status })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            }
        })
        .catch(error => console.error('Error:', error));
    }

    function deleteDocument(id) {
        if (confirm('Apakah Anda yakin ingin menghapus dokumen ini?')) {
            const form = document.getElementById('delete-form');
            form.action = `/dashboard/pembantu/documents/${id}`;
            form.submit();
        }
    }
</script>
@endsection