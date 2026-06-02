@extends('layouts.dashboard')

@section('title', 'Edit Layanan Publik')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Edit Layanan Publik</h1>
            <a href="{{ route('pembantu.cms.services.index') }}" class="text-gray-600 hover:text-gray-800">← Kembali</a>
        </div>

        <form method="POST" action="{{ route('pembantu.cms.services.update', $service) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Layanan <span class="text-red-500">*</span></label>
                    <input type="text" name="name" class="w-full border-gray-300 rounded-md shadow-sm" value="{{ old('name', $service->name) }}" required>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi Singkat</label>
                    <textarea name="description" rows="3" class="w-full border-gray-300 rounded-md shadow-sm">{{ old('description', $service->description) }}</textarea>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">URL Website <span class="text-red-500">*</span></label>
                    <input type="url" name="url" class="w-full border-gray-300 rounded-md shadow-sm" value="{{ old('url', $service->url) }}" required>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Icon Saat Ini</label>
                    @if($service->icon)
                        <div class="flex items-center gap-2 mt-1">
                            <img src="{{ Storage::url($service->icon) }}" class="w-8 h-8 rounded">
                            <span class="text-sm text-gray-500">{{ basename($service->icon) }}</span>
                        </div>
                    @else
                        <p class="text-gray-500 text-sm">Menggunakan favicon dari website</p>
                    @endif
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Ganti Icon</label>
                    <input type="file" name="icon" class="w-full border-gray-300 rounded-md shadow-sm" accept="image/*">
                    <p class="text-xs text-gray-500 mt-1">Kosongkan jika tidak ingin mengganti</p>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Urutan</label>
                        <input type="number" name="sort_order" class="w-full border-gray-300 rounded-md shadow-sm" value="{{ old('sort_order', $service->sort_order) }}">
                    </div>
                    <div>
                        <label class="flex items-center mt-6">
                            <input type="checkbox" name="is_active" value="1" class="rounded border-gray-300" {{ $service->is_active ? 'checked' : '' }}>
                            <span class="ml-2 text-sm text-gray-700">Aktif</span>
                        </label>
                    </div>
                </div>
            </div>

            <div class="mt-6 flex justify-end space-x-3">
                <a href="{{ route('pembantu.cms.services.index') }}" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">Batal</a>
                <button type="submit" class="px-4 py-2 bg-maroon-600 text-white rounded-md hover:bg-maroon-700">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>
@endsection