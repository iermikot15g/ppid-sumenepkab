@extends('layouts.dashboard')

@section('title', 'Manajemen Desa')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-semibold text-gray-900">Manajemen Desa</h1>
            <p class="mt-1 text-sm text-gray-600">Kelola data desa/PPID Desa</p>
        </div>
        <a href="{{ route('admin.villages.create') }}" class="btn-primary">
            + Tambah Desa
        </a>
    </div>

    <div class="bg-white shadow rounded-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama Desa</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kepala Desa</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kontak</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($villages as $village)
                    <tr>
                        <td class="px-6 py-4 text-sm font-medium text-gray-900">
                            {{ $village->name }}
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500">
                            {{ $village->head_name ?? '-' }}
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500">
                            {{ $village->phone ?? '-' }}<br>
                            {{ $village->email ?? '-' }}
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 text-xs rounded-full {{ $village->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $village->is_active ? 'Aktif' : 'Tidak Aktif' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right text-sm">
                            <a href="{{ route('admin.villages.edit', $village) }}" class="text-maroon-600 hover:text-blue-900 mr-3">Edit</a>
                            <button type="button" 
                                    onclick="deleteVillage({{ $village->id }})" 
                                    class="text-red-600 hover:text-red-900">
                                Hapus
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                            Belum ada data desa.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4">
            {{ $villages->links() }}
        </div>
    </div>
</div>

<form id="delete-form" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>

<script>
    function deleteVillage(id) {
        if (confirm('Apakah Anda yakin ingin menghapus desa ini?')) {
            const form = document.getElementById('delete-form');
            form.action = `/dashboard/admin/villages/${id}`;
            form.submit();
        }
    }
</script>
@endsection