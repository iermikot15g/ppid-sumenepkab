@extends('layouts.dashboard')

@section('title', 'Manajemen Infografis')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-semibold text-gray-900">Manajemen Infografis</h1>
            <p class="mt-1 text-sm text-gray-600">Kelola konten infografis</p>
        </div>
        <a href="{{ route('utama.cms.infographic.create') }}" class="btn-primary">
            + Tambah Infografis
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
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Gambar</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Judul</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($infographics as $item)
                    <tr>
                        <td class="px-6 py-4">
                            @if($item->thumbnail)
                                <img src="{{ Storage::url($item->thumbnail) }}" class="h-12 w-12 object-cover rounded">
                            @else
                                <div class="h-12 w-12 bg-gray-200 rounded"></div>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-900">{{ Str::limit($item->title, 50) }}</td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 text-xs rounded-full {{ $item->is_published ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                {{ $item->is_published ? 'Published' : 'Draft' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right text-sm">
                            <a href="{{ route('utama.cms.infographic.edit', $item) }}" class="text-maroon-600 hover:text-blue-900 mr-3">Edit</a>
                            <button onclick="deleteInfographic({{ $item->id }})" class="text-red-600 hover:text-red-900">Hapus</button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-4 text-center text-gray-500">
                            Belum ada infografis.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4">
            {{ $infographics->links() }}
        </div>
    </div>
</div>

<form id="delete-form" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>

<script>
    function deleteInfographic(id) {
        if (confirm('Apakah Anda yakin ingin menghapus infografis ini?')) {
            const form = document.getElementById('delete-form');
            form.action = `/dashboard/utama/cms/infographic/${id}`;
            form.submit();
        }
    }
</script>
@endsection