{{-- resources/views/layouts/dashboard.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dashboard - @yield('title', 'PPID Kabupaten Sumenep')</title>
    @vite(['resources/css/app.css'])
    @stack('styles')
</head>
<body class="font-sans antialiased bg-gray-100">
    <div class="min-h-screen">
        @include('partials.dashboard-top-nav')
        
        <div class="flex">
            @include('partials.dashboard-sidebar')
            
            {{-- TAMBAHKAN class "pt-16" agar konten tidak tertutup header --}}
            <div class="flex-1 lg:ml-64 pt-16">
                <div class="py-6 px-4 sm:px-6 lg:px-8">
                    @yield('content')
                </div>
            </div>
        </div>
    </div>
    
    @vite(['resources/js/app.js'])
    @stack('scripts')
</body>
</html>