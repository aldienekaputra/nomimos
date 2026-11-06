<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - NOMIMOS</title>
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
        
        <!-- CARD CONTAINER BERBAYANG (BG WHITE, SHADOW-XL) -->
        <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden grid md:grid-cols-2">
            
            <!-- SISI KIRI: FORM LOGIN -->
            <div class="p-8 sm:p-10 md:p-12 flex flex-col justify-between space-y-6">
                <!-- LOGO -->
                <div>
                    <a href="{{ route('landing') }}" class="font-serif-title text-2xl font-bold tracking-wider text-black block hover:opacity-80 transition-opacity">
                        Nomimos
                    </a>
                </div>

                <!-- PERIKSA TAG FORM INI -->
                <form action="{{ route('login') }}" method="POST" class="space-y-5">
                    @csrf <!-- WAJIB ADA AGAR TIDAK REFLECTION EXPIRED -->

                    <div>
                        <h2 class="font-serif-title text-2xl md:text-3xl font-bold text-black mb-1">Welcome Back to NOMIMOS</h2>
                        <p class="text-xs md:text-sm text-gray-500">Please enter your details to access your wedding dashboard.</p>
                    </div>
                    
                    <!-- ALERT ERROR DI DALAM FORM -->
                    @if ($errors->any())
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-xl text-xs">
                            {{ $errors->first() }}
                        </div>
                    @endif

                    <!-- USERNAME -->
                    <div>
                        <label for="username" class="block font-serif-title text-sm font-bold text-black mb-1.5">Username</label>
                        <input type="text" id="username" name="username" value="{{ old('username') }}" required autofocus
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:outline-none focus:border-[#1e314b] text-sm transition-colors">
                    </div>

                    <!-- PASSWORD -->
                    <div>
                        <label for="password" class="block font-serif-title text-sm font-bold text-black mb-1.5">Password</label>
                        <input type="password" id="password" name="password" required
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:outline-none focus:border-[#1e314b] text-sm transition-colors">
                    </div>

                    <div class="text-xs text-gray-500">
                        Don't have an account? 
                        <a href="{{ route('register') }}" class="text-blue-600 font-semibold underline hover:text-blue-800 transition-colors">
                            Sign Up
                        </a>
                    </div>

                    <!-- TOMBOL SUBMIT (PASTIKAN type="submit") -->
                    <div class="space-y-4 pt-2">
                        <button type="submit" 
                                class="bg-[#1e314b] text-white px-8 py-2.5 rounded-lg text-sm font-semibold tracking-wide hover:bg-slate-800 transition-colors duration-200">
                            Login
                        </button>
                    </div>
                </form>

                <!-- FOOTER CARD BAWAH -->
                <div class="pt-4 border-t border-gray-100">
                    <p class="text-xs text-gray-400 leading-relaxed">
                        Let's talk about your dream wedding. Schedule a free consultation with our wedding specialists today.
                    </p>
                </div>
            </div>

            <!-- SISI KANAN: GAMBAR MEMPELAI (MENYESUAIKAN TINGGI CARD) -->
            <div class="hidden md:block relative bg-gray-100">
                <img src="{{ asset('images/foot1.webp') }}" 
                     alt="NOMIMOS Wedding" 
                     class="absolute inset-0 w-full h-full object-cover">
            </div>

        </div>

        <!-- BUTTON KEMBALI KE HALAMAN UTAMA (DI BAWAH CARD) -->
        <div class="text-center">
            <a href="{{ route('landing') }}" class="inline-flex items-center text-sm text-gray-500 hover:text-[#1e314b] font-medium transition-colors gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Kembali ke Beranda
            </a>
        </div>

    </div>

    <!-- ALERT PESAN ERROR ATAU SUKSES -->
    @if ($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-xl text-xs mb-4">
            {{ $errors->first() }}
        </div>
    @endif

    @if (session('success'))
        <div class="bg-green-50 border border-green-200 text-green-600 px-4 py-3 rounded-xl text-xs mb-4">
            {{ session('success') }}
        </div>
    @endif
    
</body>
</html>