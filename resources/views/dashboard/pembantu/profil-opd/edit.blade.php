@extends('layouts.dashboard')

@section('title', 'Edit Profil OPD')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Edit Profil OPD</h1>
            <a href="{{ route('dashboard.pembantu') }}" class="text-gray-600 hover:text-gray-800">← Kembali ke Dashboard</a>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 rounded">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('pembantu.profil-opd.update') }}" enctype="multipart/form-data">
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
                        </div>
                    </div>
                </div>

                <!-- Struktur Organisasi -->
                <div class="border-b border-gray-200 pb-4">
                    <h2 class="text-lg font-semibold text-gray-800 mb-4">Struktur Organisasi</h2>
                    <div class="space-y-4">
                        @if($opd->structure_image)
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Struktur Organisasi Saat Ini</label>
                                <img src="{{ Storage::url($opd->structure_image) }}" 
                                    alt="Struktur Organisasi" 
                                    class="w-full max-w-md border rounded-lg shadow-sm"
                                    style="aspect-ratio: 4/3; object-fit: contain;">
                            </div>
                        @endif
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Upload Struktur Organisasi (Rasio 4:3)</label>
                            <input type="file" name="structure_image" class="w-full border-gray-300 rounded-md shadow-sm" accept="image/*">
                            <p class="text-xs text-gray-500 mt-1">Format: JPG, PNG. Max 2MB. Rasio gambar 4:3 (misal: 800x600px)</p>
                        </div>
                    </div>
                </div>

                <!-- Visi & Misi -->
                <div class="border-b border-gray-200 pb-4">
                    <h2 class="text-lg font-semibold text-gray-800 mb-4">Visi & Misi</h2>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Visi</label>
                            <textarea name="vision" rows="3" class="w-full border-gray-300 rounded-md shadow-sm">{{ old('vision', $opd->vision) }}</textarea>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Misi</label>
                            <textarea name="mission" rows="4" class="w-full border-gray-300 rounded-md shadow-sm">{{ old('mission', $opd->mission) }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- Tentang OPD -->
                <div class="border-b border-gray-200 pb-4">
                    <h2 class="text-lg font-semibold text-gray-800 mb-4">Tentang OPD</h2>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Profil Singkat</label>
                            <textarea name="about" rows="4" class="w-full border-gray-300 rounded-md shadow-sm">{{ old('about', $opd->about) }}</textarea>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Alamat Kantor</label>
                            <textarea name="address" rows="2" class="w-full border-gray-300 rounded-md shadow-sm">{{ old('address', $opd->address) }}</textarea>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Google Maps Link (Embed)</label>
                            <input type="text" name="google_maps_link" class="w-full border-gray-300 rounded-md shadow-sm" value="{{ old('google_maps_link', $opd->google_maps_link) }}">
                            <p class="text-xs text-gray-500 mt-1">Masukkan link embed Google Maps</p>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Telepon</label>
                                <input type="text" name="phone" class="w-full border-gray-300 rounded-md shadow-sm" value="{{ old('phone', $opd->phone) }}">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                                <input type="email" name="email" class="w-full border-gray-300 rounded-md shadow-sm" value="{{ old('email', $opd->email) }}">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tugas & Fungsi -->
                <div class="border-b border-gray-200 pb-4">
                    <h2 class="text-lg font-semibold text-gray-800 mb-4">Tugas & Fungsi</h2>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Tugas</label>
                            <textarea name="duties" rows="4" class="w-full border-gray-300 rounded-md shadow-sm">{{ old('duties', $opd->duties) }}</textarea>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Fungsi</label>
                            <textarea name="functions" rows="4" class="w-full border-gray-300 rounded-md shadow-sm">{{ old('functions', $opd->functions) }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- Kontak PPID -->
                <div class="border-b border-gray-200 pb-4">
                    <h2 class="text-lg font-semibold text-gray-800 mb-4">Kontak PPID</h2>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nama PPID</label>
                            <input type="text" name="ppid_name" class="w-full border-gray-300 rounded-md shadow-sm" value="{{ old('ppid_name', $opd->ppid_name) }}">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Telepon PPID</label>
                            <input type="text" name="ppid_phone" class="w-full border-gray-300 rounded-md shadow-sm" value="{{ old('ppid_phone', $opd->ppid_phone) }}">
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-6 flex justify-end space-x-3">
                <a href="{{ route('dashboard.pembantu') }}" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">Batal</a>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>
@endsection