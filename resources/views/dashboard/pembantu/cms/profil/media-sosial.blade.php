@extends('layouts.dashboard')

@section('title', 'Edit Media Sosial OPD')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Edit Media Sosial</h1>
            <a href="{{ route('pembantu.cms.profil.index') }}" class="text-gray-600 hover:text-gray-800">← Kembali ke CMS Profil OPD</a>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 rounded">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('pembantu.cms.profil.update-media-sosial') }}">
            @csrf
            @method('PUT')

            <div class="space-y-4">
                <div class="bg-blue-50 p-4 rounded-lg mb-4">
                    <p class="text-sm text-blue-700">
                        <svg class="inline w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Masukkan URL lengkap media sosial OPD Anda. Isi hanya yang tersedia.
                    </p>
                </div>

                <!-- Facebook -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        <span class="text-blue-700">📘 Facebook</span>
                    </label>
                    <input type="url" name="facebook" class="w-full border-gray-300 rounded-md shadow-sm" 
                           value="{{ old('facebook', $socialMedia['facebook'] ?? '') }}" 
                           placeholder="https://facebook.com/opdanda">
                </div>

                <!-- Instagram -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        <span class="text-pink-600">📷 Instagram</span>
                    </label>
                    <input type="url" name="instagram" class="w-full border-gray-300 rounded-md shadow-sm" 
                           value="{{ old('instagram', $socialMedia['instagram'] ?? '') }}" 
                           placeholder="https://instagram.com/opdanda">
                </div>

                <!-- Twitter / X -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        <span class="text-blue-400">🐦 Twitter / X</span>
                    </label>
                    <input type="url" name="twitter" class="w-full border-gray-300 rounded-md shadow-sm" 
                           value="{{ old('twitter', $socialMedia['twitter'] ?? '') }}" 
                           placeholder="https://twitter.com/opdanda">
                </div>

                <!-- YouTube -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        <span class="text-red-600">▶️ YouTube</span>
                    </label>
                    <input type="url" name="youtube" class="w-full border-gray-300 rounded-md shadow-sm" 
                           value="{{ old('youtube', $socialMedia['youtube'] ?? '') }}" 
                           placeholder="https://youtube.com/@opdanda">
                </div>

                <!-- TikTok -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        <span class="text-black">🎵 TikTok</span>
                    </label>
                    <input type="url" name="tiktok" class="w-full border-gray-300 rounded-md shadow-sm" 
                           value="{{ old('tiktok', $socialMedia['tiktok'] ?? '') }}" 
                           placeholder="https://tiktok.com/@opdanda">
                </div>

                <!-- WhatsApp -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        <span class="text-green-600">💬 WhatsApp</span>
                    </label>
                    <input type="url" name="whatsapp" class="w-full border-gray-300 rounded-md shadow-sm" 
                           value="{{ old('whatsapp', $socialMedia['whatsapp'] ?? '') }}" 
                           placeholder="https://wa.me/6281234567890">
                    <p class="text-xs text-gray-500 mt-1">Format: https://wa.me/6281234567890</p>
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