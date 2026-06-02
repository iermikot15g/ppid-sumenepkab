@extends('layouts.dashboard')

@section('title', 'Edit Agenda')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Edit Agenda</h1>
            <a href="{{ route('utama.cms.agenda.index') }}" class="text-gray-600 hover:text-gray-800">← Kembali</a>
        </div>

        <form method="POST" action="{{ route('utama.cms.agenda.update', $news) }}">
            @csrf
            @method('PUT')

            <div class="space-y-4">
                <!-- Judul -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Judul Agenda <span class="text-red-500">*</span></label>
                    <input type="text" name="title" class="w-full border-gray-300 rounded-md shadow-sm focus:border-maroon-500 focus:ring-maroon-500" 
                           value="{{ old('title', $news->title) }}" required>
                    @error('title') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Tanggal dan Lokasi -->
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal <span class="text-red-500">*</span></label>
                        <input type="date" name="event_date" class="w-full border-gray-300 rounded-md shadow-sm focus:border-maroon-500 focus:ring-maroon-500" 
                               value="{{ old('event_date', $news->event_date ? $news->event_date->format('Y-m-d') : '') }}" required>
                        @error('event_date') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Lokasi</label>
                        <input type="text" name="location" class="w-full border-gray-300 rounded-md shadow-sm focus:border-maroon-500 focus:ring-maroon-500" 
                               value="{{ old('location', $news->location) }}">
                        @error('location') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <!-- Deskripsi -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                    <textarea name="content" rows="5" class="w-full border-gray-300 rounded-md shadow-sm focus:border-maroon-500 focus:ring-maroon-500">{{ old('content', $news->content) }}</textarea>
                    @error('content') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Status Publikasi -->
                <div>
                    <label class="flex items-center">
                        <input type="checkbox" name="is_published" value="1" class="rounded border-gray-300 focus:ring-maroon-500" 
                               {{ $news->is_published ? 'checked' : '' }}>
                        <span class="ml-2 text-sm text-gray-700">Publikasikan</span>
                    </label>
                </div>
            </div>

            <div class="mt-6 flex justify-end space-x-3">
                <a href="{{ route('utama.cms.agenda.index') }}" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">Batal</a>
                <button type="submit" class="px-4 py-2 bg-maroon-600 text-white rounded-md hover:bg-maroon-700">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>
@endsection