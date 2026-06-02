@extends('layouts.dashboard')

@section('title', 'Manajemen Hero Slider')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-semibold text-gray-900">Hero Slider</h1>
            <p class="mt-1 text-sm text-gray-600">Kelola slide banner halaman beranda</p>
        </div>
        <a href="{{ route('utama.cms.hero.create') }}" class="btn-primary">
            + Tambah Slide
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
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Gambar</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Judul</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Urutan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200" id="sortable-list">
                    @forelse($slides as $slide)
                    <tr data-id="{{ $slide->id }}" class="cursor-move">
                        <td class="px-6 py-4">
                            <img src="{{ Storage::url($slide->image_path) }}" class="h-16 w-24 object-cover rounded">
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm font-medium text-gray-900">{{ $slide->title ?? 'Tanpa Judul' }}</div>
                            <div class="text-xs text-gray-500">{{ Str::limit($slide->subtitle, 50) }}</div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ $slide->sort_order }}</td>
                        <td class="px-6 py-4">
                            <button onclick="toggleStatus({{ $slide->id }})" 
                                class="px-2 py-1 text-xs rounded-full {{ $slide->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                {{ $slide->is_active ? 'Aktif' : 'Tidak Aktif' }}
                            </button>
                        </td>
                        <td class="px-6 py-4 text-right text-sm">
                            <a href="{{ route('utama.cms.hero.edit', $slide) }}" class="text-maroon-600 hover:text-blue-900 mr-3">Edit</a>
                            <button onclick="deleteSlide({{ $slide->id }})" class="text-red-600 hover:text-red-900">Hapus</button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                            Belum ada slide. Silakan tambah slide baru.
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

<script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
<script>
    // Sortable for drag and drop ordering
    const el = document.getElementById('sortable-list');
    if (el) {
        new Sortable(el, {
            animation: 150,
            onEnd: function() {
                const orders = [];
                document.querySelectorAll('#sortable-list tr').forEach((row, index) => {
                    orders.push({
                        id: row.dataset.id,
                        position: index
                    });
                });
                
                fetch('{{ route("utama.cms.hero.update-order") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ orders: orders })
                });
            }
        });
    }

    function toggleStatus(id) {
        fetch(`/dashboard/utama/cms/hero/${id}/toggle`, {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            }
        });
    }

    function deleteSlide(id) {
        if (confirm('Apakah Anda yakin ingin menghapus slide ini?')) {
            const form = document.getElementById('delete-form');
            form.action = `/dashboard/utama/cms/hero/${id}`;
            form.submit();
        }
    }
</script>
@endsection