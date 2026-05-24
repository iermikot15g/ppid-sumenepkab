@extends('layouts.dashboard')

@section('title', 'Upload Dokumen DIP')

@section('content')
<div class="max-w-3xl mx-auto py-6">
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold text-gray-800">📄 Upload Dokumen Baru</h1>
            <a href="{{ route('pembantu.documents.index') }}" class="text-gray-600 hover:text-gray-800">← Kembali</a>
        </div>

        <form method="POST" action="{{ route('pembantu.documents.store') }}" enctype="multipart/form-data">
            @csrf

            <div class="space-y-4">
                <!-- Judul -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Judul Dokumen <span class="text-red-500">*</span></label>
                    <input type="text" name="title" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                </div>

                <!-- Deskripsi -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                    <textarea name="description" rows="4" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500"></textarea>
                </div>

                <!-- Kategori & Sub Kategori -->
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Kategori <span class="text-red-500">*</span></label>
                        <select name="category_id" id="category_id" class="w-full border-gray-300 rounded-md shadow-sm" required>
                            <option value="">Pilih Kategori</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Sub Kategori</label>
                        <select name="sub_category_id" id="sub_category_id" class="w-full border-gray-300 rounded-md shadow-sm">
                            <option value="">Pilih Sub Kategori</option>
                        </select>
                    </div>
                </div>

                <!-- Tahun & Nomor Dokumen -->
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tahun <span class="text-red-500">*</span></label>
                        <select name="year" class="w-full border-gray-300 rounded-md shadow-sm" required>
                            <option value="">Pilih Tahun</option>
                            @for($year = date('Y'); $year >= 2000; $year--)
                                <option value="{{ $year }}">{{ $year }}</option>
                            @endfor
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nomor Dokumen</label>
                        <input type="text" name="doc_number" class="w-full border-gray-300 rounded-md shadow-sm" placeholder="Contoh: 001/DISKOMINFO/2024">
                    </div>
                </div>

                <!-- Pejabat -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Pejabat Penguasa Informasi</label>
                    <input type="text" name="officer_name" class="w-full border-gray-300 rounded-md shadow-sm">
                </div>

                <!-- Klasifikasi & Status -->
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Klasifikasi <span class="text-red-500">*</span></label>
                        <select name="classification" class="w-full border-gray-300 rounded-md shadow-sm" required>
                            <option value="open">Terbuka (Dapat Diunduh)</option>
                            <option value="excluded">Dikecualikan (Hanya Info)</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Status Publikasi <span class="text-red-500">*</span></label>
                        <select name="status" class="w-full border-gray-300 rounded-md shadow-sm" required>
                            <option value="published">Published (Langsung Tampil)</option>
                            <option value="unpublished">Unpublished (Tidak Tampil)</option>
                        </select>
                    </div>
                </div>

                <!-- File -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">File Dokumen <span class="text-red-500">*</span></label>
                    <input type="file" name="file" class="w-full border-gray-300 rounded-md shadow-sm" accept=".pdf,.jpg,.jpeg,.png" required>
                    <p class="text-xs text-gray-500 mt-1">Format: PDF, JPG, JPEG, PNG. Maks 25MB</p>
                </div>
            </div>

            <div class="mt-6 flex justify-end space-x-3">
                <a href="{{ route('pembantu.documents.index') }}" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">Batal</a>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">Upload Dokumen</button>
            </div>
        </form>
    </div>
</div>

<script>
    const subCategories = @json($categories->mapWithKeys(function($category) {
        return [$category->id => $category->subCategories];
    }));

    document.getElementById('category_id').addEventListener('change', function() {
        const categoryId = this.value;
        const subSelect = document.getElementById('sub_category_id');
        subSelect.innerHTML = '<option value="">Pilih Sub Kategori</option>';
        if (categoryId && subCategories[categoryId]) {
            subCategories[categoryId].forEach(sub => {
                const option = document.createElement('option');
                option.value = sub.id;
                option.textContent = sub.name;
                subSelect.appendChild(option);
            });
        }
    });
</script>
@endsection