@extends('layouts.dashboard')

@section('title', 'Edit ' . $page->title)

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Edit {{ $page->title }}</h1>
            <a href="{{ route('utama.cms.standar.index') }}" class="text-gray-600 hover:text-gray-800">← Kembali</a>
        </div>

        <form method="POST" action="{{ route('utama.cms.standar.update', $page->page_key) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Judul</label>
                    <input type="text" name="title" class="w-full border-gray-300 rounded-md shadow-sm" 
                           value="{{ old('title', $page->title) }}" required>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Konten</label>
                    <textarea name="content" rows="15" class="w-full border-gray-300 rounded-md shadow-sm font-mono text-sm" 
                              id="content">{{ old('content', $page->content) }}</textarea>
                    <p class="text-xs text-gray-500 mt-1">Mendukung HTML untuk formatting</p>
                </div>

                @if($page->pdf_file_path)
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">File PDF Saat Ini</label>
                    <a href="{{ Storage::url($page->pdf_file_path) }}" target="_blank" class="text-maroon-600 hover:underline">
                        {{ basename($page->pdf_file_path) }}
                    </a>
                </div>
                @endif

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Upload PDF (opsional)</label>
                    <input type="file" name="pdf_file" class="w-full border-gray-300 rounded-md shadow-sm" accept=".pdf">
                    <p class="text-xs text-gray-500 mt-1">Format: PDF. Max 5MB</p>
                </div>
            </div>

            <div class="mt-6 flex justify-end space-x-3">
                <a href="{{ route('utama.cms.standar.index') }}" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">Batal</a>
                <button type="submit" class="px-4 py-2 bg-maroon-600 text-white rounded-md hover:bg-maroon-700">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>
@endsection