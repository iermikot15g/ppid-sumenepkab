@extends('layouts.dashboard')

@section('title', 'Edit Tentang OPD')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Edit Tentang OPD</h1>
            <a href="{{ route('pembantu.cms.profil.index') }}" class="text-gray-600 hover:text-gray-800">← Kembali</a>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 rounded">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('pembantu.cms.profil.update-tentang') }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="space-y-6">
                <!-- Logo -->
                <div class="border-b border-gray-200 pb-4">
                    <h2 class="text-lg font-semibold text-gray-800 mb-4">Logo OPD</h2>
                    <div class="flex items-center gap-4">
                        @if($opd->logo)
                            <img src="{{ Storage::url($opd->logo) }}" class="h-20 w-20 object-cover rounded-lg">
                        @else
                            <div class="h-20 w-20 bg-gray-200 rounded-lg flex items-center justify-center">
                                <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                </svg>
                            </div>
                        @endif
                        <div class="flex-1">
                            <input type="file" name="logo" class="w-full border-gray-300 rounded-md shadow-sm" accept="image/*">
                            <p class="text-xs text-gray-500 mt-1">Max 2MB, format: JPG, PNG</p>
                            @error('logo') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>

                <!-- Google Maps -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Google Maps Link (Embed URL)</label>
                    <input type="text" name="google_maps_link" class="w-full border-gray-300 rounded-md shadow-sm" 
                           value="{{ old('google_maps_link', $opd->google_maps_link) }}" 
                           placeholder="https://www.google.com/maps/embed?pb=...">
                    <p class="text-xs text-gray-500 mt-1">Masukkan URL dari iframe Google Maps (bukan seluruh kode iframe)</p>
                    @error('google_maps_link') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Konten -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Konten</label>
                    <textarea name="tentang_content" rows="15" class="w-full border-gray-300 rounded-md shadow-sm font-mono text-sm" 
                              id="tentang_content">{{ old('tentang_content', $opd->tentang_content) }}</textarea>
                    <p class="text-xs text-gray-500 mt-1">Mendukung HTML untuk formatting</p>
                </div>
            </div>

            <div class="mt-6 flex justify-end space-x-3">
                <a href="{{ route('pembantu.cms.profil.index') }}" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">Batal</a>
                <button type="submit" class="px-4 py-2 bg-maroon-600 text-white rounded-md hover:bg-maroon-700">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>
@endsection