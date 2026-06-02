@extends('layouts.dashboard')

@section('title', 'Edit Agenda')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Edit Agenda</h1>
            <a href="{{ route('pembantu.cms.agenda.index') }}" class="text-gray-600 hover:text-gray-800">← Kembali</a>
        </div>

        <form method="POST" action="{{ route('pembantu.cms.agenda.update', $agenda->id) }}">
            @csrf
            @method('PUT')

            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Judul Agenda <span class="text-red-500">*</span></label>
                    <input type="text" name="title" class="w-full border-gray-300 rounded-md shadow-sm" value="{{ old('title', $agenda->title) }}" required>
                    @error('title') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal <span class="text-red-500">*</span></label>
                        <input type="date" name="event_date" class="w-full border-gray-300 rounded-md shadow-sm" value="{{ old('event_date', $agenda->event_date ? $agenda->event_date->format('Y-m-d') : '') }}" required>
                        @error('event_date') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Lokasi</label>
                        <input type="text" name="location" class="w-full border-gray-300 rounded-md shadow-sm" value="{{ old('location', $agenda->location) }}">
                        @error('location') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                    <textarea name="content" rows="5" class="w-full border-gray-300 rounded-md shadow-sm font-mono text-sm">{{ old('content', $agenda->content) }}</textarea>
                </div>

                <div>
                    <label class="flex items-center">
                        <input type="checkbox" name="is_published" value="1" class="rounded border-gray-300" {{ $agenda->is_published ? 'checked' : '' }}>
                        <span class="ml-2 text-sm text-gray-700">Publikasikan</span>
                    </label>
                </div>
            </div>

            <div class="mt-6 flex justify-end space-x-3">
                <a href="{{ route('pembantu.cms.agenda.index') }}" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">Batal</a>
                <button type="submit" class="px-4 py-2 bg-maroon-600 text-white rounded-md hover:bg-maroon-700">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>
@endsection