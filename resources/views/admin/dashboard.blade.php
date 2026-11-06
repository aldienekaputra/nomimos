@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<!-- NOTIFIKASI SUKSES / ERROR -->
@if(session('success'))
    <div class="fixed top-5 right-5 z-50 bg-emerald-600 text-white px-6 py-3 rounded-xl shadow-lg text-sm font-semibold flex items-center gap-3">
        <span>{{ session('success') }}</span>
        <button onclick="this.parentElement.remove()" class="text-white font-bold text-lg">&times;</button>
    </div>
@endif

<!-- KOLOM TENGAH (KALENDER & PEMESANAN) - DIBUAT FULL WIDTH RAPI -->
<main class="flex-1 p-8 overflow-y-auto space-y-8 bg-[#e9eff6] w-full">
    
    <!-- KALENDER EVENT INTERAKTIF FULL WIDTH -->
    <div class="w-full">
        <h2 class="font-serif-title text-3xl font-bold text-black mb-6">Kalender Event</h2>
        
        <div class="bg-[#f0f3f8] rounded-3xl p-6 shadow-sm border border-gray-200/60 w-full">
            <!-- Navigasi Bulan & Tombol Panah -->
            <div class="flex justify-between items-center mb-6 px-2">
                <div class="flex items-center gap-1">
                    <span id="calendar-month-year" class="font-bold text-gray-800 text-base">-</span>
                </div>
                <div class="flex items-center gap-4 text-gray-600 text-xs">
                    <span class="flex items-center gap-1.5 font-medium"><span class="w-3 h-3 rounded-full bg-blue-600 inline-block shadow-sm"></span> ACC</span>
                    <span class="flex items-center gap-1.5 font-medium"><span class="w-3 h-3 rounded-full bg-amber-500 inline-block shadow-sm"></span> Pending</span>
                    <!-- Tombol Navigasi Bulan -->
                    <div class="flex items-center gap-1.5 ml-2">
                        <button onclick="changeMonth(-1)" class="w-8 h-8 bg-white rounded-xl border border-gray-300 flex items-center justify-center font-bold text-gray-700 hover:bg-gray-100 transition-colors shadow-sm">&lt;</button>
                        <button onclick="changeMonth(1)" class="w-8 h-8 bg-white rounded-xl border border-gray-300 flex items-center justify-center font-bold text-gray-700 hover:bg-gray-100 transition-colors shadow-sm">&gt;</button>
                    </div>
                </div>
            </div>

            <!-- Header Hari -->
            <div class="grid grid-cols-7 text-center text-xs font-semibold text-gray-400 mb-4 tracking-wider">
                <div>SUN</div> <div>MON</div> <div>TUE</div> <div>WED</div> <div>THU</div> <div>FRI</div> <div>SAT</div>
            </div>

            <!-- Tanggal Kalender (Dirender Interaktif via JS) -->
            <div id="calendar-days-grid" class="grid grid-cols-7 text-center text-sm font-medium gap-y-4 text-gray-700 min-h-[220px]">
                <!-- Grid tanggal diisi oleh JavaScript renderCalendar() -->
            </div>
        </div>
    </div>

    <!-- SECTION PEMESANAN MASUK (FULL WIDTH) -->
    <div class="w-full">
        <h2 class="font-serif-title text-3xl font-bold text-black mb-4">Pemesanan Masuk</h2>
        
        <div class="space-y-4 w-full">
            @php
                $pendingEvents = $events->where('status_acc', 'Pending');
            @endphp

            @forelse($pendingEvents as $item)
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 flex justify-between items-center w-full">
                    <div class="space-y-1">
                        <h3 class="font-bold text-black text-lg">
                            {{ $item->klien ? $item->klien->nama_pria . ' & ' . $item->klien->nama_wanita : 'Klien Tanpa Nama' }}
                        </h3>
                        <p class="text-xs text-slate-500 font-medium">Tanggal Acara: <span class="text-black font-semibold">{{ \Carbon\Carbon::parse($item->tgl_acara)->translatedFormat('d F Y') }}</span></p>
                        <p class="text-xs text-slate-500 font-medium">Lokasi: <span class="text-black font-semibold">{{ $item->lokasi_acara }}</span></p>
                        <p class="text-xs text-slate-500">Paket: <span class="text-[#1e314b] font-semibold">{{ $item->paket->nama_paket ?? '-' }}</span></p>
                    </div>

                    <div class="flex flex-col items-end gap-3">
                        <span class="bg-amber-500 text-white text-[10px] px-3 py-1 rounded-full font-bold">Pending</span>

                        <button onclick="selectEvent('{{ $item->tgl_acara }}')" 
                                class="px-4 py-2 bg-[#1e314b] text-white text-xs rounded-xl font-medium hover:bg-slate-800 transition-colors shadow-sm">
                            Lihat Detail & ACC
                        </button>
                    </div>
                </div>
            @empty
                <div class="bg-white rounded-2xl p-8 text-center border border-gray-100 text-slate-400 text-sm w-full">
                    Tidak ada permohonan pemesanan baru. Semua acara sudah terproses!
                </div>
            @endforelse
        </div>
    </div>

</main>

<!-- KOLOM KANAN (DETAIL EVENT) -->
<aside class="w-96 bg-white p-8 border-l border-gray-200 shrink-0">
    <h2 class="font-serif-title text-2xl font-bold text-black mb-6">Detail Event</h2>

    <div id="detail-card" class="space-y-4 text-sm">
        <div class="flex items-center justify-between border-b pb-3">
            <span class="font-semibold text-black">ID Pemesanan:</span>
            <span id="detail-id" class="text-gray-700 font-mono">-</span>
        </div>

        <div class="flex items-center justify-between border-b pb-3">
            <span class="font-semibold text-black">Status Acara:</span>
            <span id="detail-status" class="bg-gray-200 text-gray-700 text-xs px-4 py-1 rounded-full font-medium">Pilih Tanggal Acara</span>
        </div>

        <!-- BARU: BARIS STATUS KEUANGAN (LUNAS / PENDING) -->
        <div class="flex items-center justify-between border-b pb-3">
            <span class="font-semibold text-black">Status Keuangan:</span>
            <span id="detail-status-bayar" class="bg-gray-100 text-gray-500 text-xs px-3 py-1 rounded-full font-bold uppercase tracking-wider">-</span>
        </div>

        <div class="flex items-start justify-between border-b pb-3">
            <span class="font-semibold text-black">Mempelai:</span>
            <span id="detail-nama" class="text-gray-700 text-right font-medium">-</span>
        </div>

        <div class="flex items-start justify-between border-b pb-3">
            <span class="font-semibold text-black">No. WhatsApp:</span>
            <span id="detail-hp" class="text-gray-700 text-right">-</span>
        </div>

        <div class="flex items-start justify-between border-b pb-3">
            <span class="font-semibold text-black">Paket:</span>
            <span id="detail-paket" class="text-gray-700 text-right font-medium text-[#1e314b]">-</span>
        </div>

        <div class="flex items-start justify-between border-b pb-3">
            <span class="font-semibold text-black">Lokasi:</span>
            <span id="detail-lokasi" class="text-gray-700 text-right">-</span>
        </div>

        <!-- FORM ACTION ACC / TOLAK -->
        <div id="acc-action-box" class="pt-6 border-t border-gray-100 space-y-3 hidden">
            <form id="form-acc" method="POST" action="">
                @csrf
                <input type="hidden" name="status_acc" value="ACC">
                <button type="submit" class="w-full bg-emerald-600 text-white py-2.5 rounded-xl text-xs font-semibold hover:bg-emerald-700 transition-colors shadow-sm">
                    ACC Event
                </button>
            </form>

            <form id="form-tolak" method="POST" action="">
                @csrf
                <input type="hidden" name="status_acc" value="Batal">
                <button type="submit" class="w-full bg-rose-600 text-white py-2.5 rounded-xl text-xs font-semibold hover:bg-rose-700 transition-colors shadow-sm">
                    Tolak Event
                </button>
            </form>
        </div>
    </div>
</aside>

<!-- SCRIPT KALENDER & DETAIL EVENT INTERAKTIF -->
<script>
    const eventsData = {
        @foreach($events as $item)
        '{{ $item->tgl_acara }}': {
            id: '#ORD-{{ $item->id_pemesanan }}',
            status: '{{ $item->status_acc }}',
            badgeClass: '{{ $item->status_acc === "ACC" ? "bg-blue-600 text-white" : ($item->status_acc === "Pending" ? "bg-amber-500 text-white" : "bg-rose-500 text-white") }}',
            statusBayar: {!! json_encode($item->keuangan->status_pembayaran ?? 'Pending') !!},
            nama: {!! json_encode($item->klien ? $item->klien->nama_pria . ' & ' . $item->klien->nama_wanita : 'Klien Tanpa Nama') !!},
            hp: '{{ $item->klien->no_hp ?? "-" }}',
            paket: {!! json_encode($item->paket->nama_paket ?? "-") !!},
            lokasi: {!! json_encode($item->lokasi_acara) !!},
            updateUrl: '{{ route("admin.updateStatus", $item->id_pemesanan) }}',
            showAcc: {{ $item->status_acc === 'Pending' ? 'true' : 'false' }}
        },
        @endforeach
    };

    let currentDate = new Date();

    function renderCalendar() {
        const year = currentDate.getFullYear();
        const month = currentDate.getMonth();

        const monthNames = [
            "Januari", "Februari", "Maret", "April", "Mei", "Juni", 
            "Juli", "Agustus", "September", "Oktober", "November", "Desember"
        ];

        document.getElementById('calendar-month-year').innerText = `${monthNames[month]} ${year}`;

        const firstDayIndex = new Date(year, month, 1).getDay();
        const lastDay = new Date(year, month + 1, 0).getDate();

        const grid = document.getElementById('calendar-days-grid');
        grid.innerHTML = '';

        for (let i = 0; i < firstDayIndex; i++) {
            grid.innerHTML += `<div></div>`;
        }

        for (let day = 1; day <= lastDay; day++) {
            const formattedMonth = String(month + 1).padStart(2, '0');
            const formattedDay = String(day).padStart(2, '0');
            const dateStr = `${year}-${formattedMonth}-${formattedDay}`;

            const event = eventsData[dateStr];

            if (event) {
                let btnColorClass = 'bg-gray-400 text-white';
                if (event.status === 'ACC') {
                    btnColorClass = 'bg-blue-600 text-white';
                } else if (event.status === 'Pending') {
                    btnColorClass = 'bg-amber-500 text-white';
                }

                grid.innerHTML += `
                    <div class="flex justify-center items-center">
                        <button onclick="selectEvent('${dateStr}')" 
                                class="w-9 h-9 rounded-full ${btnColorClass} flex items-center justify-center font-bold shadow-md hover:scale-110 transition-transform">
                            ${day}
                        </button>
                    </div>
                `;
            } else {
                grid.innerHTML += `
                    <div class="flex justify-center items-center">
                        <span class="w-9 h-9 flex items-center justify-center text-gray-700 font-normal">
                            ${day}
                        </span>
                    </div>
                `;
            }
        }
    }

    function changeMonth(offset) {
        currentDate.setMonth(currentDate.getMonth() + offset);
        renderCalendar();
    }

    function selectEvent(tglAcara) {
        const data = eventsData[tglAcara];
        if (data) {
            document.getElementById('detail-id').innerText = data.id;
            document.getElementById('detail-nama').innerText = data.nama;
            document.getElementById('detail-hp').innerText = data.hp;
            document.getElementById('detail-paket').innerText = data.paket;
            document.getElementById('detail-lokasi').innerText = data.lokasi;
            
            // Status Acara ACC / Pending
            const statusElem = document.getElementById('detail-status');
            statusElem.innerText = data.status === 'ACC' ? 'Confirmed (ACC)' : data.status;
            statusElem.className = `text-xs px-4 py-1 rounded-full font-medium ${data.badgeClass}`;

            // Status Keuangan Lunas / Pending
            const statusBayarElem = document.getElementById('detail-status-bayar');
            const isLunas = (data.statusBayar || '').toLowerCase() === 'lunas';
            statusBayarElem.innerText = isLunas ? 'LUNAS' : 'PENDING';
            statusBayarElem.className = isLunas 
                ? 'bg-emerald-100 text-emerald-800 text-xs px-3 py-1 rounded-full font-bold uppercase tracking-wider' 
                : 'bg-amber-100 text-amber-800 text-xs px-3 py-1 rounded-full font-bold uppercase tracking-wider';

            const accBox = document.getElementById('acc-action-box');
            if(data.showAcc) {
                document.getElementById('form-acc').action = data.updateUrl;
                document.getElementById('form-tolak').action = data.updateUrl;
                accBox.classList.remove('hidden');
            } else {
                accBox.classList.add('hidden');
            }
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        renderCalendar();
    });
</script>
@endsection