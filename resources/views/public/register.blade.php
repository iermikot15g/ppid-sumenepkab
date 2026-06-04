@extends('layouts.app')

@section('title', 'Daftar Akun')

@section('content')
<div class="bg-gray-50 min-h-screen py-12">
    <div class="container mx-auto px-4 max-w-4xl">
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="bg-maroon-600 px-6 py-4">
                <h1 class="text-2xl font-bold text-white">Daftar Akun Baru</h1>
                <p class="text-maroon-100 text-sm mt-1">Silakan isi data diri Anda untuk mendaftar</p>
            </div>

            <div class="p-6">
                @if($errors->any())
                    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded">
                        <ul class="list-disc list-inside">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <!-- Informasi Login -->
                    <div class="border-b border-gray-200 pb-6 mb-6">
                        <h2 class="text-lg font-semibold text-gray-800 mb-4">Informasi Login</h2>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap *</label>
                                <input type="text" name="name" value="{{ old('name') }}" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-maroon-500 focus:border-maroon-500" required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Email Aktif *</label>
                                <input type="email" name="email" value="{{ old('email') }}" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-maroon-500 focus:border-maroon-500" required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">No. Kontak *</label>
                                <input type="tel" name="phone" value="{{ old('phone') }}" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-maroon-500 focus:border-maroon-500" required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Password *</label>
                                <input type="password" name="password" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-maroon-500 focus:border-maroon-500" required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password *</label>
                                <input type="password" name="password_confirmation" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-maroon-500 focus:border-maroon-500" required>
                            </div>
                        </div>
                    </div>

                    <!-- Informasi Pribadi -->
                    <div class="border-b border-gray-200 pb-6 mb-6">
                        <h2 class="text-lg font-semibold text-gray-800 mb-4">Informasi Pribadi</h2>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">NIK (16 digit) *</label>
                                <input type="text" name="nik" value="{{ old('nik') }}" maxlength="16" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-maroon-500 focus:border-maroon-500" required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Kelamin *</label>
                                <select name="gender" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-maroon-500 focus:border-maroon-500" required>
                                    <option value="">Pilih</option>
                                    <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Laki-laki</option>
                                    <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Perempuan</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Lahir *</label>
                                <input type="date" name="birth_date" value="{{ old('birth_date') }}" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-maroon-500 focus:border-maroon-500" required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Pendidikan Terakhir *</label>
                                <select name="education" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-maroon-500 focus:border-maroon-500" required>
                                    <option value="">Pilih</option>
                                    <option value="SD" {{ old('education') == 'SD' ? 'selected' : '' }}>SD</option>
                                    <option value="SMP" {{ old('education') == 'SMP' ? 'selected' : '' }}>SMP</option>
                                    <option value="SMA" {{ old('education') == 'SMA' ? 'selected' : '' }}>SMA</option>
                                    <option value="D1-D4" {{ old('education') == 'D1-D4' ? 'selected' : '' }}>D1-D4</option>
                                    <option value="S1" {{ old('education') == 'S1' ? 'selected' : '' }}>S1</option>
                                    <option value="S2" {{ old('education') == 'S2' ? 'selected' : '' }}>S2</option>
                                    <option value="S3" {{ old('education') == 'S3' ? 'selected' : '' }}>S3</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Pekerjaan *</label>
                                <input type="text" name="occupation" value="{{ old('occupation') }}" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-maroon-500 focus:border-maroon-500" required>
                            </div>
                        </div>
                    </div>

                    <!-- Alamat -->
                    <div class="border-b border-gray-200 pb-6 mb-6">
                        <h2 class="text-lg font-semibold text-gray-800 mb-4">Alamat</h2>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Provinsi *</label>
                                <select name="province_id" id="province_id" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-maroon-500 focus:border-maroon-500" required>
                                    <option value="">Pilih Provinsi</option>
                                    @foreach($provinces as $province)
                                        <option value="{{ $province->id }}" {{ old('province_id', 35) == $province->id ? 'selected' : '' }}>
                                            {{ $province->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Kabupaten/Kota *</label>
                                <select name="regency_id" id="regency_id" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-maroon-500 focus:border-maroon-500" required>
                                    <option value="">Pilih Kabupaten/Kota</option>
                                    @foreach($regencies as $regency)
                                        <option value="{{ $regency->id }}" {{ old('regency_id', 3529) == $regency->id ? 'selected' : '' }}>
                                            {{ $regency->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Kecamatan *</label>
                                <select name="district_id" id="district_id" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-maroon-500 focus:border-maroon-500" required>
                                    <option value="">Pilih Kecamatan</option>
                                    @foreach($districts as $district)
                                        <option value="{{ $district->id }}" {{ old('district_id') == $district->id ? 'selected' : '' }}>
                                            {{ $district->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Alamat Lengkap *</label>
                                <textarea name="address" rows="3" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-maroon-500 focus:border-maroon-500" required>{{ old('address') }}</textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="flex justify-between items-center">
                        <a href="{{ route('login') }}" class="text-gray-600 hover:text-gray-800">Sudah punya akun? Login</a>
                        <button type="submit" class="bg-maroon-600 hover:bg-maroon-700 text-white px-6 py-2 rounded-lg">
                            Daftar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // Dynamic dropdown untuk kabupaten dan kecamatan
    document.getElementById('province_id').addEventListener('change', function() {
        var provinceId = this.value;
        var regencySelect = document.getElementById('regency_id');
        var districtSelect = document.getElementById('district_id');
        
        // Reset dropdown
        regencySelect.innerHTML = '<option value="">Loading...</option>';
        districtSelect.innerHTML = '<option value="">Pilih Kecamatan</option>';
        
        if (provinceId) {
            fetch(`/api/regencies/${provinceId}`)
                .then(response => response.json())
                .then(data => {
                    regencySelect.innerHTML = '<option value="">Pilih Kabupaten/Kota</option>';
                    data.forEach(regency => {
                        regencySelect.innerHTML += `<option value="${regency.id}">${regency.name}</option>`;
                    });
                });
        } else {
            regencySelect.innerHTML = '<option value="">Pilih Kabupaten/Kota</option>';
        }
    });
    
    document.getElementById('regency_id').addEventListener('change', function() {
        var regencyId = this.value;
        var districtSelect = document.getElementById('district_id');
        
        districtSelect.innerHTML = '<option value="">Loading...</option>';
        
        if (regencyId) {
            fetch(`/api/districts/${regencyId}`)
                .then(response => response.json())
                .then(data => {
                    districtSelect.innerHTML = '<option value="">Pilih Kecamatan</option>';
                    data.forEach(district => {
                        districtSelect.innerHTML += `<option value="${district.id}">${district.name}</option>`;
                    });
                });
        } else {
            districtSelect.innerHTML = '<option value="">Pilih Kecamatan</option>';
        }
    });
</script>
@endsection