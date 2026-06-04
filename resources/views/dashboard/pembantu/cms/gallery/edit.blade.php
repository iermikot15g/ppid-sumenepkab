@extends('layouts.dashboard')

@section('title', 'Edit Galeri Foto')

@section('header')
    <h1 class="text-2xl font-semibold text-gray-900">Edit Galeri Foto</h1>
@endsection

@section('content')
<div class="bg-white rounded-lg shadow p-6">
    <form method="POST" action="{{ route('pembantu.cms.gallery.update', $gallery->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-2">Judul *</label>
            <input type="text" name="title" value="{{ old('title', $gallery->title) }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-maroon-500 focus:border-maroon-500" required>
            @error('title') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>
        
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-2">Deskripsi</label>
            <textarea name="description" rows="4" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-maroon-500 focus:border-maroon-500">{{ old('description', $gallery->content) }}</textarea>
            @error('description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>
        
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-2">Foto Galeri Saat Ini</label>
            @if($gallery->thumbnail)
                <div class="mb-2">
                    <img src="{{ Storage::url($gallery->thumbnail) }}" class="w-32 h-32 object-cover rounded border">
                </div>
            @else
                <p class="text-gray-500">Tidak ada foto</p>
            @endif
        </div>
        
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-2">Ganti Foto (Opsional)</label>
            <input type="file" name="thumbnail" accept="image/*" class="w-full">
            <p class="text-xs text-gray-500 mt-1">Format: JPG, PNG. Maksimal 5MB. Kosongkan jika tidak ingin mengganti foto.</p>
            @error('thumbnail') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>
        
        <div class="mb-4">
            <label class="inline-flex items-center">
                <input type="checkbox" name="is_published" value="1" {{ old('is_published', $gallery->is_published) ? 'checked' : '' }} class="rounded border-gray-300 text-maroon-600 focus:ring-maroon-500">
                <span class="ml-2 text-sm text-gray-700">Published</span>
            </label>
        </div>
        
        <div class="flex justify-end">
            <a href="{{ route('pembantu.cms.gallery.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg mr-2">Batal</a>
            <button type="submit" class="px-4 py-2 bg-maroon-600 text-white rounded-lg hover:bg-maroon-700">Simpan Perubahan</button>
        </div>
    </form>
</div>
@endsection