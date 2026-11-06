<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - NOMIMOS</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    <style>
        .font-serif-title {
            font-family: 'Playfair Display', Georgia, serif;
        }
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>
<body class="bg-gray-50 min-h-screen flex flex-col justify-center items-center py-12 px-4 sm:px-6 lg:px-8">

    <!-- WRAPPER UTAMA -->
    <div class="max-w-4xl w-full space-y-6">
        
        <!-- CARD CONTAINER BERBAYANG -->
        <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden grid md:grid-cols-2">
            
            <!-- SISI KIRI: FORM SIGN UP -->
            <div class="p-8 sm:p-10 md:p-12 flex flex-col justify-between space-y-6">
                <!-- LOGO -->
                <div>
                    <a href="{{ route('landing.home') }}" class="font-serif-title text-2xl font-bold tracking-wider text-black block hover:opacity-80 transition-opacity">
                        Nomimos
                    </a>
                </div>

                <!-- FORM UTAMA -->
                <div class="space-y-6">
                    <div>
                        <h2 class="font-serif-title text-2xl md:text-3xl font-bold text-black mb-1">Sign Up to NOMIMOS</h2>
                        <p class="text-xs md:text-sm text-gray-500">Please enter your details to access your wedding dashboard.</p>
                    </div>

                    <form action="{{ route('register') }}" method="POST" class="space-y-4">
                        @csrf

                        <!-- Nama Pria & Wanita (2 Kolom) -->
                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 mb-1">Nama Mempelai Pria</label>
                                <input type="text" name="nama_pria" required placeholder="Contoh: El Rumi"
                                    class="w-full px-3 py-2 border border-slate-300 rounded-xl text-xs focus:ring-2 focus:ring-[#1e314b] outline-none">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 mb-1">Nama Mempelai Wanita</label>
                                <input type="text" name="nama_wanita" required placeholder="Contoh: Syifa Hadju"
                                    class="w-full px-3 py-2 border border-slate-300 rounded-xl text-xs focus:ring-2 focus:ring-[#1e314b] outline-none">
                            </div>
                        </div>

                        <!-- No. HP -->
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">No. HP / WhatsApp</label>
                            <input type="text" name="no_hp" required placeholder="08438436843683"
                                class="w-full px-3 py-2 border border-slate-300 rounded-xl text-xs focus:ring-2 focus:ring-[#1e314b] outline-none">
                        </div>

                        <!-- Alamat -->
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Alamat</label>
                            <input type="text" name="alamat" required placeholder="Jl. Soekarno Hatta No. 12, Malang"
                                class="w-full px-3 py-2 border border-slate-300 rounded-xl text-xs focus:ring-2 focus:ring-[#1e314b] outline-none">
                        </div>

                        <!-- Username -->
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Username</label>
                            <input type="text" name="username" required placeholder="syifahadju"
                                class="w-full px-3 py-2 border border-slate-300 rounded-xl text-xs focus:ring-2 focus:ring-[#1e314b] outline-none">
                        </div>

                        <!-- Password -->
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Password</label>
                            <input type="password" name="password" required placeholder="••••••••"
                                class="w-full px-3 py-2 border border-slate-300 rounded-xl text-xs focus:ring-2 focus:ring-[#1e314b] outline-none">
                        </div>

                        <button type="submit" class="w-full bg-[#1e314b] text-white py-2.5 rounded-xl text-xs font-semibold hover:bg-slate-800 transition-all shadow-md">
                            Sign Up
                        </button>
                    </form>
                </div>

                <!-- FOOTER CARD BAWAH -->
                <div class="pt-4 border-t border-gray-100">
                    <p class="text-xs text-gray-400 leading-relaxed">
                        Let's talk about your dream wedding. Schedule a free consultation with our wedding specialists today.
                    </p>
                </div>
            </div>

            <!-- SISI KANAN: GAMBAR MEMPELAI BANNER -->
            <div class="hidden md:block relative bg-gray-100">
                <img src="{{ asset('images/foot3.webp') }}" 
                     alt="NOMIMOS Wedding" 
                     class="absolute inset-0 w-full h-full">
            </div>

        </div>

        <!-- BUTTON KEMBALI KE HALAMAN UTAMA -->
        <div class="text-center">
            <a href="{{ route('landing.home') }}" class="inline-flex items-center text-sm text-gray-500 hover:text-[#1e314b] font-medium transition-colors gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Kembali ke Beranda
            </a>
        </div>

    </div>

</body>
</html>