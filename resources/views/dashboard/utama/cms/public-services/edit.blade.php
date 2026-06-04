@extends('layouts.dashboard')

@section('title', 'Edit Layanan Publik')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Edit Layanan Publik</h1>
            <a href="{{ route('utama.cms.public-services.index') }}" class="text-gray-600 hover:text-gray-800">← Kembali</a>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 rounded">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('utama.cms.public-services.update', $service->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="space-y-6">
                <!-- Pilih OPD -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">OPD *</label>
                    <select name="opd_id" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-maroon-500 focus:border-maroon-500" required>
                        <option value="">Pilih OPD</option>
                        @foreach($opds as $opd)
                            <option value="{{ $opd->id }}" {{ old('opd_id', $service->opd_id) == $opd->id ? 'selected' : '' }}>
                                {{ $opd->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('opd_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Nama Layanan -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Layanan *</label>
                    <input type="text" name="name" value="{{ old('name', $service->name) }}" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-maroon-500 focus:border-maroon-500" required>
                    @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Deskripsi -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                    <textarea name="description" rows="3" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-maroon-500 focus:border-maroon-500">{{ old('description', $service->description) }}</textarea>
                    <p class="text-xs text-gray-500 mt-1">Maksimal 500 karakter</p>
                    @error('description') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- URL -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">URL *</label>
                    <input type="url" name="url" value="{{ old('url', $service->url) }}" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-maroon-500 focus:border-maroon-500" required>
                    @error('url') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Icon Saat Ini -->
                @if($service->icon)
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Icon Saat Ini</label>
                    <div class="flex items-center gap-4">
                        <img src="{{ Storage::url($service->icon) }}" class="w-12 h-12 object-contain border rounded p-1">
                        <span class="text-sm text-gray-500">{{ basename($service->icon) }}</span>
                    </div>
                </div>
                @endif

                <!-- Ganti Icon -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Ganti Icon (opsional)</label>
                    <input type="file" name="icon" class="w-full border-gray-300 rounded-md shadow-sm" accept="image/jpeg,image/png,image/jpg">
                    <p class="text-xs text-gray-500 mt-1">Format: JPG, PNG. Maksimal 1MB. Kosongkan jika tidak ingin mengganti.</p>
                    @error('icon') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Sort Order -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Urutan</label>
                    <input type="number" name="sort_order" value="{{ old('sort_order', $service->sort_order) }}" class="w-32 border-gray-300 rounded-md shadow-sm focus:ring-maroon-500 focus:border-maroon-500">
                    @error('sort_order') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Status -->
                <div>
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', $service->is_active) ? 'checked' : '' }} class="rounded border-gray-300 text-maroon-600 focus:ring-maroon-500">
                        <span class="ml-2 text-sm text-gray-700">Aktifkan layanan ini</span>
                    </label>
                </div>
            </div>

            <div class="mt-6 flex justify-end space-x-3">
                <a href="{{ route('utama.cms.public-services.index') }}" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">Batal</a>
                <button type="submit" class="px-4 py-2 bg-maroon-600 text-white rounded-md hover:bg-maroon-700">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>
@endsection