@extends('layouts.landing')

@section('content')
<!-- ABOUT HERO SECTION -->
<section style="background-color: #1e314b !important;" class="text-white py-20 md:py-24 px-6">
    <div class="max-w-6xl mx-auto grid md:grid-cols-2 gap-12 items-center">
        <!-- DESKRIPSI TENTANG NOMIMOS -->
        <div class="space-y-6">
            <h1 class="font-serif-title text-4xl md:text-5xl font-bold tracking-wide">About Us</h1>
            
            <p class="text-sm md:text-base text-gray-200 leading-relaxed font-sans">
                A trusted partner in bringing sacred, beautiful, and meaningful wedding days to life. With a touch of creativity, meticulous attention to detail, and professional service, NOMIMOS is here to create unforgettable, extraordinary moments for every couple.
            </p>
            
            <p class="text-sm md:text-base text-gray-200 leading-relaxed font-sans">
                We believe that every love story is unique. Therefore, NOMIMOS presents personalized wedding concepts tailored to your character, dreams, and values—ranging from planning, decoration, and event coordination, to ensuring your big day runs smoothly and memorably.
            </p>
            
            <p class="text-sm md:text-base text-gray-200 leading-relaxed font-sans">
                Supported by an experienced, communicative, and dedicated team, NOMIMOS is committed to delivering top-tier service with high-quality standards. Let us handle every detail, so you can cherish and enjoy every joyful moment without worry.
            </p>
        </div>

        <!-- FOTO HIGHLIGHT -->
        <div>
            <img src="{{ asset('images/banner1.webp') }}" class="w-full h-80 md:h-96 object-cover rounded-2xl shadow-xl border border-gray-600/50">
        </div>
    </div>
</section>

<!-- STYLE HIDE SCROLLBAR -->
<style>
    .no-scrollbar::-webkit-scrollbar {
        display: none;
    }
    .no-scrollbar {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }
</style>

<!-- THE TEAM SECTION (HOVER CARD NAIK + NAMA & JABATAN) -->
<section class="py-20 bg-white">
    <div class="max-w-6xl mx-auto px-6 text-center mb-12 space-y-3">
        <p class="text-sm md:text-base text-gray-500 max-w-2xl mx-auto font-sans">
            A dedicated team of planners, designers, and doers each one committed to your calm and your joy.
        </p>
        <h2 class="font-serif-title text-3xl md:text-4xl font-bold text-[#1e314b]">The Team</h2>
    </div>

    <!-- CAROUSEL WRAPPER DENGAN TOMBOL NAVIGASI -->
    <div class="max-w-6xl mx-auto px-6 relative flex items-center">
        
        <!-- TOMBOL KIRI -->
        <button onclick="document.getElementById('teamSlider').scrollBy({left: -300, behavior: 'smooth'})" 
                class="hidden md:flex absolute -left-4 z-10 bg-[#1e314b] text-white p-3 rounded-full shadow-lg hover:bg-slate-700 transition-all items-center justify-center">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
        </button>

        <!-- CONTAINER SLIDER -->
        <div id="teamSlider" class="flex gap-6 overflow-x-auto snap-x snap-mandatory no-scrollbar scroll-smooth py-6 px-2 w-full">
            
            <!-- CREW 1 -->
            <div class="w-48 md:w-56 flex-shrink-0 snap-start group transform hover:-translate-y-2 transition-all duration-300">
                <div class="overflow-hidden rounded-xl shadow-md group-hover:shadow-xl bg-gray-50 border border-gray-100">
                    <img src="{{ asset('images/galih.webp') }}" alt="Crew 1" class="w-full h-64 md:h-72 object-cover">
                    <div class="p-3 text-center bg-white">
                        <h4 class="font-serif-title font-bold text-[#1e314b] text-sm md:text-base">Galih</h4>
                        <p class="text-xs text-gray-500 font-sans mt-0.5">Chief Excecutive Officer (CEO)</p>
                    </div>
                </div>
            </div>

            <!-- CREW 2 -->
            <div class="w-48 md:w-56 flex-shrink-0 snap-start group transform hover:-translate-y-2 transition-all duration-300">
                <div class="overflow-hidden rounded-xl shadow-md group-hover:shadow-xl bg-gray-50 border border-gray-100">
                    <img src="{{ asset('images/shalsa.webp') }}" alt="Crew 2" class="w-full h-64 md:h-72 object-cover">
                    <div class="p-3 text-center bg-white">
                        <h4 class="font-serif-title font-bold text-[#1e314b] text-sm md:text-base">Shalsa</h4>
                        <p class="text-xs text-gray-500 font-sans mt-0.5">Coordinator Of Management (COM)</p>
                    </div>
                </div>
            </div>

            <!-- CREW 3 -->
            <div class="w-48 md:w-56 flex-shrink-0 snap-start group transform hover:-translate-y-2 transition-all duration-300">
                <div class="overflow-hidden rounded-xl shadow-md group-hover:shadow-xl bg-gray-50 border border-gray-100">
                    <img src="{{ asset('images/karin.webp') }}" alt="Crew 3" class="w-full h-64 md:h-72 object-cover">
                    <div class="p-3 text-center bg-white">
                        <h4 class="font-serif-title font-bold text-[#1e314b] text-sm md:text-base">Karin</h4>
                        <p class="text-xs text-gray-500 font-sans mt-0.5">Coordinator Of Operations (COO)</p>
                    </div>
                </div>
            </div>

            <!-- CREW 4 -->
            <div class="w-48 md:w-56 flex-shrink-0 snap-start group transform hover:-translate-y-2 transition-all duration-300">
                <div class="overflow-hidden rounded-xl shadow-md group-hover:shadow-xl bg-gray-50 border border-gray-100">
                    <img src="{{ asset('images/irfan.webp') }}" alt="Crew 4" class="w-full h-64 md:h-72 object-cover">
                    <div class="p-3 text-center bg-white">
                        <h4 class="font-serif-title font-bold text-[#1e314b] text-sm md:text-base">Irfan</h4>
                        <p class="text-xs text-gray-500 font-sans mt-0.5">Coordinator Of Operations (COO)</p>
                    </div>
                </div>
            </div>

            <!-- CREW 5 -->
            <div class="w-48 md:w-56 flex-shrink-0 snap-start group transform hover:-translate-y-2 transition-all duration-300">
                <div class="overflow-hidden rounded-xl shadow-md group-hover:shadow-xl bg-gray-50 border border-gray-100">
                    <img src="{{ asset('images/mahenz.webp') }}" alt="Crew 5" class="w-full h-64 md:h-72 object-cover">
                    <div class="p-3 text-center bg-white">
                        <h4 class="font-serif-title font-bold text-[#1e314b] text-sm md:text-base">Sulthan</h4>
                        <p class="text-xs text-gray-500 font-sans mt-0.5">Senior Team</p>
                    </div>
                </div>
            </div>

            <!-- CREW 6 -->
            <div class="w-48 md:w-56 flex-shrink-0 snap-start group transform hover:-translate-y-2 transition-all duration-300">
                <div class="overflow-hidden rounded-xl shadow-md group-hover:shadow-xl bg-gray-50 border border-gray-100">
                    <img src="{{ asset('images/anton.webp') }}" alt="Crew 6" class="w-full h-64 md:h-72 object-cover">
                    <div class="p-3 text-center bg-white">
                        <h4 class="font-serif-title font-bold text-[#1e314b] text-sm md:text-base">Anton</h4>
                        <p class="text-xs text-gray-500 font-sans mt-0.5">Senior Team</p>
                    </div>
                </div>
            </div>

            <!-- CREW 7 -->
            <div class="w-48 md:w-56 flex-shrink-0 snap-start group transform hover:-translate-y-2 transition-all duration-300">
                <div class="overflow-hidden rounded-xl shadow-md group-hover:shadow-xl bg-gray-50 border border-gray-100">
                    <img src="{{ asset('images/jua.webp') }}" alt="Crew 7" class="w-full h-64 md:h-72 object-cover">
                    <div class="p-3 text-center bg-white">
                        <h4 class="font-serif-title font-bold text-[#1e314b] text-sm md:text-base">Jua</h4>
                        <p class="text-xs text-gray-500 font-sans mt-0.5">Senior Team</p>
                    </div>
                </div>
            </div>

            <!-- CREW 8 -->
            <div class="w-48 md:w-56 flex-shrink-0 snap-start group transform hover:-translate-y-2 transition-all duration-300">
                <div class="overflow-hidden rounded-xl shadow-md group-hover:shadow-xl bg-gray-50 border border-gray-100">
                    <img src="{{ asset('images/zahra.webp') }}" alt="Crew 8" class="w-full h-64 md:h-72 object-cover">
                    <div class="p-3 text-center bg-white">
                        <h4 class="font-serif-title font-bold text-[#1e314b] text-sm md:text-base">Zahra</h4>
                        <p class="text-xs text-gray-500 font-sans mt-0.5">Senior Team</p>
                    </div>
                </div>
            </div>

            <!-- CREW 9 -->
            <div class="w-48 md:w-56 flex-shrink-0 snap-start group transform hover:-translate-y-2 transition-all duration-300">
                <div class="overflow-hidden rounded-xl shadow-md group-hover:shadow-xl bg-gray-50 border border-gray-100">
                    <img src="{{ asset('images/aliskha.webp') }}" alt="Crew 9" class="w-full h-64 md:h-72 object-cover">
                    <div class="p-3 text-center bg-white">
                        <h4 class="font-serif-title font-bold text-[#1e314b] text-sm md:text-base">Aliskha</h4>
                        <p class="text-xs text-gray-500 font-sans mt-0.5">Senior Team</p>
                    </div>
                </div>
            </div>

            <!-- CREW 10 -->
            <div class="w-48 md:w-56 flex-shrink-0 snap-start group transform hover:-translate-y-2 transition-all duration-300">
                <div class="overflow-hidden rounded-xl shadow-md group-hover:shadow-xl bg-gray-50 border border-gray-100">
                    <img src="{{ asset('images/tatuk.webp') }}" alt="Crew 10" class="w-full h-64 md:h-72 object-cover">
                    <div class="p-3 text-center bg-white">
                        <h4 class="font-serif-title font-bold text-[#1e314b] text-sm md:text-base">Tatuk</h4>
                        <p class="text-xs text-gray-500 font-sans mt-0.5">Senior Team</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- TOMBOL KANAN -->
        <button onclick="document.getElementById('teamSlider').scrollBy({left: 300, behavior: 'smooth'})" 
                class="hidden md:flex absolute -right-4 z-10 bg-[#1e314b] text-white p-3 rounded-full shadow-lg hover:bg-slate-700 transition-all items-center justify-center">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
        </button>

    </div>
</section>
@endsection