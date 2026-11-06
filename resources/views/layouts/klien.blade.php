<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NOMIMOS ORGANIZER - Klien</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('images/nom.png') }}">

    <!-- Tailwind Utility Grid -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&display=swap" rel="stylesheet">

    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="{{ asset('nom.svg') }}">

    <style>
        body {
            font-family: 'Inter', sans-serif !important;
            background-color: #e2e8f0;
        }

        .font-serif-title {
            font-family: 'Playfair Display', Georgia, serif !important;
        }

        /* Prevent layout shift when scrollbar appears */
        html {
            overflow-y: scroll;
        }
    </style>
</head>
<body class="flex flex-col min-h-screen">

    <!-- TOPBAR NAVY (STICKY AT TOP) -->
    <header class="bg-[#1e314b] text-white h-20 px-8 md:px-12 flex justify-between items-center sticky top-0 z-50 shadow-md">
        <a href="{{ route('landing') }}" class="font-serif-title text-3xl font-bold tracking-wider text-white no-underline">
            NOMIMOS
        </a>
        
        <div class="flex items-center gap-4">
            <span class="font-serif-title text-base font-medium hidden sm:inline">
                Halo, {{ Auth::user()->username }}
            </span>

            <!-- TOMBOL KEMBALI KE HOME / LANDING PAGE -->
            <a href="{{ route('landing') }}" 
               class="bg-white/10 hover:bg-white/20 text-white px-4 py-2 rounded-xl text-xs font-semibold transition-all shadow-sm no-underline flex items-center gap-1.5 border border-white/20">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                </svg>
                Kembali ke Home
            </a>

            <!-- TOMBOL LOGOUT (SAMA PERSIS SEPERTI DI LANDING PAGE) -->
            <form action="{{ route('logout') }}" method="POST" class="inline">
                @csrf
                <button type="submit" 
                        class="border border-rose-200 text-rose-300 bg-rose-500/20 hover:bg-rose-600 hover:text-white px-4 py-2 rounded-xl text-xs font-semibold transition-all duration-200 shadow-sm flex items-center gap-1.5">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                    </svg>
                    Logout
                </button>
            </form>
        </div>
    </header>

    <!-- WRAPPER KONTEN UTAMA & SIDEBAR -->
    <div class="flex flex-1 items-stretch">

        <!-- SIDEBAR KLIEN (STICKY STAY ON SCROLL) -->
        <aside class="w-64 bg-white border-r border-slate-200 py-10 px-6 flex flex-col justify-between sticky top-20 h-[calc(100vh-80px)] flex-shrink-0 z-40">
            <nav class="space-y-3 font-serif-title text-lg font-bold">
                <!-- MENU DASHBOARD -->
                <a href="{{ route('klien.dashboard') }}" 
                   class="flex items-center px-4 py-3 rounded-xl transition-all duration-200 no-underline
                   {{ request()->routeIs('klien.dashboard') 
                       ? 'bg-[#1e314b] text-white shadow-sm font-extrabold' 
                       : 'text-slate-600 hover:bg-slate-100 hover:text-[#1e314b]' }}">
                    Dashboard
                </a>

                <!-- MENU KEUANGAN -->
                <a href="{{ route('klien.keuangan') }}" 
                   class="flex items-center px-4 py-3 rounded-xl transition-all duration-200 no-underline
                   {{ request()->routeIs('klien.keuangan') 
                       ? 'bg-[#1e314b] text-white shadow-sm font-extrabold' 
                       : 'text-slate-600 hover:bg-slate-100 hover:text-[#1e314b]' }}">
                    Keuangan
                </a>

                <!-- MENU DETAIL ACARA -->
                <a href="{{ route('klien.detail-acara') }}" 
                   class="flex items-center px-4 py-3 rounded-xl transition-all duration-200 no-underline
                   {{ request()->routeIs('klien.detail-acara') 
                       ? 'bg-[#1e314b] text-white shadow-sm font-extrabold' 
                       : 'text-slate-600 hover:bg-slate-100 hover:text-[#1e314b]' }}">
                    Detail Acara
                </a>
            </nav>

            <!-- FOOTER SIDEBAR / NOMIMOS BRAND -->
            <div class="px-4 text-xs font-sans text-slate-400">
                &copy; {{ date('Y') }} NOMIMOS
            </div>
        </aside>

        <!-- AREA KONTEN UTAMA -->
        <main class="flex-1 bg-[#e2e8f0] p-8 md:p-12 overflow-y-auto">
            @yield('content')
        </main>

    </div>

</body>
</html>