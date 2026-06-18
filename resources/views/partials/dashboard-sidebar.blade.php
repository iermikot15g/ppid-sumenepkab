<aside class="fixed inset-y-0 left-0 z-30 w-64 transform -translate-x-full bg-white border-r border-gray-200 lg:translate-x-0 transition-transform duration-300 ease-in-out">
    <div class="h-full flex flex-col">
        <!-- Logo -->
        <div class="flex items-center justify-center h-16 px-4 border-b border-gray-200">
            <div class="h-8 w-8 bg-maroon-700 rounded-lg flex items-center justify-center">
                <span class="text-white text-xs font-bold">PPID</span>
            </div>
            <span class="ml-2 text-lg font-semibold text-gray-800">PPID Sumenep</span>
        </div>
        
        <!-- Navigation -->
        <nav class="flex-1 px-2 py-4 space-y-1 overflow-y-auto">
            @php
                $user = auth()->user();
                $roles = $user->roles->pluck('name')->toArray();
            @endphp

            @if(in_array('super_admin', $roles))
                @include('partials.sidebar.super-admin')
            @elseif(in_array('ppid_utama', $roles))
                @include('partials.sidebar.utama')
            @elseif(in_array('ppid_pembantu', $roles))
                @include('partials.sidebar.pembantu')
            @elseif(in_array('pimpinan', $roles))
                @include('partials.sidebar.pimpinan')
            @endif
        </nav>
        
        <!-- Logout -->
        <div class="p-4 border-t border-gray-200">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="flex items-center w-full px-2 py-2 text-sm text-gray-700 rounded-lg hover:bg-gray-100 transition-colors duration-150">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                    </svg>
                    Logout
                </button>
            </form>
        </div>
    </div>
</aside>

<style>
    .sidebar-link {
        @apply flex items-center px-2 py-2 text-sm font-medium text-gray-700 rounded-lg transition-colors duration-150 hover:bg-gray-100;
    }
    .sidebar-link.active {
        @apply bg-maroon-50 text-maroon-700;
    }
    .sidebar-link svg {
        @apply mr-3 h-5 w-5;
    }
</style>