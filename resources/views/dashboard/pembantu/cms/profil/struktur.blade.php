@extends('layouts.dashboard')

@section('title', 'Edit Struktur Organisasi')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Edit Struktur Organisasi</h1>
            <a href="{{ route('pembantu.cms.profil.index') }}" class="text-gray-600 hover:text-gray-800">← Kembali</a>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 rounded">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('pembantu.cms.profil.update-struktur') }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="space-y-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Konten Struktur Organisasi</label>
                    <textarea name="structure_content" rows="15" class="w-full border-gray-300 rounded-md shadow-sm font-mono text-sm" 
                              id="structure_content">{{ old('structure_content', $opd->structure_content) }}</textarea>
                    <p class="text-xs text-gray-500 mt-1">Mendukung HTML untuk formatting</p>
                </div>

                @if($opd->structure_pdf && Storage::disk('public')->exists($opd->structure_pdf))
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">PDF Saat Ini</label>
                    <div class="flex items-center gap-2">
                        <a href="{{ Storage::url($opd->structure_pdf) }}" target="_blank" class="text-maroon-600 hover:underline">
                            {{ basename($opd->structure_pdf) }}
                        </a>
                    </div>
                </div>
                @endif

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Upload PDF (opsional)</label>
                    <input type="file" name="structure_pdf" class="w-full border-gray-300 rounded-md shadow-sm" accept=".pdf">
                    <p class="text-xs text-gray-500 mt-1">Format: PDF. Max 5MB. Kosongkan jika tidak ingin mengganti file.</p>
                    @error('structure_pdf') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
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