@extends('layouts.dashboard')

@section('title', 'Edit OPD')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Edit OPD</h1>
            <a href="{{ route('admin.opds.index') }}" class="text-gray-600 hover:text-gray-800">← Kembali</a>
        </div>

        <form method="POST" action="{{ route('admin.opds.update', $opd) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama OPD <span class="text-red-500">*</span></label>
                    <input type="text" name="name" class="w-full border-gray-300 rounded-md shadow-sm" 
                           value="{{ old('name', $opd->name) }}" required>
                    @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Singkatan</label>
                    <input type="text" name="short_name" class="w-full border-gray-300 rounded-md shadow-sm" 
                           value="{{ old('short_name', $opd->short_name) }}">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Alamat</label>
                    <textarea name="address" rows="3" class="w-full border-gray-300 rounded-md shadow-sm">{{ old('address', $opd->address) }}</textarea>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Telepon</label>
                        <input type="text" name="phone" class="w-full border-gray-300 rounded-md shadow-sm" 
                               value="{{ old('phone', $opd->phone) }}">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <input type="email" name="email" class="w-full border-gray-300 rounded-md shadow-sm" 
                               value="{{ old('email', $opd->email) }}">
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama PPID</label>
                        <input type="text" name="ppid_name" class="w-full border-gray-300 rounded-md shadow-sm" 
                               value="{{ old('ppid_name', $opd->ppid_name) }}">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Telepon PPID</label>
                        <input type="text" name="ppid_phone" class="w-full border-gray-300 rounded-md shadow-sm" 
                               value="{{ old('ppid_phone', $opd->ppid_phone) }}">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Logo Saat Ini</label>
                    @if($opd->logo)
                        <img src="{{ Storage::url($opd->logo) }}" class="h-20 w-auto object-cover rounded mb-2">
                    @else
                        <p class="text-gray-500 text-sm">Tidak ada logo</p>
                    @endif
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Ganti Logo</label>
                    <input type="file" name="logo" class="w-full border-gray-300 rounded-md shadow-sm" accept="image/*">
                    <p class="text-xs text-gray-500 mt-1">Kosongkan jika tidak ingin mengganti logo. Max 2MB</p>
                </div>

                <div>
                    <label class="flex items-center">
                        <input type="checkbox" name="is_active" value="1" class="rounded border-gray-300" 
                               {{ $opd->is_active ? 'checked' : '' }}>
                        <span class="ml-2 text-sm text-gray-700">Aktif</span>
                    </label>
                </div>
            </div>

            <div class="mt-6 flex justify-end space-x-3">
                <a href="{{ route('admin.opds.index') }}" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">Batal</a>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>
@endsection