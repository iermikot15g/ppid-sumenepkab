@extends('layouts.dashboard')

@section('title', 'Edit Struktur Organisasi')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Edit Struktur Organisasi</h1>
            <a href="{{ route('pembantu.cms.profil.index') }}" class="text-gray-600 hover:text-gray-800">← Kembali ke CMS Profil OPD</a>
        </div>

        <form method="POST" action="{{ route('pembantu.cms.profil.update-structure') }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Struktur Organisasi Saat Ini</label>
                    @if($opd->structure_image)
                        <img src="{{ Storage::url($opd->structure_image) }}" alt="Struktur Organisasi" 
                             class="w-full max-w-md border rounded-lg shadow-sm mb-2" style="aspect-ratio: 4/3; object-fit: contain;">
                    @else
                        <div class="bg-gray-100 rounded-lg p-8 text-center">
                            <svg class="w-16 h-16 mx-auto text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <p class="mt-2 text-gray-500">Belum ada gambar struktur organisasi</p>
                        </div>
                    @endif
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Upload Gambar Baru</label>
                    <input type="file" name="structure_image" class="w-full border-gray-300 rounded-md shadow-sm" accept="image/*">
                    <p class="text-xs text-gray-500 mt-1">Rekomendasi rasio 4:3 (misal: 800x600px). Format: JPG, PNG. Max 2MB</p>
                </div>
            </div>

            <div class="mt-6 flex justify-end space-x-3">
                <a href="{{ route('pembantu.cms.profil.index') }}" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">Batal</a>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>
@endsection
