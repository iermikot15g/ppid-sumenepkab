@extends('layouts.dashboard')

@section('title', 'Tambah OPD')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white shadow rounded-lg p-6">
        <h1 class="text-2xl font-semibold text-gray-900 mb-6">Tambah OPD Baru</h1>
        
        <form method="POST" action="{{ route('admin.opds.store') }}" enctype="multipart/form-data">
            @csrf
            
            <div class="space-y-4">
                <div>
                    <label class="form-label">Nama OPD <span class="text-red-500">*</span></label>
                    <input type="text" name="name" class="form-input" required value="{{ old('name') }}">
                    @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                
                <div>
                    <label class="form-label">Singkatan</label>
                    <input type="text" name="short_name" class="form-input" value="{{ old('short_name') }}">
                </div>
                
                <div>
                    <label class="form-label">Alamat</label>
                    <textarea name="address" rows="3" class="form-input">{{ old('address') }}</textarea>
                </div>
                
                <div>
                    <label class="form-label">Telepon</label>
                    <input type="text" name="phone" class="form-input" value="{{ old('phone') }}">
                </div>
                
                <div>
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-input" value="{{ old('email') }}">
                </div>
                
                <div>
                    <label class="form-label">Nama PPID</label>
                    <input type="text" name="ppid_name" class="form-input" value="{{ old('ppid_name') }}">
                </div>
                
                <div>
                    <label class="form-label">Telepon PPID</label>
                    <input type="text" name="ppid_phone" class="form-input" value="{{ old('ppid_phone') }}">
                </div>
                
                <div>
                    <label class="form-label">Logo</label>
                    <input type="file" name="logo" class="form-input" accept="image/*">
                    <p class="text-xs text-gray-500 mt-1">Max 2MB, format: JPG, PNG</p>
                </div>
                
                <div>
                    <label class="flex items-center">
                        <input type="checkbox" name="is_active" value="1" checked class="rounded border-gray-300">
                        <span class="ml-2 text-sm text-gray-700">Aktif</span>
                    </label>
                </div>
            </div>
            
            <div class="mt-6 flex justify-end space-x-3">
                <a href="{{ route('admin.opds.index') }}" class="btn-secondary">Batal</a>
                <button type="submit" class="btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>
@endsection