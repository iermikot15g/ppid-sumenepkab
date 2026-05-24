@extends('layouts.dashboard')

@section('title', 'Tambah Agenda')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Tambah Agenda Baru</h1>
            <a href="{{ route('utama.cms.agenda.index') }}" class="text-gray-600 hover:text-gray-800">← Kembali</a>
        </div>

        <form method="POST" action="{{ route('utama.cms.agenda.store') }}">
            @csrf

            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Judul Agenda <span class="text-red-500">*</span></label>
                    <input type="text" name="title" class="w-full border-gray-300 rounded-md shadow-sm" required>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal <span class="text-red-500">*</span></label>
                        <input type="date" name="event_date" class="w-full border-gray-300 rounded-md shadow-sm" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Lokasi</label>
                        <input type="text" name="location" class="w-full border-gray-300 rounded-md shadow-sm">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                    <textarea name="content" rows="5" class="w-full border-gray-300 rounded-md shadow-sm"></textarea>
                </div>

                <div>
                    <label class="flex items-center">
                        <input type="checkbox" name="is_published" value="1" class="rounded border-gray-300">
                        <span class="ml-2 text-sm text-gray-700">Publikasikan</span>
                    </label>
                </div>
            </div>

            <div class="mt-6 flex justify-end space-x-3">
                <a href="{{ route('utama.cms.agenda.index') }}" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">Batal</a>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">Simpan</button>
            </div>
        </form>
    </div>
</div>
@endsection