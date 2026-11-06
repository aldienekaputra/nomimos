@extends('layouts.landing')

@section('content')
<!-- HERO SECTION -->
<section class="relative h-[520px] md:h-[580px] flex items-end p-8 md:p-16 overflow-hidden">
    <!-- GAMBAR FOTO LOKAL (MEMENUHI BACKGROUND) -->
    <img src="{{ asset('images/banner1.webp') }}" 
         alt="Nomimos Organizer Banner" 
         class="absolute inset-0 w-full h-full object-cover">

    <!-- OVERLAY GELAP -->
    <div class="absolute inset-0 bg-black/40"></div>

    <!-- KONTEN TEKS UTAMA -->
    <div class="relative z-10 text-white max-w-4xl space-y-2">
        <span class="text-sm font-semibold uppercase tracking-widest text-gray-200">#BeHappy</span>
        <h1 class="font-serif-title text-4xl sm:text-5xl md:text-6xl font-bold tracking-wider leading-tight drop-shadow-md">
            NOMIMOS<br>ORGANIZER
        </h1>
    </div>
</section> 

<!-- DESCRIPTION SECTION -->
<section class="py-20 bg-white">
    <div class="max-w-4xl mx-auto px-6 text-center space-y-6">
        <p class="text-gray-800 text-xl md:text-2xl leading-relaxed font-serif-title font-medium">
            Established in 2016 Nomimos Organizer is a premier wedding organizer dedicated to crafting exceptional, timeless celebration experiences.
        </p>
        <p class="text-gray-600 text-base md:text-lg max-w-2xl mx-auto leading-relaxed">
            We have a solid foundation built on meticulous planning, creative ingenuity, and a heartfelt commitment to turning your dream wedding into reality.
        </p>
    </div>
</section>

<!-- STYLE ANIMASI MARQUEE PORTOFOLIO -->
<style>
    @keyframes portfolioMarquee {
        0% {
            transform: translateX(0%);
        }
        100% {
            transform: translateX(-50%);
        }
    }

    .animate-portfolio-marquee {
        display: inline-flex !important;
        white-space: nowrap !important;
        width: max-content !important;
        animation: portfolioMarquee 25s linear infinite !important;
        will-change: transform;
    }

    /* Efek pause saat kursor di-hover agar user bisa melihat gambar */
    .portfolio-marquee-container:hover .animate-portfolio-marquee {
        animation-play-state: paused !important;
    }
</style>

<!-- PORTOFOLIO RUNNING SLIDER -->
<section class="py-16 bg-white overflow-hidden portfolio-marquee-container">
    <div class="w-full overflow-hidden">
        <div class="animate-portfolio-marquee flex items-center gap-6">
            
            <!-- GRUP 1 -->
            <div class="w-72 md:w-96 flex-shrink-0">
                <img src="{{ asset('images/porto1.webp') }}" alt="Portfolio 1" class="w-full h-48 md:h-64 object-cover rounded-2xl shadow-md hover:shadow-xl transition-all duration-300">
            </div>
            <div class="w-72 md:w-96 flex-shrink-0">
                <img src="{{ asset('images/porto3.webp') }}" alt="Portfolio 3" class="w-full h-48 md:h-64 object-cover rounded-2xl shadow-md hover:shadow-xl transition-all duration-300">
            </div>
            <div class="w-72 md:w-96 flex-shrink-0">
                <img src="{{ asset('images/porto4.webp') }}" alt="Portfolio 4" class="w-full h-48 md:h-64 object-cover rounded-2xl shadow-md hover:shadow-xl transition-all duration-300">
            </div>
            <div class="w-72 md:w-96 flex-shrink-0">
                <img src="{{ asset('images/porto6.webp') }}" alt="Portfolio 4" class="w-full h-48 md:h-64 object-cover rounded-2xl shadow-md hover:shadow-xl transition-all duration-300">
            </div>

            <!-- GRUP 2 (DUPLIKASI WAJIB UNTUK MENGHUBUNGKAN LOOP SEAMLESS) -->
            <div class="w-72 md:w-96 flex-shrink-0">
                <img src="{{ asset('images/porto1.webp') }}" alt="Portfolio 1" class="w-full h-48 md:h-64 object-cover rounded-2xl shadow-md hover:shadow-xl transition-all duration-300">
            </div>
            <div class="w-72 md:w-96 flex-shrink-0">
                <img src="{{ asset('images/porto3.webp') }}" alt="Portfolio 3" class="w-full h-48 md:h-64 object-cover rounded-2xl shadow-md hover:shadow-xl transition-all duration-300">
            </div>
            <div class="w-72 md:w-96 flex-shrink-0">
                <img src="{{ asset('images/porto4.webp') }}" alt="Portfolio 4" class="w-full h-48 md:h-64 object-cover rounded-2xl shadow-md hover:shadow-xl transition-all duration-300">
            </div>
            <div class="w-72 md:w-96 flex-shrink-0">
                <img src="{{ asset('images/porto6.webp') }}" alt="Portfolio 4" class="w-full h-48 md:h-64 object-cover rounded-2xl shadow-md hover:shadow-xl transition-all duration-300">
            </div>

        </div>
    </div>
</section>

<!-- BANNER QUOTE -->
<section style="background-color: #1e314b !important;" class="text-white py-24 text-center my-16 shadow-inner">
    <div class="max-w-3xl mx-auto px-6 space-y-6">
        <h2 class="font-serif-title text-2xl md:text-4xl leading-snug text-white font-semibold">
            From heartfelt gatherings to grand celebrations, honoring every culture and style.
        </h2>
        <p class="font-serif-title text-gray-200 text-base md:text-lg italic tracking-wide">
            Here are memories we've shaped into timeless beauty
        </p>
    </div>
</section>

<!-- TESTIMONIALS SECTION -->
<section class="py-16 bg-white">
    <div class="max-w-6xl mx-auto px-6 grid md:grid-cols-2 gap-12 items-start">
        <!-- JUDUL TESTIMONI -->
        <div class="space-y-4 pt-4 border-r-0 md:border-r border-gray-200 md:pr-12">
            <h3 class="font-serif-title text-3xl md:text-4xl font-bold leading-snug text-[#1e314b]">
                Moment come and go but<br>the feeling stay
            </h3>
            <p class="text-sm md:text-base text-gray-500 font-normal">
                Here's what our clients say about working with Nomimos.
            </p>
        </div>

        <!-- LIST CARD TESTIMONI -->
        <div class="space-y-8">
            <div class="space-y-4 bg-gray-50 p-6 rounded-2xl border border-gray-100 shadow-sm">
                <img src="{{ asset('images/testi1.webp') }}" class="w-full h-64 object-cover rounded-xl shadow">
                <p class="text-sm md:text-base text-gray-700 italic leading-relaxed pl-3 border-l-4 border-[#1e314b]">
                    "Awalnya bingung mau pakai WO apa, tapi untungnya pilih tim ini. Rundown-nya rapi banget, krunya gercep, dan pas ada kendala kecil langsung beres dalam hitungan detik. Recommended banget buat yang mau nikah tanpa ribet!"
                </p>
            </div>
            <div class="space-y-4 bg-gray-50 p-6 rounded-2xl border border-gray-100 shadow-sm">
                <img src="{{ asset('images/testi2.webp') }}" class="w-full h-64 object-cover rounded-xl shadow">
                <p class="text-sm md:text-base text-gray-700 italic leading-relaxed pl-3 border-l-4 border-[#1e314b]">
                    "Kami sekeluarga mengucapkan terima kasih banyak kepada seluruh tim WO yang sudah membantu mewujudkan pernikahan impian kami. Koordinasi dengan vendor lain sangat lancar, tamu-tamu nyaman, dan acaranya khidmat serta tepat waktu. Sukses selalu untuk bisnis dan timnya!"
                </p>
            </div>
        </div>
    </div>
</section>
@endsection