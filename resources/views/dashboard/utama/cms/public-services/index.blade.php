@extends('layouts.dashboard')

@section('title', 'Kelola Layanan Publik - Semua OPD')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-semibold text-gray-900">Kelola Layanan Publik</h1>
            <p class="mt-1 text-sm text-gray-600">Kelola layanan publik untuk semua OPD</p>
        </div>
        <a href="{{ route('utama.cms.public-services.create') }}" class="bg-maroon-600 hover:bg-maroon-700 text-white px-4 py-2 rounded-lg">
            + Tambah Layanan
        </a>
    </div>

    <!-- Tabel Layanan -->
    <div class="bg-white shadow rounded-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Icon</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">OPD</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama Layanan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">URL</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($services as $service)
                    <tr>
                        <td class="px-6 py-4">
                            @if($service->icon)
                                <img src="{{ Storage::url($service->icon) }}" class="w-8 h-8 object-contain">
                            @else
                                <div class="w-8 h-8 bg-gray-100 rounded flex items-center justify-center">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.66 0 3-4 3-9s-1.34-9-3-9m0 18c-1.66 0-3-4-3-9s1.34-9 3-9" />
                                    </svg>
                                </div>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-900">{{ $service->opd->name ?? '-' }}</td>
                        <td class="px-6 py-4">
                            <div class="text-sm font-medium text-gray-900">{{ $service->name }}</div>
                            @if($service->description)
                                <div class="text-xs text-gray-500">{{ Str::limit($service->description, 50) }}</div>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <a href="{{ $service->url }}" target="_blank" class="text-sm text-blue-600 hover:underline truncate max-w-xs block">
                                {{ Str::limit($service->url, 40) }}
                            </a>
                        </td>
                        <td class="px-6 py-4">
                            <button onclick="toggleStatus({{ $service->id }})" class="px-2 py-1 text-xs rounded-full {{ $service->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                {{ $service->is_active ? 'Aktif' : 'Nonaktif' }}
                            </button>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <a href="{{ route('utama.cms.public-services.edit', $service->id) }}" class="text-blue-600 hover:text-blue-900 mr-3">Edit</a>
                            <button onclick="confirmDelete({{ $service->id }})" class="text-red-600 hover:text-red-900">Hapus</button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                            Belum ada layanan publik. Klik "Tambah Layanan" untuk membuat baru.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <!--
        <div class="px-6 py-4 border-t">
            {{ $services->links() }}
        </div>
        -->
    </div>
</div>

<script>
function toggleStatus(id) {
    fetch(`/dashboard/utama/cms/public-services/${id}/toggle`, {
        method: 'PATCH',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json'
        }
    }).then(response => response.json()).then(data => {
        if (data.success) {
            window.location.reload();
        }
    });
}

function confirmDelete(id) {
    if (confirm('Apakah Anda yakin ingin menghapus layanan ini?')) {
        fetch(`/dashboard/utama/cms/public-services/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            }
        }).then(response => {
            if (response.ok) {
                window.location.reload();
            }
        });
    }
}
</script>
@endsection