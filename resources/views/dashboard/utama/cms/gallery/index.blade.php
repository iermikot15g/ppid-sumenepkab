@extends('layouts.dashboard')

@section('title', 'Manajemen Galeri')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-semibold text-gray-900">Manajemen Galeri</h1>
            <p class="mt-1 text-sm text-gray-600">Kelola foto galeri kegiatan</p>
        </div>
        <a href="{{ route('utama.cms.gallery.create') }}" class="btn-primary">
            + Tambah Foto
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        @forelse($galleries as $item)
        <div class="bg-white rounded-lg shadow overflow-hidden">
            @if($item->thumbnail)
                <img src="{{ Storage::url($item->thumbnail) }}" alt="{{ $item->title }}" 
                     class="w-full h-48 object-cover">
            @else
                <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                    <svg class="h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
            @endif
            <div class="p-4">
                <h3 class="font-medium text-gray-900 mb-1">{{ Str::limit($item->title, 40) }}</h3>
                <div class="flex justify-between items-center mt-2">
                    <span class="px-2 py-1 text-xs rounded-full {{ $item->is_published ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                        {{ $item->is_published ? 'Published' : 'Draft' }}
                    </span>
                    <div>
                        <a href="{{ route('utama.cms.gallery.edit', $item) }}" class="text-blue-600 hover:text-blue-900 mr-2">Edit</a>
                        <button onclick="deleteGallery({{ $item->id }})" class="text-red-600 hover:text-red-900">Hapus</button>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-full text-center py-12">
            <p class="text-gray-500">Belum ada foto galeri.</p>
        </div>
        @endforelse
    </div>

    <div class="mt-6">
        {{ $galleries->links() }}
    </div>
</div>

<form id="delete-form" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>

<script>
    function deleteGallery(id) {
        if (confirm('Apakah Anda yakin ingin menghapus foto ini?')) {
            const form = document.getElementById('delete-form');
            form.action = `/dashboard/utama/cms/gallery/${id}`;
            form.submit();
        }
    }
</script>
@endsection