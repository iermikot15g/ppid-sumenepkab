@extends('layouts.dashboard')

@section('title', 'Dasar Hukum OPD')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-semibold text-gray-900">Dasar Hukum</h1>
            <p class="mt-1 text-sm text-gray-600">Kelola dokumen peraturan dan dasar hukum OPD</p>
        </div>
        <a href="{{ route('legal-documents.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
            + Tambah Dokumen
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
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nomor Peraturan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tahun</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">File</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($documents as $doc)
                    <tr>
                        <td class="px-6 py-4 text-sm text-gray-900">{{ Str::limit($doc->title, 50) }}</td>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ $doc->regulation_number ?? '-' }}</td>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ $doc->year ?? '-' }}</td>
                        <td class="px-6 py-4 text-sm text-blue-600">
                            <a href="{{ Storage::url($doc->file_path) }}" target="_blank" class="hover:underline">Lihat PDF</a>
                        </td>
                        <td class="px-6 py-4 text-right text-sm">
                            <a href="{{ route('legal-documents.edit', $doc) }}" class="text-blue-600 hover:text-blue-900 mr-3">Edit</a>
                            <button onclick="deleteDocument({{ $doc->id }})" class="text-red-600 hover:text-red-900">Hapus</button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                            Belum ada dokumen hukum. Silakan tambah dokumen pertama.
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
    function deleteDocument(id) {
        if (confirm('Apakah Anda yakin ingin menghapus dokumen ini?')) {
            const form = document.getElementById('delete-form');
            form.action = `/dashboard/pembantu/legal-documents/${id}`;
            form.submit();
        }
    }
</script>
@endsection