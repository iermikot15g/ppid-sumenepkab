@extends('layouts.dashboard')

@section('title', 'Tambah Layanan Publik')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Tambah Layanan Publik</h1>
            <a href="{{ route('pembantu.cms.services.index') }}" class="text-gray-600 hover:text-gray-800">← Kembali</a>
        </div>

        <form method="POST" action="{{ route('pembantu.cms.services.store') }}" enctype="multipart/form-data">
            @csrf

            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Layanan <span class="text-red-500">*</span></label>
                    <input type="text" name="name" class="w-full border-gray-300 rounded-md shadow-sm" value="{{ old('name') }}" required>
                    <p class="text-xs text-gray-500 mt-1">Contoh: LAPOR!, SIMANTRA, JDIH, dll</p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi Singkat</label>
                    <textarea name="description" rows="3" class="w-full border-gray-300 rounded-md shadow-sm">{{ old('description') }}</textarea>
                    <p class="text-xs text-gray-500 mt-1">Contoh: Layanan Aspirasi dan Pengaduan Online Rakyat</p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">URL Website <span class="text-red-500">*</span></label>
                    <input type="url" name="url" class="w-full border-gray-300 rounded-md shadow-sm" value="{{ old('url') }}" required>
                    <p class="text-xs text-gray-500 mt-1">Contoh: https://www.lapor.go.id/</p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Icon (opsional)</label>
                    <input type="file" name="icon" class="w-full border-gray-300 rounded-md shadow-sm" accept="image/*">
                    <p class="text-xs text-gray-500 mt-1">Jika tidak diisi, akan menggunakan favicon dari website</p>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Urutan</label>
                        <input type="number" name="sort_order" class="w-full border-gray-300 rounded-md shadow-sm" value="0">
                    </div>
                    <div>
                        <label class="flex items-center mt-6">
                            <input type="checkbox" name="is_active" value="1" class="rounded border-gray-300" checked>
                            <span class="ml-2 text-sm text-gray-700">Aktif</span>
                        </label>
                    </div>
                </div>
            </div>

            <div class="mt-6 flex justify-end space-x-3">
                <a href="{{ route('pembantu.cms.services.index') }}" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">Batal</a>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">Simpan</button>
            </div>
        </form>
    </div>
</div>
@endsection