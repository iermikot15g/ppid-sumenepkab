<div class="pt-4 mt-4 border-t border-gray-200">
    <p class="px-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Dashboard Pimpinan OPD</p>
</div>

<!-- Dashboard Monitoring -->
<a href="{{ route('pimpinan.dashboard') }}" class="sidebar-link {{ request()->routeIs('pimpinan.dashboard') ? 'active' : '' }}">
    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
    </svg>
    Dashboard Monitoring
</a>

<!-- Manajemen Dokumen (Read-Only) -->
<a href="{{ route('pimpinan.documents.index') }}" class="sidebar-link {{ request()->routeIs('pimpinan.documents.*') ? 'active' : '' }}">
    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
    </svg>
    Manajemen Dokumen
    <span class="ml-auto text-xs text-gray-400 bg-gray-100 px-1 rounded">Read-only</span>
</a>

<!-- Laporan Statistik (Read-Only) -->
<a href="{{ route('pimpinan.laporan.index') }}" class="sidebar-link {{ request()->routeIs('pimpinan.laporan.*') ? 'active' : '' }}">
    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
    </svg>
    Laporan Statistik
    <span class="ml-auto text-xs text-gray-400 bg-gray-100 px-1 rounded">Read-only</span>
</a>