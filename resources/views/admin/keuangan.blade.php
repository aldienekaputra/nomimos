@extends('layouts.admin')

@section('title', 'Keuangan')

@section('content')
<main class="flex-1 p-8 overflow-y-auto space-y-6 bg-[#e9eff6]" x-data="{ showEditModal: false }">
    
    <!-- NOTIFIKASI SUKSES -->
    @if(session('success'))
    <div class="bg-emerald-600 text-white p-4 rounded-xl shadow-sm text-sm font-medium flex justify-between items-center">
        <span>{{ session('success') }}</span>
        <button onclick="this.parentElement.remove()" class="font-bold text-lg">&times;</button>
    </div>
    @endif

    <!-- HEADER BAR: JUDUL & FILTER DROPDOWN INTERAKTIF -->
    <div class="flex justify-between items-center bg-white p-5 rounded-2xl shadow-sm border border-gray-100">
        <div>
            <h2 class="font-serif-title text-2xl font-bold text-black">Laporan Keuangan WO</h2>
            <p class="text-xs text-gray-500 mt-0.5">Filter bulan untuk mempersempit pencarian pengantin</p>
        </div>
        
        <div class="flex items-center gap-3">
            <!-- 1. FILTER BULAN -->
            <div class="flex flex-col">
                <label class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">1. Pilih Bulan Acara</label>
                <select id="filterBulan" onchange="filterKlienByBulan()" 
                        class="bg-[#f8fafc] border border-gray-300 text-gray-800 text-xs font-semibold rounded-xl px-4 py-2.5 focus:outline-none focus:border-[#1e314b] shadow-sm cursor-pointer">
                    <option value="">-- Semua Bulan --</option>
                    <option value="01">Januari</option>
                    <option value="02">Februari</option>
                    <option value="03">Maret</option>
                    <option value="04">April</option>
                    <option value="05">Mei</option>
                    <option value="06">Juni</option>
                    <option value="07">Juli</option>
                    <option value="08">Agustus</option>
                    <option value="09">September</option>
                    <option value="10">Oktober</option>
                    <option value="11">November</option>
                    <option value="12">Desember</option>
                </select>
            </div>

            <!-- 2. FILTER NAMA PENGANTIN -->
            <div class="flex flex-col">
                <label class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">2. Pilih Pengantin</label>
                <select id="filterKlien" onchange="renderDetailKeuangan(this.value)" 
                        class="bg-[#f8fafc] border border-gray-300 text-gray-800 text-xs font-semibold rounded-xl px-4 py-2.5 focus:outline-none focus:border-[#1e314b] shadow-sm min-w-[240px] cursor-pointer">
                </select>
            </div>
        </div>
    </div>

    <!-- AREA RINGKASAN & DETAIL KEUANGAN -->
    <div id="contentArea" class="space-y-6">
        <!-- Grid Ringkasan Card -->
        <div class="grid grid-cols-3 gap-6">
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 space-y-2">
                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Paket Dipilih</p>
                <h4 id="cardPaketNama" class="font-serif-title font-bold text-xl text-[#1e314b]">-</h4>
                <p id="cardHargaPaket" class="text-2xl font-bold text-emerald-600 pt-1">Rp 0</p>
            </div>

            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 space-y-2">
                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">DP WO Terbayar</p>
                <h4 id="cardTglSewa" class="font-serif-title font-bold text-xl text-black">Tgl Sewa: -</h4>
                <p id="cardDpWo" class="text-2xl font-bold text-blue-600 pt-1">Rp 0</p>
            </div>

            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 space-y-2">
                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Sisa Pelunasan WO</p>
                <h4 id="cardJatuhTempo" class="font-serif-title font-bold text-xl text-black">Jatuh Tempo: -</h4>
                <p id="cardSisaWo" class="text-2xl font-bold text-rose-600 pt-1">Rp 0</p>
            </div>
        </div>

        <!-- Detail Rincian Keuangan -->
        <div class="bg-white rounded-2xl p-8 shadow-sm border border-gray-100 space-y-6">
            <div class="flex justify-between items-center border-b pb-4">
                <div class="flex items-center gap-3">
                    <div>
                        <h3 id="detailNamaTitle" class="font-serif-title text-xl font-bold text-black">Rincian Pembayaran WO</h3>
                        <p id="detailAcaraSubtitle" class="text-xs text-gray-500">Tanggal Acara: -</p>
                    </div>
                    <!-- BADGE STATUS LUNAS / PENDING -->
                    <div id="badgeStatusPembayaran" class="ml-2"></div>
                </div>
                
                <button @click="showEditModal = true" class="bg-amber-600 text-white text-xs px-4 py-2.5 rounded-xl font-semibold hover:bg-amber-700 transition-colors shadow-sm">
                    Edit Keuangan
                </button>
            </div>

            <div class="grid grid-cols-2 gap-8 text-sm">
                <div class="space-y-4">
                    <div class="flex justify-between border-b pb-2">
                        <span class="text-gray-600 font-medium">Tanggal Sewa WO</span>
                        <span id="detailTglSewa" class="font-bold text-gray-900">-</span>
                    </div>
                    <div class="flex justify-between border-b pb-2">
                        <span class="text-gray-600 font-medium">Nominal DP WO</span>
                        <span id="detailDpWo" class="font-bold text-blue-600">Rp 0</span>
                    </div>
                    <div class="flex justify-between border-b pb-2">
                        <span class="text-gray-600 font-medium">Tanggal Perhitungan Pelunasan</span>
                        <span id="detailTglHitung" class="font-bold text-gray-900">-</span>
                    </div>
                </div>

                <div class="space-y-4">
                    <div class="flex justify-between border-b pb-2">
                        <span class="text-gray-600 font-medium">Sisa Pelunasan WO</span>
                        <span id="detailSisaWo" class="font-bold text-rose-600">Rp 0</span>
                    </div>
                    <div class="flex justify-between border-b pb-2">
                        <span class="text-gray-600 font-medium">Tanggal Jatuh Tempo Pelunasan</span>
                        <span id="detailJatuhTempo" class="font-bold text-rose-700">-</span>
                    </div>
                    <div class="flex justify-between border-b pb-2 bg-slate-50 p-2.5 rounded-xl">
                        <span class="text-gray-700 font-bold">Total Pembayaran Terjadwal</span>
                        <span id="detailTotal" class="font-bold text-[#1e314b]">Rp 0</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- PESAN JIKA TIDAK ADA KLIEN -->
    <div id="emptyArea" class="hidden bg-white rounded-2xl p-12 text-center border border-gray-100 text-slate-400 text-sm">
        Tidak ditemukan acara pengantin pada bulan terpilih.
    </div>

    <!-- MODAL EDIT KEUANGAN -->
    <div x-show="showEditModal" style="display: none;" class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-4">
        <div class="bg-white rounded-2xl p-6 w-full max-w-md space-y-4 shadow-xl relative" @click.outside="showEditModal = false">
            <div class="flex justify-between items-center border-b pb-3">
                <h3 class="font-serif-title font-bold text-lg text-black">Edit Rincian Keuangan WO</h3>
                <button @click="showEditModal = false" class="text-gray-400 hover:text-gray-600 font-bold text-xl">&times;</button>
            </div>
            
            <form id="formEditKeuangan" method="POST" action="" class="space-y-3">
                @csrf
                @method('PUT')
                
                <div>
                    <label class="text-xs font-semibold text-gray-600 mb-1 block">Status Pembayaran WO</label>
                    <select id="inputStatusPembayaran" name="status_pembayaran" required class="w-full border rounded-lg p-2.5 text-xs focus:outline-none focus:border-[#1e314b]">
                        <option value="Pending">Pending</option>
                        <option value="Lunas">Lunas</option>
                    </select>
                </div>

                <div>
                    <label class="text-xs font-semibold text-gray-600 mb-1 block">Tanggal Sewa WO</label>
                    <input type="date" id="inputTglSewa" name="tgl_sewa_WO" required class="w-full border rounded-lg p-2.5 text-xs focus:outline-none focus:border-[#1e314b]">
                </div>

                <div>
                    <label class="text-xs font-semibold text-gray-600 mb-1 block">Nominal DP WO (Rp)</label>
                    <input type="number" id="inputDpWo" name="dp_WO" required class="w-full border rounded-lg p-2.5 text-xs focus:outline-none focus:border-[#1e314b]">
                </div>

                <div>
                    <label class="text-xs font-semibold text-gray-600 mb-1 block">Tanggal Perhitungan Pelunasan</label>
                    <input type="date" id="inputTglHitung" name="tgl_hitung_pelunasan" required class="w-full border rounded-lg p-2.5 text-xs focus:outline-none focus:border-[#1e314b]">
                </div>

                <div>
                    <label class="text-xs font-semibold text-gray-600 mb-1 block">Sisa Pelunasan WO (Rp)</label>
                    <input type="number" id="inputSisaWo" name="sisa_pelunasan_WO" required class="w-full border rounded-lg p-2.5 text-xs focus:outline-none focus:border-[#1e314b]">
                </div>

                <div>
                    <label class="text-xs font-semibold text-gray-600 mb-1 block">Tanggal Jatuh Tempo</label>
                    <input type="date" id="inputJatuhTempo" name="tgl_Jatuh_tempo" required class="w-full border rounded-lg p-2.5 text-xs focus:outline-none focus:border-[#1e314b]">
                </div>

                <div class="flex justify-end gap-2 pt-3 border-t">
                    <button type="button" @click="showEditModal = false" class="px-4 py-2 border rounded-xl text-xs font-semibold text-gray-600">Batal</button>
                    <button type="submit" class="px-5 py-2 bg-[#1e314b] text-white rounded-xl text-xs font-semibold hover:bg-slate-800 transition-colors shadow-sm">Simpan Keuangan</button>
                </div>
            </form>
        </div>
    </div>

</main>

<!-- SCRIPT FILTERING INTERAKTIF -->
<script>
    const rawEvents = [
        @foreach($events as $e)
        {
            id: {{ $e->id_pemesanan }},
            bulan: '{{ \Carbon\Carbon::parse($e->tgl_acara)->format("m") }}',
            nama: {!! json_encode(($e->klien->nama_pria ?? '') . ' & ' . ($e->klien->nama_wanita ?? '')) !!},
            tglAcaraFormatted: '{{ \Carbon\Carbon::parse($e->tgl_acara)->translatedFormat("d F Y") }}',
            tglAcaraRaw: '{{ \Carbon\Carbon::parse($e->tgl_acara)->format("d/m/Y") }}',
            lokasi: {!! json_encode($e->lokasi_acara) !!},
            paketNama: {!! json_encode($e->paket->nama_paket ?? 'Custom Package') !!},
            hargaPaket: {{ $e->paket->harga_paket ?? 0 }},
            dpWo: {{ $e->keuangan->dp_WO ?? 0 }},
            sisaWo: {{ $e->keuangan->sisa_pelunasan_WO ?? 0 }},
            statusPembayaran: {!! json_encode($e->keuangan->status_pembayaran ?? 'Pending') !!},
            tglSewa: '{{ $e->keuangan->tgl_sewa_WO ?? "" }}',
            tglHitung: '{{ $e->keuangan->tgl_hitung_pelunasan ?? "" }}',
            tglJatuhTempo: '{{ $e->keuangan->tgl_Jatuh_tempo ?? "" }}',
            updateUrl: '{{ route("admin.keuangan.update", $e->id_pemesanan) }}'
        },
        @endforeach
    ];

    function formatRupiah(num) {
        return 'Rp ' + new Intl.NumberFormat('id-ID').format(num);
    }

    function formatDateIndo(dateStr) {
        if(!dateStr) return '-';
        const d = new Date(dateStr);
        if(isNaN(d)) return '-';
        return d.toLocaleDateString('id-ID', { day: '2-digit', month: 'long', year: 'numeric' });
    }

    function formatDateShort(dateStr) {
        if(!dateStr) return '-';
        const d = new Date(dateStr);
        if(isNaN(d)) return '-';
        return d.toLocaleDateString('id-ID', { day: '2-digit', month: '2-digit', year: 'numeric' });
    }

    function filterKlienByBulan() {
        const selectedBulan = document.getElementById('filterBulan').value;
        const selectKlien = document.getElementById('filterKlien');

        let filteredEvents = rawEvents;
        if(selectedBulan !== "") {
            filteredEvents = rawEvents.filter(e => e.bulan === selectedBulan);
        }

        selectKlien.innerHTML = '';

        if(filteredEvents.length > 0) {
            filteredEvents.forEach(e => {
                const opt = document.createElement('option');
                opt.value = e.id;
                opt.innerText = `${e.nama} (${e.tglAcaraRaw})`;
                selectKlien.appendChild(opt);
            });

            document.getElementById('contentArea').classList.remove('hidden');
            document.getElementById('emptyArea').classList.add('hidden');

            renderDetailKeuangan(filteredEvents[0].id);
        } else {
            const opt = document.createElement('option');
            opt.value = '';
            opt.innerText = '-- Tidak Ada Pengantin di Bulan Ini --';
            selectKlien.appendChild(opt);

            document.getElementById('contentArea').classList.add('hidden');
            document.getElementById('emptyArea').classList.remove('hidden');
        }
    }

    function renderDetailKeuangan(idPemesanan) {
        const event = rawEvents.find(e => e.id == idPemesanan);
        if(!event) return;

        // Render Card Top
        document.getElementById('cardPaketNama').innerText = event.paketNama;
        document.getElementById('cardHargaPaket').innerText = formatRupiah(event.hargaPaket);
        
        document.getElementById('cardTglSewa').innerText = 'Tgl Sewa: ' + formatDateShort(event.tglSewa);
        document.getElementById('cardDpWo').innerText = formatRupiah(event.dpWo);

        document.getElementById('cardJatuhTempo').innerText = 'Jatuh Tempo: ' + formatDateShort(event.tglJatuhTempo);
        document.getElementById('cardSisaWo').innerText = formatRupiah(event.sisaWo);

        // Render Rincian Detail
        document.getElementById('detailNamaTitle').innerText = 'Rincian Pembayaran WO - ' + event.nama;
        document.getElementById('detailAcaraSubtitle').innerText = `Tanggal Acara: ${event.tglAcaraFormatted} (${event.lokasi})`;

        // Badge Status Pembayaran (Lunas / Pending)
        const isLunas = (event.statusPembayaran || '').toLowerCase() === 'lunas';
        const badgeHtml = isLunas
            ? `<span class="bg-emerald-100 text-emerald-800 text-xs px-3 py-1 rounded-full font-bold uppercase tracking-wider">LUNAS</span>`
            : `<span class="bg-amber-100 text-amber-800 text-xs px-3 py-1 rounded-full font-bold uppercase tracking-wider">PENDING</span>`;
        document.getElementById('badgeStatusPembayaran').innerHTML = badgeHtml;

        document.getElementById('detailTglSewa').innerText = formatDateIndo(event.tglSewa);
        document.getElementById('detailDpWo').innerText = formatRupiah(event.dpWo);
        document.getElementById('detailTglHitung').innerText = formatDateIndo(event.tglHitung);

        document.getElementById('detailSisaWo').innerText = formatRupiah(event.sisaWo);
        document.getElementById('detailJatuhTempo').innerText = formatDateIndo(event.tglJatuhTempo);
        document.getElementById('detailTotal').innerText = formatRupiah(event.dpWo + event.sisaWo);

        // Populate Form Modal Action & Input Values
        document.getElementById('formEditKeuangan').action = event.updateUrl;
        document.getElementById('inputStatusPembayaran').value = event.statusPembayaran || 'Pending';
        document.getElementById('inputTglSewa').value = event.tglSewa;
        document.getElementById('inputDpWo').value = event.dpWo;
        document.getElementById('inputTglHitung').value = event.tglHitung;
        document.getElementById('inputSisaWo').value = event.sisaWo;
        document.getElementById('inputJatuhTempo').value = event.tglJatuhTempo;
    }

    document.addEventListener('DOMContentLoaded', function() {
        filterKlienByBulan();
    });
</script>
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.min.js" defer></script>
@endsection