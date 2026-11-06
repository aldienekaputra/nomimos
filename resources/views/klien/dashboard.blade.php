@extends('layouts.klien')

@section('content')
<div class="max-w-5xl mx-auto space-y-10 py-2">

    <!-- WELCOME TITLE & COUNTDOWN BANNER -->
    <div class="text-center space-y-6">
        <div class="space-y-2">
            <h1 class="font-serif-title text-3xl md:text-5xl font-bold text-black tracking-tight">
                Selamat Datang, {{ $klien ? $klien->nama_pria . ' & ' . $klien->nama_wanita : Auth::user()->username }}!
            </h1>
            <p class="font-serif-title text-base md:text-lg text-slate-600 font-medium">
                Beberapa Hari Menuju Hari Bahagia Anda
            </p>
        </div>

        <!-- COUNTDOWN BOXES DISPLAY -->
        <div class="inline-flex flex-col items-center bg-slate-50/60 p-6 md:p-8 rounded-3xl border border-slate-200/60 shadow-sm">
            <div class="flex justify-center items-center gap-3 md:gap-5" id="countdown-container">
                <!-- BOX HARI PULUHAN -->
                <div class="bg-white rounded-2xl w-16 h-24 md:w-24 md:h-32 flex items-center justify-center shadow-md border border-slate-100">
                    <span class="font-serif-title text-4xl md:text-6xl font-bold text-black" id="day-tens">0</span>
                </div>
                <!-- BOX HARI SATUAN -->
                <div class="bg-white rounded-2xl w-16 h-24 md:w-24 md:h-32 flex items-center justify-center shadow-md border border-slate-100">
                    <span class="font-serif-title text-4xl md:text-6xl font-bold text-black" id="day-ones">0</span>
                </div>

                <!-- COLON SEPARATOR -->
                <span class="font-serif-title text-3xl md:text-5xl font-bold text-slate-800 px-1 md:px-2 animate-pulse">:</span>

                <!-- BOX JAM PULUHAN -->
                <div class="bg-white rounded-2xl w-16 h-24 md:w-24 md:h-32 flex items-center justify-center shadow-md border border-slate-100">
                    <span class="font-serif-title text-4xl md:text-6xl font-bold text-black" id="hour-tens">0</span>
                </div>
                <!-- BOX JAM SATUAN -->
                <div class="bg-white rounded-2xl w-16 h-24 md:w-24 md:h-32 flex items-center justify-center shadow-md border border-slate-100">
                    <span class="font-serif-title text-4xl md:text-6xl font-bold text-black" id="hour-ones">0</span>
                </div>
            </div>

            <!-- LABELS COUNTDOWN -->
            <div class="flex justify-around w-full font-serif-title text-sm md:text-base font-bold text-black pt-4">
                <span class="w-1/2 text-center">Hari</span>
                <span class="w-1/2 text-center">Jam</span>
            </div>
        </div>
    </div>

    <!-- DETAIL EVENT CARD -->
    <div class="bg-white rounded-3xl p-8 md:p-10 shadow-sm max-w-2xl mx-auto space-y-6 border border-slate-100">
        <div class="border-b border-slate-100 pb-4">
            <h3 class="font-serif-title text-xl md:text-2xl font-bold text-black">
                Detail Event
            </h3>
        </div>

        @if($pemesanan)
            @php
                $statusBadge = $pemesanan->status_acc ?? 'Pending';
                $isConfirmed = in_array(strtolower($statusBadge), ['acc', 'confirmed']);
            @endphp
            <div class="divide-y divide-slate-100 text-sm md:text-base text-black">
                <!-- ID PEMESANAN -->
                <div class="py-3.5 flex justify-between items-center">
                    <span class="font-semibold text-slate-600">ID Pemesanan:</span>
                    <span class="font-mono font-bold text-slate-900">
                        #ORD-{{ date('Y', strtotime($pemesanan->tgl_acara ?? now())) }}-{{ str_pad($pemesanan->id_pemesanan, 3, '0', STR_PAD_LEFT) }}
                    </span>
                </div>

                <!-- STATUS BADGE -->
                <div class="py-3.5 flex justify-between items-center">
                    <span class="font-semibold text-slate-600">Status Badge:</span>
                    <span class="px-4 py-1 rounded-full text-white text-xs font-semibold shadow-sm inline-block
                        {{ $isConfirmed ? 'bg-emerald-500' : (strtolower($statusBadge) === 'pending' ? 'bg-amber-500' : 'bg-rose-500') }}">
                        {{ $isConfirmed ? 'Confirmed' : ucfirst($statusBadge) }}
                    </span>
                </div>

                <!-- NAMA PENGANTIN -->
                <div class="py-3.5 flex justify-between items-center">
                    <span class="font-semibold text-slate-600">Nama:</span>
                    <span class="font-serif-title font-bold text-slate-900">
                        {{ $klien ? $klien->nama_pria . ' & ' . $klien->nama_wanita : '-' }}
                    </span>
                </div>

                <!-- PAKET ACARA -->
                <div class="py-3.5 flex justify-between items-center">
                    <span class="font-semibold text-slate-600">Paket:</span>
                    <span class="font-medium text-slate-800">
                        {{ $pemesanan->paket->nama_paket ?? '-' }}
                    </span>
                </div>

                <!-- LOKASI ACARA -->
                <div class="py-3.5 flex justify-between items-center">
                    <span class="font-semibold text-slate-600">Lokasi:</span>
                    <span class="font-medium text-slate-800 text-right">
                        {{ $pemesanan->lokasi_acara ?? '-' }}
                    </span>
                </div>
            </div>
        @else
            <div class="py-8 text-center text-slate-400 italic">
                Belum ada data pemesanan acara yang terhubung dengan akun ini.
            </div>
        @endif
    </div>

</div>

<!-- SCRIPT COUNTDOWN REALTIME -->
@if($pemesanan && $pemesanan->tgl_acara)
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const eventDateStr = "{{ \Carbon\Carbon::parse($pemesanan->tgl_acara)->format('Y-m-d') }}T08:00:00";
        const targetDate = new Date(eventDateStr).getTime();

        function updateCountdown() {
            const now = new Date().getTime();
            const distance = targetDate - now;

            if (isNaN(distance) || distance <= 0) {
                document.getElementById("day-tens").innerText = "0";
                document.getElementById("day-ones").innerText = "0";
                document.getElementById("hour-tens").innerText = "0";
                document.getElementById("hour-ones").innerText = "0";
                return;
            }

            const days = Math.floor(distance / (1000 * 60 * 60 * 24));
            const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));

            const daysStr = String(days).padStart(2, '0');
            const hoursStr = String(hours).padStart(2, '0');

            document.getElementById("day-tens").innerText = daysStr[daysStr.length - 2] || '0';
            document.getElementById("day-ones").innerText = daysStr[daysStr.length - 1] || '0';
            document.getElementById("hour-tens").innerText = hoursStr[hoursStr.length - 2] || '0';
            document.getElementById("hour-ones").innerText = hoursStr[hoursStr.length - 1] || '0';
        }

        updateCountdown();
        setInterval(updateCountdown, 1000);
    });
</script>
@endif
@endsection