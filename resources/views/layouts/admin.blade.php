<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NOMIMOS - @yield('title', 'Admin Dashboard')</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('images/nom.png') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .font-serif-title { font-family: 'Playfair Display', serif; }
    </style>
</head>
<body class="bg-[#e9eff6] h-screen flex flex-col overflow-hidden">

    <!-- HEADER / NAVBAR ATAS (STICKY / FIXED DI ATAS) -->
    <header class="bg-[#1e314b] text-white px-8 py-4 flex justify-between items-center shadow-md border-b border-slate-700/50 shrink-0 z-10">
        <div class="flex items-center gap-3">
            <h1 class="font-serif-title text-2xl font-bold tracking-wider text-white">NOMIMOS</h1>
        </div>

        <div class="flex items-center gap-6">
            <!-- PENGGUNA -->
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 rounded-full bg-slate-700 flex items-center justify-center text-xs font-bold text-white border border-slate-500">
                    {{ strtoupper(substr(Auth::user()->username ?? 'A', 0, 1)) }}
                </div>
                <span class="font-serif-title text-sm font-medium text-gray-200">
                    Halo, <strong class="text-white">{{ Auth::user()->username ?? 'Admin Nomimos' }}</strong>
                </span>
            </div>

            <!-- BUTTON LOGOUT ELEGAN -->
            <form action="{{ route('logout') }}" method="POST" class="inline">
                @csrf
                <button type="submit" 
                        class="flex items-center gap-2 bg-red-500/10 hover:bg-red-600 text-red-300 hover:text-white px-4 py-1.5 rounded-full border border-red-500/30 hover:border-red-600 text-xs font-semibold transition-all duration-200 shadow-sm group">
                    <svg class="w-3.5 h-3.5 text-red-400 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                    </svg>
                    <span>Logout</span>
                </button>
            </form>
        </div>
    </header>

    <!-- CONTAINER UTAMA -->
    <div class="flex-1 flex overflow-hidden">

        <!-- SIDEBAR NAVIGATION -->
        <aside class="w-64 bg-white min-h-screen p-6 space-y-3 shadow-sm border-r border-gray-100">
            <nav class="space-y-2">
                <!-- Dashboard -->
                <a href="{{ route('admin.dashboard') }}" 
                class="flex items-center px-4 py-3 rounded-xl font-bold text-sm transition-all duration-200 
                        {{ request()->routeIs('admin.dashboard') 
                            ? 'bg-[#1e314b] text-white shadow-md shadow-[#1e314b]/20 scale-[1.02]' 
                            : 'text-gray-700 hover:bg-[#1e314b]/10 hover:text-[#1e314b] hover:translate-x-1' }}">
                    Dashboard
                </a>

                <!-- Klien / Event -->
                <a href="{{ route('admin.klien') }}" 
                class="flex items-center px-4 py-3 rounded-xl font-bold text-sm transition-all duration-200 
                        {{ request()->routeIs('admin.klien') 
                            ? 'bg-[#1e314b] text-white shadow-md shadow-[#1e314b]/20 scale-[1.02]' 
                            : 'text-gray-700 hover:bg-[#1e314b]/10 hover:text-[#1e314b] hover:translate-x-1' }}">
                    Klien / Event
                </a>

                <!-- Vendor -->
                <a href="{{ route('admin.vendor') }}" 
                class="flex items-center px-4 py-3 rounded-xl font-bold text-sm transition-all duration-200 
                        {{ request()->routeIs('admin.vendor') 
                            ? 'bg-[#1e314b] text-white shadow-md shadow-[#1e314b]/20 scale-[1.02]' 
                            : 'text-gray-700 hover:bg-[#1e314b]/10 hover:text-[#1e314b] hover:translate-x-1' }}">
                    Vendor
                </a>

                <!-- Keuangan -->
                <a href="{{ route('admin.keuangan') }}" 
                class="flex items-center px-4 py-3 rounded-xl font-bold text-sm transition-all duration-200 
                        {{ request()->routeIs('admin.keuangan') 
                            ? 'bg-[#1e314b] text-white shadow-md shadow-[#1e314b]/20 scale-[1.02]' 
                            : 'text-gray-700 hover:bg-[#1e314b]/10 hover:text-[#1e314b] hover:translate-x-1' }}">
                    Keuangan
                </a>

                <!-- Crew -->
                <a href="{{ route('admin.crew') }}" 
                class="flex items-center px-4 py-3 rounded-xl font-bold text-sm transition-all duration-200 
                        {{ request()->routeIs('admin.crew') 
                            ? 'bg-[#1e314b] text-white shadow-md shadow-[#1e314b]/20 scale-[1.02]' 
                            : 'text-gray-700 hover:bg-[#1e314b]/10 hover:text-[#1e314b] hover:translate-x-1' }}">
                    Crew
                </a>

                <!-- User -->
                <a href="{{ route('admin.user') }}" 
                class="flex items-center px-4 py-3 rounded-xl font-bold text-sm transition-all duration-200 
                        {{ request()->routeIs('admin.user') 
                            ? 'bg-[#1e314b] text-white shadow-md shadow-[#1e314b]/20 scale-[1.02]' 
                            : 'text-gray-700 hover:bg-[#1e314b]/10 hover:text-[#1e314b] hover:translate-x-1' }}">
                    User
                </a>
            </nav>
        </aside>

        <!-- AREA KONTEN (HANYA BAGIAN INI YANG BISA DI-SCROLL) -->
        <div class="flex-1 flex overflow-hidden">
            @yield('content')
        </div>

    </div>

</body>
</html>