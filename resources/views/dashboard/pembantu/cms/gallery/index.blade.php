@extends('layouts.dashboard')

@section('title', 'Galeri Foto')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-semibold text-gray-900">Galeri Foto</h1>
            <p class="mt-1 text-sm text-gray-600">Kelola foto kegiatan OPD Anda</p>
        </div>
        <a href="{{ route('pembantu.cms.gallery.create') }}" class="px-4 py-2 bg-maroon-600 text-white rounded-md hover:bg-maroon-700">
            + Tambah Galeri
        </a>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Foto</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Judul</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Dibuat</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($galleries as $gallery)
                    <tr>
                        <td class="px-6 py-4">
                            @if($gallery->thumbnail)
                                <img src="{{ Storage::url($gallery->thumbnail) }}" class="w-12 h-12 object-cover rounded">
                            @else
                                <div class="w-12 h-12 bg-gray-200 rounded flex items-center justify-center">
                                    <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm font-medium text-gray-900">{{ $gallery->title }}</div>
                        </td>
                        <td class="px-6 py-4">
                            @if($gallery->is_published)
                                <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">Published</span>
                            @else
                                <span class="px-2 py-1 text-xs rounded-full bg-yellow-100 text-yellow-800">Draft</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500">
                            {{ $gallery->created_at->format('d/m/Y') }}
                        </td>
                        <td class="px-6 py-4 text-right">
                            <a href="{{ route('pembantu.cms.gallery.edit', $gallery->id) }}" class="text-blue-600 hover:text-blue-900 mr-3">Edit</a>
                            <button onclick="confirmDelete({{ $gallery->id }})" class="text-red-600 hover:text-red-900">Hapus</button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                            Belum ada galeri foto. Klik "Tambah Galeri" untuk membuat baru.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4">
            {{ $galleries->links() }}
        </div>
    </div>
</div>

<script>
function confirmDelete(id) {
    if (confirm('Apakah Anda yakin ingin menghapus galeri ini?')) {
        fetch(`/dashboard/pembantu/cms/gallery/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            }
        }).then(response => {
            if (response.ok) {
                window.location.reload();
            }
        });
    }
}
</script>
@endsection