@extends('layouts.dashboard')

@section('title', 'Edit Tugas dan Fungsi OPD')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Edit Tugas dan Fungsi</h1>
            <a href="{{ route('pembantu.cms.profil.index') }}" class="text-gray-600 hover:text-gray-800">← Kembali ke CMS Profil OPD</a>
        </div>

        <form method="POST" action="{{ route('pembantu.cms.profil.update-duties') }}">
            @csrf
            @method('PUT')

            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tugas</label>
                    <textarea name="duties_content" rows="10" class="w-full border-gray-300 rounded-md shadow-sm font-mono text-sm">{{ old('duties_content', $opd->duties_content) }}</textarea>
                    <p class="text-xs text-gray-500 mt-1">Mendukung HTML untuk formatting (gunakan &lt;ul&gt;, &lt;li&gt;, &lt;ol&gt;, &lt;p&gt;, dll)</p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Fungsi</label>
                    <textarea name="functions_content" rows="10" class="w-full border-gray-300 rounded-md shadow-sm font-mono text-sm">{{ old('functions_content', $opd->functions_content) }}</textarea>
                    <p class="text-xs text-gray-500 mt-1">Mendukung HTML untuk formatting</p>
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