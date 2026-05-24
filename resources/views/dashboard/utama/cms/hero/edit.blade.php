@extends('layouts.dashboard')

@section('title', 'Edit Slide Hero')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Edit Slide Hero</h1>
            <a href="{{ route('utama.cms.hero.index') }}" class="text-gray-600 hover:text-gray-800">← Kembali</a>
        </div>

        <form method="POST" action="{{ route('utama.cms.hero.update', $heroSlide) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Gambar Saat Ini</label>
                    <img src="{{ Storage::url($heroSlide->image_path) }}" class="h-32 w-auto object-cover rounded mb-2">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Ganti Gambar</label>
                    <input type="file" name="image" class="w-full border-gray-300 rounded-md shadow-sm" accept="image/*">
                    <p class="text-xs text-gray-500 mt-1">Kosongkan jika tidak ingin mengganti gambar</p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Judul</label>
                    <input type="text" name="title" class="w-full border-gray-300 rounded-md shadow-sm" value="{{ old('title', $heroSlide->title) }}">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Sub Judul</label>
                    <textarea name="subtitle" rows="2" class="w-full border-gray-300 rounded-md shadow-sm">{{ old('subtitle', $heroSlide->subtitle) }}</textarea>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Teks Tombol</label>
                        <input type="text" name="button_text" class="w-full border-gray-300 rounded-md shadow-sm" value="{{ old('button_text', $heroSlide->button_text) }}">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Link Tombol</label>
                        <input type="text" name="button_link" class="w-full border-gray-300 rounded-md shadow-sm" value="{{ old('button_link', $heroSlide->button_link) }}">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Urutan</label>
                    <input type="number" name="sort_order" class="w-full border-gray-300 rounded-md shadow-sm" value="{{ old('sort_order', $heroSlide->sort_order) }}">
                </div>

                <div>
                    <label class="flex items-center">
                        <input type="checkbox" name="is_active" value="1" class="rounded border-gray-300" {{ $heroSlide->is_active ? 'checked' : '' }}>
                        <span class="ml-2 text-sm text-gray-700">Aktifkan slide</span>
                    </label>
                </div>
            </div>

            <div class="mt-6 flex justify-end space-x-3">
                <a href="{{ route('utama.cms.hero.index') }}" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">Batal</a>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>
@endsection