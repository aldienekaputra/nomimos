<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NOMIMOS ORGANIZER</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('images/nom.png') }}">

    <!-- Tailwind Utility Grid -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&display=swap" rel="stylesheet">

    <!-- STYLE DIRECT LOCK -->
    <style>
        body {
            font-family: 'Inter', sans-serif !important;
            margin: 0;
            padding: 0;
            background-color: #ffffff;
        }

        .font-serif-title {
            font-family: 'Playfair Display', Georgia, serif !important;
        }

        /* TOMBOL CONTACT US BANNER */
        a.btn-contact-us {
            display: inline-block !important;
            background-color: #1e314b !important;
            color: #ffffff !important;
            padding: 12px 48px !important;
            border-radius: 8px !important;
            font-size: 14px !important;
            font-weight: 500 !important;
            text-decoration: none !important;
            transition: all 0.2s ease-in-out !important;
            border: none !important;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1) !important;
        }

        a.btn-contact-us:hover {
            background-color: #112038 !important;
            color: #ffffff !important;
            box-shadow: 0 4px 8px rgba(0,0,0,0.2) !important;
        }
    </style>
</head>
<body class="flex flex-col min-h-screen">

    <!-- NAVBAR HEADER -->
    <header class="bg-white border-b border-gray-100 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-8 h-20 flex justify-between items-center">
            <a href="{{ route('landing') }}" class="font-serif-title text-3xl font-bold text-black tracking-tight no-underline">
                Nomimos
            </a>
            
            <nav class="hidden md:flex space-x-12 text-sm font-normal text-gray-800">
                <a href="{{ route('landing') }}" class="{{ request()->routeIs('landing') ? 'font-semibold text-black' : 'hover:text-blue-900' }} no-underline">Home</a>
                <a href="{{ route('landing.booking') }}" class="{{ request()->routeIs('landing.booking') ? 'font-semibold text-black' : 'hover:text-blue-900' }} no-underline">Booking</a>
                <a href="{{ route('landing.about') }}" class="{{ request()->routeIs('landing.about') ? 'font-semibold text-black' : 'hover:text-blue-900' }} no-underline">About Us</a>
            </nav>

            <div>
                @auth
                    <!-- JIKA SUDAH LOGIN -->
                    <div class="flex items-center gap-3">
                        <!-- TOMBOL DASHBOARD UTAMA -->
                        <a href="{{ Auth::user()->role === 'Admin' ? route('admin.dashboard') : (Auth::user()->role === 'Crew' ? route('crew.dashboard') : route('klien.dashboard')) }}" 
                           class="bg-[#1e314b] text-white px-5 py-2 rounded-xl text-xs font-semibold hover:bg-slate-800 transition-all shadow-sm no-underline flex items-center gap-1.5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                            </svg>
                            Dashboard
                        </a>

                        <!-- TOMBOL LOGOUT (STYLE BUTTON DIPERBAGUS) -->
                        <form action="{{ route('logout') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" 
                                    class="border border-rose-200 text-rose-600 bg-rose-50/50 hover:bg-rose-600 hover:text-white px-4 py-2 rounded-xl text-xs font-semibold transition-all duration-200 shadow-sm flex items-center gap-1.5">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                </svg>
                                Logout
                            </button>
                        </form>
                    </div>
                @else
                    <!-- JIKA BELUM LOGIN -->
                    <a href="{{ route('login') }}" 
                       class="bg-[#e2e8f0] text-[#1e314b] px-6 py-2 rounded-xl text-sm font-semibold hover:bg-[#1e314b] hover:text-white transition-all duration-300 shadow-sm no-underline">
                        Login
                    </a>
                @endauth
            </div>
        </div>
    </header>

    <!-- KONTEN UTAMA HALAMAN -->
    <main class="flex-grow">
        @yield('content')
    </main>

    <!-- BANNER CONTACT US -->
    <section class="py-16 text-center bg-white border-t border-gray-100">
        <h3 class="font-serif-title text-3xl font-normal text-black mb-1">Not sure where to start?</h3>
        <p class="text-xs text-black mb-6">We're here to guide you every step of the way</p>
        <a href="https://wa.me/6282337572928" target="_blank" class="btn-contact-us">
            Contact Us
        </a>
    </section>

    <!-- STYLE ANIMASI MARQUEE FOOTER -->
    <style>
        @keyframes marqueeRight {
            0% { transform: translateX(-50%); }
            100% { transform: translateX(0%); }
        }

        .animate-marquee-right {
            display: inline-flex !important;
            white-space: nowrap !important;
            width: max-content !important;
            animation: marqueeRight 25s linear infinite !important;
            will-change: transform;
        }

        .gallery-marquee-container:hover .animate-marquee-right {
            animation-play-state: paused !important;
        }
    </style>

    <!-- GALLERY RUNNING FOOTER -->
    <section class="bg-white py-6 overflow-hidden gallery-marquee-container">
        <div class="w-full overflow-hidden">
            <div class="animate-marquee-right flex items-center gap-4">
                <div class="w-60 md:w-80 flex-shrink-0">
                    <img src="{{ asset('images/foot1.webp') }}" alt="Portfolio 1" class="w-full h-48 md:h-64 object-cover rounded-2xl shadow-md hover:shadow-xl transition-all duration-300">
                </div>
                <div class="w-60 md:w-80 flex-shrink-0">
                    <img src="{{ asset('images/foot2.webp') }}" alt="Portfolio 2" class="w-full h-48 md:h-64 object-cover rounded-2xl shadow-md hover:shadow-xl transition-all duration-300">
                </div>
                <div class="w-60 md:w-80 flex-shrink-0">
                    <img src="{{ asset('images/foot3.webp') }}" alt="Portfolio 3" class="w-full h-48 md:h-64 object-cover rounded-2xl shadow-md hover:shadow-xl transition-all duration-300">
                </div>
                <div class="w-60 md:w-80 flex-shrink-0">
                    <img src="{{ asset('images/foot4.webp') }}" alt="Portfolio 4" class="w-full h-48 md:h-64 object-cover rounded-2xl shadow-md hover:shadow-xl transition-all duration-300">
                </div>

                <div class="w-60 md:w-80 flex-shrink-0">
                    <img src="{{ asset('images/foot1.webp') }}" alt="Portfolio 1" class="w-full h-48 md:h-64 object-cover rounded-2xl shadow-md hover:shadow-xl transition-all duration-300">
                </div>
                <div class="w-60 md:w-80 flex-shrink-0">
                    <img src="{{ asset('images/foot2.webp') }}" alt="Portfolio 2" class="w-full h-48 md:h-64 object-cover rounded-2xl shadow-md hover:shadow-xl transition-all duration-300">
                </div>
                <div class="w-60 md:w-80 flex-shrink-0">
                    <img src="{{ asset('images/foot3.webp') }}" alt="Portfolio 3" class="w-full h-48 md:h-64 object-cover rounded-2xl shadow-md hover:shadow-xl transition-all duration-300">
                </div>
                <div class="w-60 md:w-80 flex-shrink-0">
                    <img src="{{ asset('images/foot4.webp') }}" alt="Portfolio 4" class="w-full h-48 md:h-64 object-cover rounded-2xl shadow-md hover:shadow-xl transition-all duration-300">
                </div>
            </div>
        </div>
    </section>

    <!-- FOOTER NAVY -->
    <footer style="background-color: #1e314b;" class="text-white py-5">
        <div class="max-w-7xl mx-auto px-8 flex justify-between items-center text-xs text-gray-200">
            <span class="font-serif-title text-2xl font-bold text-white">Nomimos</span>
            <span>&copy; 2025. NOMIMOS. All rights reserved.</span>
            <a href="https://www.instagram.com/nomimos.organizer" target="_blank" class="text-white hover:opacity-80">
                <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
            </a>
        </div>
    </footer>

</body>
</html>