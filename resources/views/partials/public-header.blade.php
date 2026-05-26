<header class="bg-white shadow-sm sticky top-0 z-50">
    <nav class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16 lg:h-20">
            <!-- Logo -->
            <a href="{{ route('home') }}" class="flex items-center space-x-3">
                <div class="h-10 w-10 bg-blue-700 rounded-lg flex items-center justify-center">
                    <span class="text-white text-xs font-bold">PPID</span>
                </div>
                <div class="hidden sm:block">
                    <h1 class="text-lg font-bold text-blue-900 lg:text-xl">PPID Kabupaten Sumenep</h1>
                    <p class="text-xs text-gray-500">Pejabat Pengelola Informasi dan Dokumentasi</p>
                </div>
            </a>
            
            <!-- Mobile menu button -->
            <div class="lg:hidden">
                <button id="mobile-menu-toggle" type="button" class="text-gray-500 hover:text-gray-600 focus:outline-none">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
            
            <!-- Desktop Navigation -->
            <div class="hidden lg:flex lg:items-center lg:space-x-8">
                <a href="{{ route('home') }}" class="text-gray-700 hover:text-blue-600 {{ request()->routeIs('home') ? 'text-blue-600 font-semibold' : '' }}">Beranda</a>
                
                <!-- Profil Dropdown -->
                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open" class="flex items-center text-gray-700 hover:text-blue-600 focus:outline-none">
                        Profil
                        <svg class="ml-1 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-show="open" @click.away="open = false" x-transition class="absolute left-0 mt-2 w-56 bg-white rounded-md shadow-lg py-1 z-10 border border-gray-200" style="display: none;">
                        <a href="{{ route('profil.show', 'tentang-ppid') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Tentang PPID</a>
                        <a href="{{ route('profil.show', 'visi-misi') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Visi Misi</a>
                        <a href="{{ route('profil.show', 'dasar-hukum') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Dasar Hukum</a>
                        <a href="{{ route('profil.show', 'tugas-fungsi') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Tugas dan Fungsi</a>
                        <a href="{{ route('profil.show', 'struktur') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Struktur Organisasi</a>
                    </div>
                </div>
                
                <!-- Standar Layanan Dropdown -->
                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open" class="flex items-center text-gray-700 hover:text-blue-600 focus:outline-none">
                        Standar Layanan
                        <svg class="ml-1 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-show="open" @click.away="open = false" x-transition class="absolute left-0 mt-2 w-64 bg-white rounded-md shadow-lg py-1 z-10 border border-gray-200" style="display: none;">
                        <a href="{{ route('standar-layanan.show', 'maklumat') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Maklumat Pelayanan</a>
                        <a href="{{ route('standar-layanan.show', 'prosedur') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Prosedur Permohonan Informasi</a>
                        <a href="{{ route('standar-layanan.show', 'keberatan') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Prosedur Pengajuan Keberatan</a>
                        <a href="{{ route('standar-layanan.show', 'sengketa') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Prosedur Sengketa Informasi</a>
                        <a href="{{ route('standar-layanan.show', 'jalur-waktu') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Jalur dan Waktu Layanan</a>
                        <a href="{{ route('standar-layanan.show', 'biaya') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Biaya Layanan</a>
                    </div>
                </div>
                
                <!-- DIP Dropdown -->
                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open" class="flex items-center text-gray-700 hover:text-blue-600 focus:outline-none">
                        Daftar Informasi Publik
                        <svg class="ml-1 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-show="open" @click.away="open = false" x-transition class="absolute left-0 mt-2 w-64 bg-white rounded-md shadow-lg py-1 z-10 border border-gray-200" style="display: none;">
                        <a href="{{ route('dip.index', ['category' => 'all']) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Semua Informasi</a>
                        <hr class="my-1">
                        <a href="{{ route('dip.index', ['category' => 'berkala']) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Informasi Berkala</a>
                        <a href="{{ route('dip.index', ['category' => 'serta-merta']) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Informasi Serta-Merta</a>
                        <a href="{{ route('dip.index', ['category' => 'setiap-saat']) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Informasi Setiap Saat</a>
                        <a href="{{ route('dip.index', ['category' => 'dikecualikan']) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Informasi Dikecualikan</a>
                    </div>
                </div>
                
                <a href="{{ route('direktori.opd') }}" class="text-gray-700 hover:text-blue-600 {{ request()->routeIs('direktori.opd*') ? 'text-blue-600 font-semibold' : '' }}">PPID Pembantu</a>
                <a href="{{ route('direktori.desa') }}" class="text-gray-700 hover:text-blue-600 {{ request()->routeIs('direktori.desa*') ? 'text-blue-600 font-semibold' : '' }}">PPID Desa</a>
            </div>
            
            <!-- Auth Buttons -->
            <div class="hidden lg:flex items-center space-x-4">
                @auth
                    @if(auth()->user()->hasRole(['super_admin', 'ppid_utama', 'ppid_pembantu', 'pimpinan']))
                        <a href="{{ auth()->user()->hasRole('ppid_pembantu') ? '/dashboard/pembantu' : '/dashboard/utama' }}" class="px-4 py-2 text-sm font-medium text-blue-600 border border-blue-600 rounded-md hover:bg-blue-50">
                            Dashboard
                        </a>
                    @endif
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-md hover:bg-red-700">
                            Logout
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="px-4 py-2 text-sm font-medium text-blue-600 border border-blue-600 rounded-md hover:bg-blue-50">
                        Login
                    </a>
                    <a href="{{ route('register') }}" class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700">
                        Daftar
                    </a>
                @endauth
            </div>
        </div>
        
        <!-- Mobile Navigation Menu -->
        <div id="mobile-menu" class="hidden lg:hidden py-4 border-t border-gray-200">
            <div class="space-y-2">
                <a href="{{ route('home') }}" class="block px-3 py-2 text-base text-gray-700 hover:bg-gray-100 rounded-md">Beranda</a>
                
                <!-- Mobile Profil -->
                <div x-data="{ open: false }" class="block">
                    <button @click="open = !open" class="flex items-center justify-between w-full px-3 py-2 text-base text-gray-700 hover:bg-gray-100 rounded-md">
                        Profil
                        <svg :class="{'rotate-180': open}" class="h-4 w-4 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-show="open" class="pl-4 space-y-1" style="display: none;">
                        <a href="{{ route('profil.show', 'tentang-ppid') }}" class="block px-3 py-2 text-sm text-gray-600 hover:bg-gray-100 rounded-md">Tentang PPID</a>
                        <a href="{{ route('profil.show', 'visi-misi') }}" class="block px-3 py-2 text-sm text-gray-600 hover:bg-gray-100 rounded-md">Visi Misi</a>
                        <a href="{{ route('profil.show', 'dasar-hukum') }}" class="block px-3 py-2 text-sm text-gray-600 hover:bg-gray-100 rounded-md">Dasar Hukum</a>
                        <a href="{{ route('profil.show', 'tugas-fungsi') }}" class="block px-3 py-2 text-sm text-gray-600 hover:bg-gray-100 rounded-md">Tugas dan Fungsi</a>
                        <a href="{{ route('profil.show', 'struktur') }}" class="block px-3 py-2 text-sm text-gray-600 hover:bg-gray-100 rounded-md">Struktur Organisasi</a>
                    </div>
                </div>
                
                <!-- Mobile Standar Layanan -->
                <div x-data="{ open: false }" class="block">
                    <button @click="open = !open" class="flex items-center justify-between w-full px-3 py-2 text-base text-gray-700 hover:bg-gray-100 rounded-md">
                        Standar Layanan
                        <svg :class="{'rotate-180': open}" class="h-4 w-4 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-show="open" class="pl-4 space-y-1" style="display: none;">
                        <a href="{{ route('standar-layanan.show', 'maklumat') }}" class="block px-3 py-2 text-sm text-gray-600 hover:bg-gray-100 rounded-md">Maklumat Pelayanan</a>
                        <a href="{{ route('standar-layanan.show', 'prosedur') }}" class="block px-3 py-2 text-sm text-gray-600 hover:bg-gray-100 rounded-md">Prosedur Permohonan Informasi</a>
                        <a href="{{ route('standar-layanan.show', 'keberatan') }}" class="block px-3 py-2 text-sm text-gray-600 hover:bg-gray-100 rounded-md">Prosedur Pengajuan Keberatan</a>
                        <a href="{{ route('standar-layanan.show', 'sengketa') }}" class="block px-3 py-2 text-sm text-gray-600 hover:bg-gray-100 rounded-md">Prosedur Sengketa Informasi</a>
                        <a href="{{ route('standar-layanan.show', 'jalur-waktu') }}" class="block px-3 py-2 text-sm text-gray-600 hover:bg-gray-100 rounded-md">Jalur dan Waktu Layanan</a>
                        <a href="{{ route('standar-layanan.show', 'biaya') }}" class="block px-3 py-2 text-sm text-gray-600 hover:bg-gray-100 rounded-md">Biaya Layanan</a>
                    </div>
                </div>
                
                <!-- Mobile DIP -->
                <div x-data="{ open: false }" class="block">
                    <button @click="open = !open" class="flex items-center justify-between w-full px-3 py-2 text-base text-gray-700 hover:bg-gray-100 rounded-md">
                        Daftar Informasi Publik
                        <svg :class="{'rotate-180': open}" class="h-4 w-4 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-show="open" class="pl-4 space-y-1" style="display: none;">
                        <a href="{{ route('dip.index', ['category' => 'all']) }}" class="block px-3 py-2 text-sm text-gray-600 hover:bg-gray-100 rounded-md">Semua Informasi</a>
                        <hr class="my-1">
                        <a href="{{ route('dip.index', ['category' => 'berkala']) }}" class="block px-3 py-2 text-sm text-gray-600 hover:bg-gray-100 rounded-md">Informasi Berkala</a>
                        <a href="{{ route('dip.index', ['category' => 'serta-merta']) }}" class="block px-3 py-2 text-sm text-gray-600 hover:bg-gray-100 rounded-md">Informasi Serta-Merta</a>
                        <a href="{{ route('dip.index', ['category' => 'setiap-saat']) }}" class="block px-3 py-2 text-sm text-gray-600 hover:bg-gray-100 rounded-md">Informasi Setiap Saat</a>
                        <a href="{{ route('dip.index', ['category' => 'dikecualikan']) }}" class="block px-3 py-2 text-sm text-gray-600 hover:bg-gray-100 rounded-md">Informasi Dikecualikan</a>
                    </div>
                </div>
                
                <a href="{{ route('direktori.opd') }}" class="block px-3 py-2 text-base text-gray-700 hover:bg-gray-100 rounded-md">PPID Pembantu</a>
                <a href="{{ route('direktori.desa') }}" class="block px-3 py-2 text-base text-gray-700 hover:bg-gray-100 rounded-md">PPID Desa</a>
                
                <hr class="my-2">
                
                @auth
                    @if(auth()->user()->hasRole(['super_admin', 'ppid_utama', 'ppid_pembantu', 'pimpinan']))
                        <a href="{{ auth()->user()->hasRole('ppid_pembantu') ? '/dashboard/pembantu' : '/dashboard/utama' }}" class="block px-3 py-2 text-base text-blue-600 hover:bg-gray-100 rounded-md">Dashboard</a>
                    @endif
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="block w-full text-left px-3 py-2 text-base text-red-600 hover:bg-gray-100 rounded-md">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="block px-3 py-2 text-base text-blue-600 hover:bg-gray-100 rounded-md">Login</a>
                    <a href="{{ route('register') }}" class="block px-3 py-2 text-base text-white bg-blue-600 rounded-md text-center">Daftar</a>
                @endauth
            </div>
        </div>
    </nav>
</header>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const mobileToggle = document.getElementById('mobile-menu-toggle');
        const mobileMenu = document.getElementById('mobile-menu');
        
        if (mobileToggle && mobileMenu) {
            mobileToggle.addEventListener('click', function() {
                mobileMenu.classList.toggle('hidden');
            });
        }
    });
</script>