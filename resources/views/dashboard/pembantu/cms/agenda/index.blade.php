@extends('layouts.dashboard')

@section('title', 'Manajemen Agenda')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-semibold text-gray-900">Agenda Kegiatan</h1>
            <p class="mt-1 text-sm text-gray-600">Kelola agenda kegiatan OPD Anda</p>
        </div>
        <a href="{{ route('pembantu.cms.agenda.create') }}" class="px-4 py-2 bg-maroon-600 text-white rounded-md hover:bg-maroon-700">
            + Tambah Agenda
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
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Judul</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Lokasi</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($agendas as $item)
                    <tr>
                        <td class="px-6 py-4 text-sm text-gray-900">{{ Str::limit($item->title, 50) }}</td>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ \Carbon\Carbon::parse($item->event_date)->format('d/m/Y') }}</td>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ $item->location ?? '-' }}</td>
                        <td class="px-6 py-4">
                            <button onclick="toggleStatus({{ $item->id }})" 
                                class="px-2 py-1 text-xs rounded-full {{ $item->is_published ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                {{ $item->is_published ? 'Published' : 'Draft' }}
                            </button>
                        </td>
                        <td class="px-6 py-4 text-right text-sm">
                            <a href="{{ route('pembantu.cms.agenda.edit', $item->id) }}" class="text-maroon-600 hover:text-blue-900 mr-3">Edit</a>
                            <button onclick="deleteAgenda({{ $item->id }})" class="text-red-600 hover:text-red-900">Hapus</button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                            Belum ada agenda. Silakan tambah agenda pertama.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4">
            {{ $agendas->links() }}
        </div>
    </div>
</div>

<form id="delete-form" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>

<script>
    function toggleStatus(id) {
        fetch(`/dashboard/pembantu/cms/agenda/${id}/toggle`, {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) location.reload();
        })
        .catch(error => console.error('Error:', error));
    }

    function deleteAgenda(id) {
        if (confirm('Apakah Anda yakin ingin menghapus agenda ini?')) {
            const form = document.getElementById('delete-form');
            form.action = `/dashboard/pembantu/cms/agenda/${id}`;
            form.submit();
        }
    }
</script>
@endsection