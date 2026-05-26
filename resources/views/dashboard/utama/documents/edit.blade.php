@extends('layouts.dashboard')

@section('title', 'Edit Dokumen - Manajemen Global')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Edit Dokumen</h1>
            <a href="{{ route('utama.documents.index') }}" class="text-gray-600 hover:text-gray-800">← Kembali</a>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 rounded">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('utama.documents.update', $document) }}">
            @csrf
            @method('PUT')

            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">OPD</label>
                    <input type="text" class="w-full border-gray-300 rounded-md shadow-sm bg-gray-100" 
                           value="{{ $document->opd->name ?? '-' }}" readonly disabled>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Judul Dokumen <span class="text-red-500">*</span></label>
                    <input type="text" name="title" class="w-full border-gray-300 rounded-md shadow-sm" 
                           value="{{ old('title', $document->title) }}" required>
                    @error('title') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                    <textarea name="description" rows="4" class="w-full border-gray-300 rounded-md shadow-sm">{{ old('description', $document->description) }}</textarea>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Kategori <span class="text-red-500">*</span></label>
                        <select name="category_id" id="category_id" class="w-full border-gray-300 rounded-md shadow-sm" required>
                            <option value="">Pilih Kategori</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id', $document->category_id) == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Sub Kategori</label>
                        <select name="sub_category_id" id="sub_category_id" class="w-full border-gray-300 rounded-md shadow-sm">
                            <option value="">Pilih Sub Kategori</option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tahun <span class="text-red-500">*</span></label>
                        <select name="year" class="w-full border-gray-300 rounded-md shadow-sm" required>
                            <option value="">Pilih Tahun</option>
                            @for($year = date('Y'); $year >= 2000; $year--)
                                <option value="{{ $year }}" {{ old('year', $document->year) == $year ? 'selected' : '' }}>{{ $year }}</option>
                            @endfor
                        </select>
                        @error('year') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nomor Dokumen</label>
                        <input type="text" name="doc_number" class="w-full border-gray-300 rounded-md shadow-sm" 
                               value="{{ old('doc_number', $document->doc_number) }}">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Pejabat Penguasa Informasi</label>
                    <input type="text" name="officer_name" class="w-full border-gray-300 rounded-md shadow-sm" 
                           value="{{ old('officer_name', $document->officer_name) }}">
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Klasifikasi <span class="text-red-500">*</span></label>
                        <select name="classification" class="w-full border-gray-300 rounded-md shadow-sm" required>
                            <option value="open" {{ old('classification', $document->classification) == 'open' ? 'selected' : '' }}>Terbuka (Dapat Diunduh)</option>
                            <option value="excluded" {{ old('classification', $document->classification) == 'excluded' ? 'selected' : '' }}>Dikecualikan (Hanya Info)</option>
                        </select>
                        @error('classification') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Status Publikasi <span class="text-red-500">*</span></label>
                        <select name="status" class="w-full border-gray-300 rounded-md shadow-sm" required>
                            <option value="published" {{ old('status', $document->status) == 'published' ? 'selected' : '' }}>Published (Tampil di Portal)</option>
                            <option value="unpublished" {{ old('status', $document->status) == 'unpublished' ? 'selected' : '' }}>Unpublished (Tidak Tampil)</option>
                            <option value="archived" {{ old('status', $document->status) == 'archived' ? 'selected' : '' }}>Archived (Diarsipkan)</option>
                        </select>
                        @error('status') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                @if($document->force_unpublished_by)
                    <div class="bg-yellow-50 border-l-4 border-yellow-500 p-4">
                        <p class="text-sm text-yellow-700">
                            <strong>Dokumen ini di-force unpublish oleh:</strong> {{ $document->forceUnpublishedBy->name ?? 'Unknown' }}<br>
                            <strong>Alasan:</strong> {{ $document->force_unpublished_reason ?? 'Tidak disebutkan' }}
                        </p>
                    </div>
                @endif

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">File Saat Ini</label>
                    <a href="{{ Storage::url($document->file_path) }}" target="_blank" class="text-blue-600 hover:underline">
                        {{ basename($document->file_path) }}
                    </a>
                    <p class="text-xs text-gray-500 mt-1">{{ round($document->file_size / 1024, 2) }} KB</p>
                </div>
            </div>

            <div class="mt-6 flex justify-end space-x-3">
                <a href="{{ route('utama.documents.index') }}" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">Batal</a>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

<script>
    const subCategories = @json($categories->mapWithKeys(function($category) {
        return [$category->id => $category->subCategories];
    }));
    const currentSubCategoryId = {{ $document->sub_category_id ?? 'null' }};

    document.getElementById('category_id').addEventListener('change', function() {
        const categoryId = this.value;
        const subSelect = document.getElementById('sub_category_id');
        subSelect.innerHTML = '<option value="">Pilih Sub Kategori</option>';
        if (categoryId && subCategories[categoryId]) {
            subCategories[categoryId].forEach(sub => {
                const option = document.createElement('option');
                option.value = sub.id;
                option.textContent = sub.name;
                if (currentSubCategoryId === sub.id) {
                    option.selected = true;
                }
                subSelect.appendChild(option);
            });
        }
    });

    // Trigger on page load
    document.getElementById('category_id').dispatchEvent(new Event('change'));
</script>
@endsection