{{-- resources/views/admin/audit-logs/index.blade.php --}}
@extends('layouts.dashboard')

@section('title', 'Audit Log')

@section('content')
<div class="space-y-6">
    <div>
        <h1 class="text-2xl font-semibold text-gray-900">Audit Log</h1>
        <p class="mt-1 text-sm text-gray-600">Riwayat aktivitas pengguna sistem</p>
    </div>

    <div class="bg-white shadow rounded-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Waktu</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">User</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Deskripsi</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">IP Address</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($logs as $log)
                    <tr>
                        <td class="px-6 py-4 text-sm text-gray-500">
                            {{ $log->created_at->format('d/m/Y H:i:s') }}
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-900">
                            {{ $log->user->name ?? 'System' }}
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 text-xs rounded-full 
                                {{ str_contains($log->action, 'create') ? 'bg-green-100 text-green-800' : 
                                   (str_contains($log->action, 'delete') ? 'bg-red-100 text-red-800' : 'bg-blue-100 text-blue-800') }}">
                                {{ $log->action }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500">
                            {{ $log->description }}
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500">
                            {{ $log->ip_address }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                            Belum ada aktivitas.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4">
            {{ $logs->links() }}
        </div>
    </div>
</div>
@endsection