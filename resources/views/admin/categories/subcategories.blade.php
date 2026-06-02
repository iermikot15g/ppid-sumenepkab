@extends('layouts.dashboard')

@section('title', 'Sub Kategori - ' . $category->name)

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-semibold text-gray-900">Sub Kategori: {{ $category->name }}</h1>
            <p class="mt-1 text-sm text-gray-600">Kelola sub kategori untuk {{ $category->name }}</p>
        </div>
        <a href="{{ route('admin.categories.index') }}" class="text-gray-600 hover:text-gray-800">← Kembali ke Kategori</a>
    </div>

    <!-- Form Tambah Sub Kategori -->
    <div class="bg-white shadow rounded-lg p-6">
        <h2 class="text-lg font-semibold text-gray-800 mb-4">Tambah Sub Kategori Baru</h2>
        <form method="POST" action="{{ route('admin.categories.subcategories.store', $category) }}" class="flex flex-col md:flex-row gap-4">
            @csrf
            <div class="flex-1">
                <input type="text" name="name" class="w-full border-gray-300 rounded-md shadow-sm" placeholder="Nama Sub Kategori" required>
                @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            <div class="flex-1">
                <input type="text" name="slug" class="w-full border-gray-300 rounded-md shadow-sm" placeholder="Slug (otomatis)" required>
                <p class="text-xs text-gray-500 mt-1">Contoh: profil-badan-publik</p>
                @error('slug') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            <div class="w-32">
                <input type="number" name="sort_order" class="w-full border-gray-300 rounded-md shadow-sm" placeholder="Urutan" value="0">
            </div>
            <button type="submit" class="px-4 py-2 bg-maroon-600 text-white rounded-md hover:bg-maroon-700">Tambah</button>
        </form>
    </div>

    <!-- Daftar Sub Kategori -->
    <div class="bg-white shadow rounded-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama Sub Kategori</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Slug</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Urutan</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($subCategories as $sub)
                    <tr>
                        <td class="px-6 py-4 text-sm text-gray-900">{{ $sub->name }}</td>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ $sub->slug }}</td>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ $sub->sort_order }}</td>
                        <td class="px-6 py-4 text-right text-sm">
                            <a href="{{ route('admin.subcategories.edit', $sub) }}" class="text-maroon-600 hover:text-blue-900 mr-3">Edit</a>
                            <button onclick="deleteSubCategory({{ $sub->id }})" class="text-red-600 hover:text-red-900">Hapus</button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-4 text-center text-gray-500">
                            Belum ada sub kategori. Silakan tambah sub kategori pertama.
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
    function deleteSubCategory(id) {
        if (confirm('Apakah Anda yakin ingin menghapus sub kategori ini?')) {
            const form = document.getElementById('delete-form');
            form.action = `/dashboard/admin/subcategories/${id}`;
            form.submit();
        }
    }
</script>
@endsection