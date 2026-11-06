<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NOMIMOS ORGANIZER - Crew</title>
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

        html {
            overflow-y: scroll;
        }
    </style>
</head>
<body class="flex flex-col min-h-screen">

    <!-- TOPBAR NAVY (STICKY) -->
    <header class="bg-[#1e314b] text-white h-20 px-8 md:px-12 flex justify-between items-center sticky top-0 z-50 shadow-md">
        <a href="{{ route('landing') }}" class="font-serif-title text-3xl font-bold tracking-wider text-white no-underline">
            NOMIMOS
        </a>
        
        <div class="flex items-center gap-6">
            <span class="font-serif-title text-base font-medium">
                Halo, {{ Auth::user()->username }} (Crew)
            </span>
            <form action="{{ route('logout') }}" method="POST" class="inline">
                @csrf
                <button type="submit" class="text-xs bg-white/10 hover:bg-white/20 text-white px-4 py-2 rounded-lg transition-all font-semibold">
                    Logout
                </button>
            </form>
        </div>
    </header>

    <!-- AREA KONTEN UTAMA -->
    <main class="flex-1 bg-[#e2e8f0] p-6 md:p-12 overflow-y-auto">
        @yield('content')
    </main>

</body>
</html>