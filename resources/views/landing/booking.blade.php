@extends('layouts.landing')

@section('content')

<!-- BUNGKUS SELURUH HALAMAN DENGAN STATE ALPINE.JS UNTUK MODAL BOOKING -->
<div x-data="{ showBookingModal: false, selectedPaketId: '', selectedPaketNama: '' }">

    <!-- HERO BANNER DENGAN RUNNING TEXT -->
    <style>
        @keyframes marqueeScroll {
            0% { transform: translateX(0%); }
            100% { transform: translateX(-50%); }
        }

        .animate-marquee-direct {
            display: inline-flex !important;
            white-space: nowrap !important;
            width: max-content !important;
            animation: marqueeScroll 15s linear infinite !important;
            will-change: transform;
        }
    </style>

    <section class="relative h-[480px] md:h-[540px] bg-cover bg-center flex flex-col justify-between overflow-hidden">
        <img src="{{ asset('images/banner2.webp') }}" 
             alt="Nomimos Organizer Banner" 
             class="absolute inset-0 w-full h-full object-cover">

        <div class="absolute inset-0 bg-black/40"></div>

        <div class="relative z-10 my-auto text-white text-center px-6">
            <h1 class="font-serif-title text-4xl sm:text-5xl md:text-6xl font-bold tracking-[0.2em] uppercase leading-tight drop-shadow-md">
                NOMIMOS ORGANIZER
            </h1>
        </div>

        <div class="relative z-10 w-full bg-black/50 backdrop-blur-sm py-3 overflow-hidden border-t border-white/10" style="white-space: nowrap !important;">
            <div class="animate-marquee-direct font-sans text-sm md:text-base font-semibold tracking-widest text-white uppercase">
                <span style="padding: 0 30px !important; display: inline-block !important;">NOMIMOS ORGANIZER <span style="color: #cbd5e1; font-weight: 300;">#BEHAPPY</span></span>
                <span style="padding: 0 30px !important; display: inline-block !important;">NOMIMOS ORGANIZER <span style="color: #cbd5e1; font-weight: 300;">#BEHAPPY</span></span>
                <span style="padding: 0 30px !important; display: inline-block !important;">NOMIMOS ORGANIZER <span style="color: #cbd5e1; font-weight: 300;">#BEHAPPY</span></span>
                <span style="padding: 0 30px !important; display: inline-block !important;">NOMIMOS ORGANIZER <span style="color: #cbd5e1; font-weight: 300;">#BEHAPPY</span></span>
                <span style="padding: 0 30px !important; display: inline-block !important;">NOMIMOS ORGANIZER <span style="color: #cbd5e1; font-weight: 300;">#BEHAPPY</span></span>
                <span style="padding: 0 30px !important; display: inline-block !important;">NOMIMOS ORGANIZER <span style="color: #cbd5e1; font-weight: 300;">#BEHAPPY</span></span>
                <span style="padding: 0 30px !important; display: inline-block !important;">NOMIMOS ORGANIZER <span style="color: #cbd5e1; font-weight: 300;">#BEHAPPY</span></span>
                <span style="padding: 0 30px !important; display: inline-block !important;">NOMIMOS ORGANIZER <span style="color: #cbd5e1; font-weight: 300;">#BEHAPPY</span></span>
            </div>
        </div>
    </section>

    <!-- VALUES BANNER -->
    <section style="background-color: #1e314b !important;" class="text-white py-20 px-8 md:px-16">
        <div class="max-w-6xl mx-auto space-y-16">
            <div class="grid md:grid-cols-2 gap-12 items-start">
                <div class="space-y-3">
                    <span class="text-xs uppercase tracking-widest text-gray-300 font-sans font-medium">More Than a Corporate Event Planner</span>
                    <h2 class="font-serif-title text-3xl md:text-4xl font-bold leading-snug">
                        A Creative Partner for Meaningful Experiences
                    </h2>
                </div>
                <p class="text-sm md:text-base text-gray-300 leading-relaxed font-sans pt-2">
                    We create weddings that do more than run smoothly—they communicate love, connect hearts, and leave a lasting impression. With an eye for detail and a feel for flow, we transform complex requirements into seamless experiences, so your special day reflects clarity, intention, and timeless joy.
                </p>
            </div>

            <div class="relative pl-8 md:pl-12 border-l border-gray-400/50 space-y-10">
                <div class="grid md:grid-cols-3 gap-10 items-start">
                    <div class="space-y-3">
                        <div class="text-gray-300">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                            </svg>
                        </div>
                        <h4 class="font-serif-title text-lg md:text-xl font-bold leading-snug">Seamless Event<br>Management</h4>
                        <p class="text-sm text-gray-300 leading-relaxed font-sans">We handle the details so you can focus on what matters most.</p>
                    </div>

                    <div class="space-y-3">
                        <div class="text-gray-300">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.684a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                            </svg>
                        </div>
                        <h4 class="font-serif-title text-lg md:text-xl font-bold leading-snug">Memorable<br>Experiences</h4>
                        <p class="text-sm text-gray-300 leading-relaxed font-sans">Events designed to resonate and inspire joy.</p>
                    </div>

                    <div class="space-y-3">
                        <div class="text-gray-300">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                            </svg>
                        </div>
                        <h4 class="font-serif-title text-lg md:text-xl font-bold leading-snug">Smart, Cost-<br>Efficient Execution</h4>
                        <p class="text-sm text-gray-300 leading-relaxed font-sans">Optimized planning for measurable results.</p>
                    </div>
                </div>

                <div class="pt-4">
                    <a href="https://wa.me/6281234567890" target="_blank" class="inline-block bg-[#e2e8f0] hover:bg-slate-200 text-[#1e314b] px-8 py-3 rounded-lg text-sm font-semibold transition-all shadow-sm no-underline">
                        Schedule a Consultant
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- WEDDING PACKAGES SECTION (DINAMIS DARI DATABASE) -->
    <section class="py-20 bg-[#f8fafc]">
        
        <!-- NOTIFIKASI SUKSES BOOKING -->
        @if(session('success'))
        <div class="max-w-4xl mx-auto mb-8 px-6">
            <div class="bg-emerald-600 text-white p-4 rounded-xl shadow-md text-sm font-semibold flex justify-between items-center">
                <span>{{ session('success') }}</span>
                <button onclick="this.parentElement.remove()" class="font-bold text-lg">&times;</button>
            </div>
        </div>
        @endif

        <div class="max-w-6xl mx-auto px-6 text-center mb-16 space-y-3">
            <h2 class="font-serif-title text-3xl md:text-4xl font-bold text-[#1e314b]">Wedding Packages Crafted for Your Special Day</h2>
            <p class="font-sans text-sm text-gray-600 tracking-wide max-w-2xl mx-auto">Discover thoughtfully curated wedding packages tailored to bring your dream celebration to life seamlessly.</p>
        </div>

        <div class="max-w-6xl mx-auto px-6 grid md:grid-cols-3 gap-10">
            @foreach($pakets as $paket)
            <div style="box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.08), 0 8px 10px -6px rgba(0, 0, 0, 0.04) !important;" 
                class="bg-white border border-gray-100 rounded-2xl p-8 flex flex-col justify-between text-center min-h-[420px] hover:-translate-y-1 transition-all duration-300">
                
                <div class="space-y-4">
                    <h3 class="font-serif-title text-2xl font-bold text-[#1e314b] tracking-tight">{{ $paket->nama_paket }}</h3>
                    <p class="font-sans text-sm text-gray-600 leading-relaxed px-1">{{ $paket->keterangan_paket }}</p>
                </div>

                <div class="pt-8 border-t border-gray-100 space-y-5">
                    <p class="text-2xl font-bold text-[#1e314b]">
                        Rp {{ number_format($paket->harga_paket, 0, ',', '.') }}
                    </p>
                    
                    <!-- TOMBOL INTERAKTIF (KONDISI AUTH / GUEST) -->
                    @auth
                        <!-- JIKA SUDAH LOGIN: BUKA MODAL BOOKING -->
                        <button type="button" 
                                @click="showBookingModal = true; selectedPaketId = '{{ $paket->id_paket }}'; selectedPaketNama = '{{ $paket->nama_paket }}'" 
                                class="block w-full bg-[#1e314b] text-white py-3 rounded-xl font-semibold hover:bg-slate-800 transition-colors shadow-sm">
                            Pilih Paket
                        </button>
                    @else
                        <!-- JIKA BELUM LOGIN: REDIRECT KE HALAMAN LOGIN -->
                        <a href="{{ route('login') }}" 
                           onclick="alert('Silakan login atau daftar akun terlebih dahulu untuk melakukan booking paket acara!')"
                           class="block w-full bg-[#1e314b] text-white py-3 rounded-xl font-semibold hover:bg-slate-800 transition-colors shadow-sm text-center no-underline">
                            Pilih Paket
                        </a>
                    @endauth
                </div>

            </div>
            @endforeach
        </div>
    </section>

    <!-- INTERACTIVE CALENDAR DINAMIS -->
    <section class="py-20 bg-gray-50">
        <div class="max-w-4xl mx-auto px-6 text-center space-y-8">
            <div class="space-y-2">
                <h2 class="font-serif-title text-3xl md:text-4xl font-bold text-[#1e314b]">Date availability info</h2>
                <p class="text-sm text-gray-600 font-medium">Look at your date today! #BeHappy</p>
            </div>

            <div class="bg-white p-8 rounded-2xl shadow-md border border-gray-100 inline-block w-full max-w-lg">
                <!-- Navigasi Bulan & Keterangan Warna -->
                <div class="flex flex-col sm:flex-row justify-between items-center mb-6 gap-4">
                    <span id="user-calendar-month-year" class="font-bold text-[#1e314b] text-base">-</span>
                    
                    <div class="flex items-center gap-3 text-xs">
                        <span class="flex items-center gap-1 font-medium"><span class="w-2.5 h-2.5 rounded-full bg-blue-600 inline-block"></span> Booked (ACC)</span>
                        <span class="flex items-center gap-1 font-medium"><span class="w-2.5 h-2.5 rounded-full bg-amber-500 inline-block"></span> Requesting</span>
                        
                        <div class="flex items-center gap-1 ml-2">
                            <button onclick="changeUserMonth(-1)" class="px-2.5 py-1 border rounded-lg hover:bg-gray-100 text-xs font-bold">&lt;</button>
                            <button onclick="changeUserMonth(1)" class="px-2.5 py-1 border rounded-lg hover:bg-gray-100 text-xs font-bold">&gt;</button>
                        </div>
                    </div>
                </div>

                <!-- Header Hari -->
                <div class="grid grid-cols-7 gap-2 text-center text-xs font-bold text-gray-400 mb-3">
                    <span>SUN</span><span>MON</span><span>TUE</span><span>WED</span><span>THU</span><span>FRI</span><span>SAT</span>
                </div>

                <!-- Grid Tanggal Dinamis -->
                <div id="user-calendar-days-grid" class="grid grid-cols-7 gap-2 text-center text-sm font-medium text-gray-700 min-h-[220px]">
                    <!-- Grid tanggal dirender via JavaScript -->
                </div>
            </div>
        </div>
    </section>

    <!-- SCRIPT KALENDER INTERAKTIF LANDING PAGE -->
    <script>
        // Data Pemesanan dari Database
        const userEventsData = {
            @foreach($pemesanans as $p)
            '{{ $p->tgl_acara }}': '{{ $p->status_acc }}',
            @endforeach
        };

        let userCurrentDate = new Date();

        function renderUserCalendar() {
            const year = userCurrentDate.getFullYear();
            const month = userCurrentDate.getMonth();

            const monthNames = [
                "Januari", "Februari", "Maret", "April", "Mei", "Juni", 
                "Juli", "Agustus", "September", "Oktober", "November", "Desember"
            ];

            document.getElementById('user-calendar-month-year').innerText = `${monthNames[month]} ${year}`;

            const firstDayIndex = new Date(year, month, 1).getDay();
            const lastDay = new Date(year, month + 1, 0).getDate();

            const grid = document.getElementById('user-calendar-days-grid');
            grid.innerHTML = '';

            // Spacer Hari Kosong Sebelum Tanggal 1
            for (let i = 0; i < firstDayIndex; i++) {
                grid.innerHTML += `<div></div>`;
            }

            // Render Tanggal
            for (let day = 1; day <= lastDay; day++) {
                const formattedMonth = String(month + 1).padStart(2, '0');
                const formattedDay = String(day).padStart(2, '0');
                const dateStr = `${year}-${formattedMonth}-${formattedDay}`;

                const status = userEventsData[dateStr];

                if (status === 'ACC') {
                    // WARNA BIRU (SUDAH DI-ACC / BOOKED)
                    grid.innerHTML += `
                        <div class="flex justify-center items-center">
                            <span class="w-8 h-8 rounded-full bg-blue-600 text-white flex items-center justify-center font-bold text-xs shadow-sm" title="Tanggal Terisi (Confirmed)">
                                ${day}
                            </span>
                        </div>
                    `;
                } else if (status === 'Pending') {
                    // WARNA KUNING (MASIH REQUESTING)
                    grid.innerHTML += `
                        <div class="flex justify-center items-center">
                            <span class="w-8 h-8 rounded-full bg-amber-500 text-white flex items-center justify-center font-bold text-xs shadow-sm" title="Dalam Pengajuan">
                                ${day}
                            </span>
                        </div>
                    `;
                } else {
                    // TANGGAL BIASA (KOSONG)
                    grid.innerHTML += `
                        <div class="flex justify-center items-center">
                            <span class="w-8 h-8 flex items-center justify-center text-gray-700 font-normal">
                                ${day}
                            </span>
                        </div>
                    `;
                }
            }
        }

        function changeUserMonth(offset) {
            userCurrentDate.setMonth(userCurrentDate.getMonth() + offset);
            renderUserCalendar();
        }

        document.addEventListener('DOMContentLoaded', function() {
            renderUserCalendar();
        });
    </script>

    <!-- MODAL FORM BOOKING POP-UP -->
    <div x-show="showBookingModal" style="display: none;" class="fixed inset-0 bg-black/60 flex items-center justify-center z-50 p-4">
        <div class="bg-white rounded-2xl p-8 w-full max-w-lg space-y-5 shadow-2xl relative">
            
            <div class="flex justify-between items-center border-b pb-3">
                <div>
                    <h3 class="font-serif-title font-bold text-xl text-[#1e314b]">Form Booking Acara</h3>
                    <p class="text-xs text-emerald-600 font-semibold mt-0.5" x-text="`Paket: ${selectedPaketNama}`"></p>
                </div>
                <button @click="showBookingModal = false" class="text-gray-400 hover:text-gray-600 font-bold text-xl">&times;</button>
            </div>

            <!-- INFO PEMESAN DARI USER LOGIN -->
            @auth
                @if(Auth::user()->role === 'Klien' && Auth::user()->klien)
                <div class="bg-slate-50 p-3 rounded-xl border border-slate-200 text-xs text-slate-600">
                    <p><strong>Pemesan:</strong> {{ Auth::user()->klien->nama_pria }} & {{ Auth::user()->klien->nama_wanita }}</p>
                    <p><strong>No. WhatsApp:</strong> {{ Auth::user()->klien->no_hp }}</p>
                </div>
                @endif
            @endauth

            <form action="{{ route('booking.store') }}" method="POST" class="space-y-4">
                @csrf
                <!-- INPUT HIDDEN ID PAKET TERPILIH -->
                <input type="hidden" name="id_paket" :value="selectedPaketId">

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="text-xs font-semibold text-gray-600">Tanggal Acara</label>
                        <input type="date" name="tgl_acara" required class="w-full border border-gray-300 rounded-lg p-2.5 text-xs focus:outline-none focus:border-[#1e314b]">
                    </div>
                    <div>
                        <label class="text-xs font-semibold text-gray-600">Lokasi Acara / Gedung</label>
                        <input type="text" name="lokasi_acara" placeholder="misal: Hotel Grand Malang" required class="w-full border border-gray-300 rounded-lg p-2.5 text-xs focus:outline-none focus:border-[#1e314b]">
                    </div>
                </div>

                <div class="flex justify-end gap-2 pt-3 border-t">
                    <button type="button" @click="showBookingModal = false" class="px-4 py-2 border rounded-xl text-xs font-semibold text-gray-600">Batal</button>
                    <button type="submit" class="px-6 py-2 bg-[#1e314b] text-white rounded-xl text-xs font-bold hover:bg-slate-800 transition-colors shadow-sm">
                        Kirim Permohonan Booking
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>

<!-- LIBRARY ALPINE.JS UNTUK INTERAKSI MODAL POP-UP -->
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.min.js" defer></script>
@endsection