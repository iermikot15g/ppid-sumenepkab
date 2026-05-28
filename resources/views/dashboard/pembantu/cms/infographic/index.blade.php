@extends('layouts.dashboard')

@section('title', 'Manajemen Infografis')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-semibold text-gray-900">Infografis</h1>
            <p class="mt-1 text-sm text-gray-600">Kelola infografis OPD Anda</p>
        </div>
        <a href="{{ route('pembantu.cms.infographic.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
            + Tambah Infografis
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        @forelse($infographics as $item)
        <div class="bg-white rounded-lg shadow overflow-hidden hover:shadow-lg transition">
            <div class="relative">
                @if($item->thumbnail)
                    <img src="{{ Storage::url($item->thumbnail) }}" alt="{{ $item->title }}" class="w-full h-48 object-cover">
                @else
                    <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                        <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                @endif
                <div class="absolute top-2 right-2">
                    <button onclick="toggleStatus({{ $item->id }})" 
                        class="px-2 py-1 text-xs rounded-full {{ $item->is_published ? 'bg-green-500 text-white' : 'bg-gray-500 text-white' }}">
                        {{ $item->is_published ? 'Published' : 'Draft' }}
                    </button>
                </div>
            </div>
            <div class="p-4">
                <h3 class="font-semibold text-gray-800 line-clamp-2">{{ $item->title }}</h3>
                <p class="text-xs text-gray-500 mt-1">{{ $item->created_at->format('d/m/Y H:i') }}</p>
                <div class="flex justify-end items-center mt-3 pt-3 border-t border-gray-100">
                    <a href="{{ route('pembantu.cms.infographic.edit', $item->id) }}" class="text-blue-600 hover:text-blue-800 text-sm mr-3">Edit</a>
                    <button onclick="deleteInfografis({{ $item->id }})" class="text-red-600 hover:text-red-800 text-sm">Hapus</button>
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-full text-center py-12">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
            <p class="mt-2 text-gray-500">Belum ada infografis</p>
            <p class="text-sm text-gray-400">Silakan tambah infografis pertama Anda</p>
        </div>
        @endforelse
    </div>

    <div class="mt-6">
        {{ $infographics->links() }}
    </div>
</div>

<form id="delete-form" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>

<script>
    function toggleStatus(id) {
        fetch(`/dashboard/pembantu/cms/infographic/${id}/toggle`, {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) location.reload();
        })
        .catch(error => console.error('Error:', error));
    }

    function deleteInfografis(id) {
        if (confirm('Apakah Anda yakin ingin menghapus infografis ini?')) {
            const form = document.getElementById('delete-form');
            form.action = `/dashboard/pembantu/cms/infographic/${id}`;
            form.submit();
        }
    }
</script>
@endsection