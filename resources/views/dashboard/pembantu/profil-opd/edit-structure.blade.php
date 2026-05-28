@extends('layouts.dashboard')

@section('title', 'Edit Struktur Organisasi')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Edit Struktur Organisasi</h1>
            <a href="{{ route('pembantu.profil-opd.index') }}" class="text-gray-600 hover:text-gray-800">← Kembali ke CMS Profil OPD</a>
        </div>

        <form method="POST" action="{{ route('pembantu.profil-opd.update-structure') }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Struktur Organisasi Saat Ini</label>
                    @if($opd->structure_image)
                        <img src="{{ Storage::url($opd->structure_image) }}" alt="Struktur Organisasi" 
                             class="w-full max-w-md border rounded-lg shadow-sm mb-2" style="aspect-ratio: 4/3; object-fit: contain;">
                    @else
                        <p class="text-gray-500 text-sm">Belum ada gambar struktur organisasi</p>
                    @endif
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Upload Gambar Baru</label>
                    <input type="file" name="structure_image" class="w-full border-gray-300 rounded-md shadow-sm" accept="image/*">
                    <p class="text-xs text-gray-500 mt-1">Rekomendasi rasio 4:3 (misal: 800x600px). Format: JPG, PNG. Max 2MB</p>
                </div>
            </div>

            <div class="mt-6 flex justify-end space-x-3">
                <a href="{{ route('pembantu.profil-opd.index') }}" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">Batal</a>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>
@endsection