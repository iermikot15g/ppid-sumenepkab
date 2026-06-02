@extends('layouts.dashboard')

@section('title', 'Tambah Desa')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Tambah Desa Baru</h1>
            <a href="{{ route('admin.villages.index') }}" class="text-gray-600 hover:text-gray-800">← Kembali</a>
        </div>

        <form method="POST" action="{{ route('admin.villages.store') }}" enctype="multipart/form-data">
            @csrf

            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Desa <span class="text-red-500">*</span></label>
                    <input type="text" name="name" class="w-full border-gray-300 rounded-md shadow-sm" value="{{ old('name') }}" required>
                    @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Kepala Desa</label>
                    <input type="text" name="head_name" class="w-full border-gray-300 rounded-md shadow-sm" value="{{ old('head_name') }}">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Alamat Kantor Desa</label>
                    <textarea name="address" rows="3" class="w-full border-gray-300 rounded-md shadow-sm">{{ old('address') }}</textarea>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Telepon</label>
                        <input type="text" name="phone" class="w-full border-gray-300 rounded-md shadow-sm" value="{{ old('phone') }}">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <input type="email" name="email" class="w-full border-gray-300 rounded-md shadow-sm" value="{{ old('email') }}">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Logo Desa</label>
                    <input type="file" name="logo" class="w-full border-gray-300 rounded-md shadow-sm" accept="image/*">
                    <p class="text-xs text-gray-500 mt-1">Max 2MB, format: JPG, PNG</p>
                </div>

                <div>
                    <label class="flex items-center">
                        <input type="checkbox" name="is_active" value="1" class="rounded border-gray-300" checked>
                        <span class="ml-2 text-sm text-gray-700">Aktif</span>
                    </label>
                </div>
            </div>

            <div class="mt-6 flex justify-end space-x-3">
                <a href="{{ route('admin.villages.index') }}" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">Batal</a>
                <button type="submit" class="px-4 py-2 bg-maroon-600 text-white rounded-md hover:bg-maroon-700">Simpan</button>
            </div>
        </form>
    </div>
</div>
@endsection