@extends('layouts.dashboard')

@section('title', 'Edit Berita')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Edit Berita</h1>
            <a href="{{ route('utama.cms.news.index') }}" class="text-gray-600 hover:text-gray-800">← Kembali</a>
        </div>

        <form method="POST" action="{{ route('utama.cms.news.update', $news) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="space-y-4">
                <!-- Judul -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Judul Berita <span class="text-red-500">*</span></label>
                    <input type="text" name="title" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500" value="{{ old('title', $news->title) }}" required>
                    @error('title') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Thumbnail -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Thumbnail</label>
                    @if($news->thumbnail)
                        <div class="mb-2">
                            <img src="{{ Storage::url($news->thumbnail) }}" class="h-20 w-auto object-cover rounded">
                            <p class="text-xs text-gray-500 mt-1">Thumbnail saat ini</p>
                        </div>
                    @endif
                    <input type="file" name="thumbnail" class="w-full border-gray-300 rounded-md shadow-sm" accept="image/*">
                    <p class="text-xs text-gray-500 mt-1">Format: JPG, JPEG, PNG. Maks 2MB. Kosongkan jika tidak ingin mengganti.</p>
                    @error('thumbnail') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Konten -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Konten <span class="text-red-500">*</span></label>
                    <textarea name="content" rows="10" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500" required>{{ old('content', $news->content) }}</textarea>
                    @error('content') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Status -->
                <div>
                    <label class="flex items-center">
                        <input type="checkbox" name="is_published" value="1" class="rounded border-gray-300" {{ $news->is_published ? 'checked' : '' }}>
                        <span class="ml-2 text-sm text-gray-700">Publikasikan</span>
                    </label>
                </div>
            </div>

            <div class="mt-6 flex justify-end space-x-3">
                <a href="{{ route('utama.cms.news.index') }}" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">Batal</a>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>
@endsection