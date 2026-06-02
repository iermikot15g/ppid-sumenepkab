@extends('layouts.dashboard')

@section('title', 'Manajemen Layanan Publik')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-semibold text-gray-900">Layanan Publik OPD</h1>
            <p class="mt-1 text-sm text-gray-600">Kelola website layanan publik OPD Anda</p>
        </div>
        <a href="{{ route('pembantu.cms.services.create') }}" class="px-4 py-2 bg-maroon-600 text-white rounded-md hover:bg-maroon-700">
            + Tambah Layanan
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white shadow rounded-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">#</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama Layanan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">URL</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Urutan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Aksi</th>
                    </td>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($services as $index => $service)
                    <tr>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ $index + 1 }}</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                @if($service->icon)
                                    <img src="{{ Storage::url($service->icon) }}" class="w-6 h-6 rounded">
                                @else
                                    @php
                                        $domain = parse_url($service->url, PHP_URL_HOST) ?: str_replace(['http://', 'https://'], '', $service->url);
                                        $domain = explode('/', $domain)[0];
                                    @endphp
                                    <img src="https://www.google.com/s2/favicons?domain={{ urlencode($domain) }}&sz=32" class="w-6 h-6" onerror="this.style.display='none'">
                                @endif
                                <span class="text-sm font-medium text-gray-900">{{ $service->name }}</span>
                            </div>
                            <div class="text-xs text-gray-500 line-clamp-1">{{ $service->description }}</div>
                        </td>
                        <td class="px-6 py-4 text-sm text-maroon-600 truncate max-w-xs">
                            <a href="{{ $service->url }}" target="_blank" class="hover:underline">{{ Str::limit($service->url, 40) }}</a>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ $service->sort_order }}</td>
                        <td class="px-6 py-4">
                            <button onclick="toggleStatus({{ $service->id }})" 
                                class="px-2 py-1 text-xs rounded-full {{ $service->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                {{ $service->is_active ? 'Aktif' : 'Tidak Aktif' }}
                            </button>
                        </td>
                        <td class="px-6 py-4 text-right text-sm">
                            <a href="{{ route('pembantu.cms.services.edit', $service) }}" class="text-maroon-600 hover:text-blue-900 mr-3">Edit</a>
                            <button onclick="deleteService({{ $service->id }})" class="text-red-600 hover:text-red-900">Hapus</button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                            Belum ada layanan. Silakan tambah layanan publik OPD Anda.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<form id="delete-form" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>

<script>
    function toggleStatus(id) {
        fetch(`/dashboard/pembantu/cms/services/${id}/toggle`, {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) location.reload();
        });
    }

    function deleteService(id) {
        if (confirm('Apakah Anda yakin ingin menghapus layanan ini?')) {
            const form = document.getElementById('delete-form');
            form.action = `/dashboard/pembantu/cms/services/${id}`;
            form.submit();
        }
    }
</script>
@endsection