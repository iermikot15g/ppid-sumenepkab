@extends('layouts.dashboard')

@section('title', 'Edit Foto Galeri')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Edit Foto Galeri</h1>
            <a href="{{ route('utama.cms.gallery.index') }}" class="text-gray-600 hover:text-gray-800">← Kembali</a>
        </div>

        <form method="POST" action="{{ route('utama.cms.gallery.update', $news) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Judul Foto <span class="text-red-500">*</span></label>
                    <input type="text" name="title" class="w-full border-gray-300 rounded-md shadow-sm" value="{{ old('title', $news->title) }}" required>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Foto Saat Ini</label>
                    @if($news->thumbnail)
                        <img src="{{ Storage::url($news->thumbnail) }}" class="h-32 w-auto object-cover rounded mb-2">
                    @else
                        <p class="text-gray-500">Tidak ada foto</p>
                    @endif
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Ganti Foto</label>
                    <input type="file" name="thumbnail" class="w-full border-gray-300 rounded-md shadow-sm" accept="image/*">
                    <p class="text-xs text-gray-500 mt-1">Kosongkan jika tidak ingin mengganti foto. Format: JPG, JPEG, PNG. Maks 2MB</p>
                </div>

                <div>
                    <label class="flex items-center">
                        <input type="checkbox" name="is_published" value="1" class="rounded border-gray-300" {{ $news->is_published ? 'checked' : '' }}>
                        <span class="ml-2 text-sm text-gray-700">Publikasikan</span>
                    </label>
                </div>
            </div>

            <div class="mt-6 flex justify-end space-x-3">
                <a href="{{ route('utama.cms.gallery.index') }}" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">Batal</a>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>
@endsection