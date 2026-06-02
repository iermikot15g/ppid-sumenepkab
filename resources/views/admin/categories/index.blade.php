@extends('layouts.dashboard')

@section('title', 'Master Kategori DIP')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-semibold text-gray-900">Master Kategori DIP</h1>
            <p class="mt-1 text-sm text-gray-600">Kelola kategori dan sub kategori Daftar Informasi Publik</p>
        </div>
        <a href="{{ route('admin.categories.create') }}" class="btn-primary">
            + Tambah Kategori
        </a>
    </div>

    <div class="bg-white shadow rounded-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama Kategori</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Slug</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Urutan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Sub Kategori</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($categories as $category)
                    <tr>
                        <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $category->name }}</td>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ $category->slug }}</td>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ $category->sort_order }}</td>
                        <td class="px-6 py-4 text-sm">
                            <a href="{{ route('admin.categories.subcategories', $category) }}" class="text-maroon-600 hover:text-blue-900">
                                Kelola ({{ $category->subCategories->count() }})
                            </a>
                        </td>
                        <td class="px-6 py-4 text-right text-sm">
                            <a href="{{ route('admin.categories.edit', $category) }}" class="text-maroon-600 hover:text-blue-900 mr-3">Edit</a>
                            <button onclick="deleteCategory({{ $category->id }})" class="text-red-600 hover:text-red-900">Hapus</button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                            Belum ada kategori. Silakan tambah kategori pertama.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<form id="delete-form" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>

<script>
    function deleteCategory(id) {
        if (confirm('Apakah Anda yakin ingin menghapus kategori ini? Semua sub kategori akan ikut terhapus.')) {
            const form = document.getElementById('delete-form');
            form.action = `/dashboard/admin/categories/${id}`;
            form.submit();
        }
    }
</script>
@endsection