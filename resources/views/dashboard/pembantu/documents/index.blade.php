@extends('layouts.dashboard')

@section('title', 'Manajemen Dokumen DIP')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-semibold text-gray-900">Dokumen DIP</h1>
            <p class="mt-1 text-sm text-gray-600">Kelola dokumen informasi publik OPD Anda</p>
        </div>
        <a href="{{ url('/dashboard/pembantu/documents/create') }}" class="px-4 py-2 bg-maroon-600 text-white rounded-md hover:bg-maroon-700">
            + Upload Dokumen Baru
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white shadow rounded-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Judul</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kategori</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tahun</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Klasifikasi</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Upload</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($documents as $doc)
                    <tr>
                        <td class="px-6 py-4 text-sm text-gray-900">{{ Str::limit($doc->title, 50) }}</td>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ $doc->category->name ?? '-' }}</td>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ $doc->year }}</td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 text-xs rounded-full {{ $doc->classification === 'open' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $doc->classification === 'open' ? 'Terbuka' : 'Dikecualikan' }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <select onchange="updateStatus({{ $doc->id }}, this.value)" 
                                    class="text-xs rounded-full px-2 py-1 border-0
                                        {{ $doc->status === 'published' ? 'bg-green-100 text-green-800' : 
                                           ($doc->status === 'archived' ? 'bg-gray-100 text-gray-800' : 'bg-yellow-100 text-yellow-800') }}">
                                <option value="published" {{ $doc->status === 'published' ? 'selected' : '' }}>Published</option>
                                <option value="unpublished" {{ $doc->status === 'unpublished' ? 'selected' : '' }}>Unpublished</option>
                                <option value="archived" {{ $doc->status === 'archived' ? 'selected' : '' }}>Archived</option>
                            </select>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ $doc->created_at->format('d/m/Y') }}</td>
                        <td class="px-6 py-4 text-right text-sm">
                            <a href="{{ url('/dashboard/pembantu/documents/' . $doc->id . '/edit') }}" class="text-maroon-600 hover:text-blue-900 mr-3">Edit</a>
                            <button onclick="deleteDocument({{ $doc->id }})" class="text-red-600 hover:text-red-900">Hapus</button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                            Belum ada dokumen. Silakan upload dokumen pertama Anda.
                        </td>
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