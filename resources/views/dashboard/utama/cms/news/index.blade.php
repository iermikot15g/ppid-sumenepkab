@extends('layouts.dashboard')

@section('title', 'Manajemen Berita')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <h1 class="text-2xl font-semibold text-gray-900">Manajemen Berita</h1>
        <a href="{{ route('utama.cms.news.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
            + Tambah Berita
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 p-4 rounded">{{ session('success') }}</div>
    @endif

    <div class="bg-white shadow rounded-lg overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500">Judul</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500">Tanggal</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($news as $item)
                <tr>
                    <td class="px-6 py-4">{{ $item->title }}</td>
                    <td class="px-6 py-4">
                        <span class="px-2 py-1 text-xs rounded-full {{ $item->is_published ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                            {{ $item->is_published ? 'Published' : 'Draft' }}
                        </span>
                    </td>
                    <td class="px-6 py-4">{{ $item->created_at->format('d/m/Y') }}</td>
                    <td class="px-6 py-4 text-right">
                        <a href="{{ route('utama.cms.news.edit', $item) }}" class="text-blue-600 mr-3">Edit</a>
                        <button onclick="deleteNews({{ $item->id }})" class="text-red-600">Hapus</button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-6 py-4 text-center">Belum ada berita</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<form id="delete-form" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>

<script>
    function deleteNews(id) {
        if (confirm('Hapus berita ini?')) {
            const form = document.getElementById('delete-form');
            form.action = `/dashboard/utama/cms/news/${id}`;
            form.submit();
        }
    }
</script>
@endsection