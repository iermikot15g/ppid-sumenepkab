@extends('layouts.dashboard')

@section('title', 'Manajemen OPD')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-semibold text-gray-900">Manajemen OPD</h1>
            <p class="mt-1 text-sm text-gray-600">Kelola data OPD/PPID Pembantu</p>
        </div>
        <a href="{{ route('admin.opds.create') }}" class="btn-primary">
            + Tambah OPD
        </a>
    </div>

    <div class="bg-white shadow rounded-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Logo</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama OPD</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kontak</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Dokumen</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($opds as $opd)
                    <tr>
                        <td class="px-6 py-4">
                            @if($opd->logo)
                                <img src="{{ Storage::url($opd->logo) }}" class="h-8 w-8 object-cover rounded-full">
                            @else
                                <div class="h-8 w-8 bg-gray-200 rounded-full flex items-center justify-center">
                                    <span class="text-xs text-gray-500">-</span>
                                </div>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm font-medium text-gray-900">{{ $opd->name }}</div>
                            <div class="text-xs text-gray-500">{{ $opd->short_name }}</div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500">
                            {{ $opd->phone ?? '-' }}<br>
                            {{ $opd->email ?? '-' }}
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500">
                            {{ $opd->documents_count }} dokumen
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 text-xs rounded-full {{ $opd->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $opd->is_active ? 'Aktif' : 'Tidak Aktif' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right text-sm">
                            <a href="{{ route('admin.opds.edit', $opd) }}" class="text-maroon-600 hover:text-blue-900 mr-3">Edit</a>
                            <button type="button" 
                                    onclick="deleteOpd({{ $opd->id }})" 
                                    class="text-red-600 hover:text-red-900">
                                Hapus
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                            Belum ada data OPD.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4">
            {{ $opds->links() }}
        </div>
    </div>
</div>

<form id="delete-form" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>

<script>
    function deleteOpd(id) {
        if (confirm('Apakah Anda yakin ingin menghapus OPD ini?')) {
            const form = document.getElementById('delete-form');
            form.action = `/dashboard/admin/opds/${id}`;
            form.submit();
        }
    }
</script>
@endsection