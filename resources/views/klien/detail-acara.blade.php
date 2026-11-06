@extends('layouts.klien')

@section('content')
<!-- BUNGKUS DENGAN STATE TAB ALPINE.JS (DILEBARKAN DENGAN max-w-6xl) -->
<div x-data="{ activeTab: 'rundown' }" class="max-w-6xl mx-auto space-y-8 py-4">

    <!-- DYNAMIC TITLE ACCORDING TO ACTIVE TAB -->
    <h1 class="font-serif-title text-3xl md:text-4xl font-bold text-black tracking-tight"
        x-text="activeTab === 'rundown' ? 'Rundown Wedding' : (activeTab === 'moodboard' ? 'Moodboard Wedding' : 'Note & List Wedding')">
        Rundown Wedding
    </h1>

    <!-- SUB-NAVIGASI BUTTON TAB -->
    <div class="flex items-center gap-4">
        <button type="button" 
                @click="activeTab = 'rundown'"
                :class="activeTab === 'rundown' ? 'bg-[#1e314b] text-white' : 'bg-slate-200 text-slate-700 hover:bg-slate-300'"
                class="px-8 py-2.5 rounded-lg text-sm font-semibold transition-all shadow-sm">
            Rundown
        </button>

        <button type="button" 
                @click="activeTab = 'moodboard'"
                :class="activeTab === 'moodboard' ? 'bg-[#1e314b] text-white' : 'bg-slate-200 text-slate-700 hover:bg-slate-300'"
                class="px-8 py-2.5 rounded-lg text-sm font-semibold transition-all shadow-sm">
            Moodboard
        </button>

        <button type="button" 
                @click="activeTab = 'note'"
                :class="activeTab === 'note' ? 'bg-[#1e314b] text-white' : 'bg-slate-200 text-slate-700 hover:bg-slate-300'"
                class="px-8 py-2.5 rounded-lg text-sm font-semibold transition-all shadow-sm">
            Note & List
        </button>
    </div>

    <!-- TAB KONTEN 1: RUNDOWN (CARD LEBAR) -->
    <div x-show="activeTab === 'rundown'" class="bg-white rounded-2xl p-6 md:p-8 shadow-sm border border-slate-100 space-y-4">
        <h3 class="font-serif-title text-xl font-bold text-black mb-4">Susunan Acara (Rundown)</h3>
        
        @if($pemesanan && $pemesanan->rundown && $pemesanan->rundown->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="font-serif-title text-sm md:text-base font-bold text-black border-b border-slate-200 pb-3">
                            <th class="py-3 px-3 w-12 text-center">No</th>
                            <th class="py-3 px-3 whitespace-nowrap">Waktu</th>
                            <th class="py-3 px-3">Nama Kegiatan</th>
                            <th class="py-3 px-3">Penanggung Jawab (PIC)</th>
                            <th class="py-3 px-3">Keterangan / Detail</th>
                        </tr>
                    </thead>
                    <tbody class="font-sans text-xs md:text-sm text-black divide-y divide-slate-100">
                        @foreach($pemesanan->rundown as $index => $rd)
                        @php
                            // Format jam 08:00:00 -> 08:00 agar rapi tidak terlalu panjang
                            $wm = !empty($rd->waktu_mulai) ? date('H:i', strtotime($rd->waktu_mulai)) : '00:00';
                            $ws = !empty($rd->waktu_selesai) ? date('H:i', strtotime($rd->waktu_selesai)) : '00:00';
                        @endphp
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="py-4 px-3 text-center font-semibold text-slate-600">{{ $index + 1 }}</td>
                            <td class="py-4 px-3 font-mono font-bold text-[#1e314b] whitespace-nowrap">
                                {{ $wm }} - {{ $ws }}
                            </td>
                            <td class="py-4 px-3 font-semibold text-black">
                                {{ $rd->nama_kegiatan ?? '-' }}
                            </td>
                            <td class="py-4 px-3">
                                <span class="bg-slate-100 px-3 py-1 rounded-md text-xs font-medium text-slate-700 inline-block">
                                    {{ $rd->penanggung_jawab ?? ($rd->pic ?? 'Tim WO') }}
                                </span>
                            </td>
                            <td class="py-4 px-3 text-slate-600 leading-relaxed">
                                {{ $rd->keterangan ?? '-' }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="text-sm text-slate-500 italic py-8 text-center">Belum ada data rundown acara dari tim organizer.</p>
        @endif
    </div>

    <!-- TAB KONTEN 2: MOODBOARD -->
    <div x-show="activeTab === 'moodboard'" x-cloak class="grid md:grid-cols-2 gap-6">
        @if($pemesanan && $pemesanan->moodboard && $pemesanan->moodboard->count() > 0)
            @foreach($pemesanan->moodboard as $mb)
            @php
                // Tentukan path gambar: cek jika berupa URL eksternal atau file ter-upload di storage
                $gambarPath = $mb->url_gambar ?? $mb->foto ?? '';
                $imgSrc = \Illuminate\Support\Str::startsWith($gambarPath, ['http://', 'https://']) 
                    ? $gambarPath 
                    : url('storage/' . $gambarPath);
            @endphp
            <div class="bg-white rounded-2xl p-4 shadow-sm border border-slate-100 flex gap-5 items-start">
                <img src="{{ $imgSrc }}" alt="{{ $mb->keterangan ?? 'Moodboard' }}" class="w-40 h-32 object-cover rounded-xl flex-shrink-0 bg-slate-100 border border-slate-200">
                <div class="space-y-1 pt-1">
                    <h3 class="font-serif-title text-lg font-bold text-black">{{ $mb->keterangan ?? 'Referensi Dekorasi' }}</h3>
                    <p class="font-serif-title text-sm text-slate-600">{{ $mb->keterangan ?? '-' }}</p>
                </div>
            </div>
            @endforeach
        @else
            <div class="col-span-2 bg-white rounded-2xl p-8 shadow-sm border border-slate-100 text-center">
                <p class="text-sm text-slate-500 italic">Belum ada item moodboard yang diunggah oleh admin.</p>
            </div>
        @endif
    </div>

    <!-- TAB KONTEN 3: NOTE & LIST (PERBAIKAN NAMA ATRIBUT CATATAN KE LOWERCASE: list_vip & list_foto_vvip) -->
    <div x-show="activeTab === 'note'" x-cloak class="bg-white rounded-2xl p-8 shadow-sm border border-slate-100 space-y-6">
        <h3 class="font-serif-title text-xl font-bold text-black mb-2">Catatan Khusus & Daftar Keperluan</h3>
        
        @if($pemesanan && $pemesanan->catatan)
            <div class="grid md:grid-cols-2 gap-6 text-sm text-black">
                @if(!empty($pemesanan->catatan->list_vip) || !empty($pemesanan->catatan->list_VIP))
                <div class="p-4 bg-slate-50 rounded-xl border border-slate-200 space-y-1">
                    <span class="font-bold block font-serif-title text-base text-[#1e314b]">List Tamu VIP:</span>
                    <p class="text-slate-700 whitespace-pre-line">{{ $pemesanan->catatan->list_vip ?? $pemesanan->catatan->list_VIP }}</p>
                </div>
                @endif

                @if(!empty($pemesanan->catatan->req_lagu))
                <div class="p-4 bg-slate-50 rounded-xl border border-slate-200 space-y-1">
                    <span class="font-bold block font-serif-title text-base text-[#1e314b]">Request Lagu:</span>
                    <p class="text-slate-700 whitespace-pre-line">{{ $pemesanan->catatan->req_lagu }}</p>
                </div>
                @endif

                @if(!empty($pemesanan->catatan->list_foto_vvip) || !empty($pemesanan->catatan->list_foto_VVIP))
                <div class="p-4 bg-slate-50 rounded-xl border border-slate-200 space-y-1">
                    <span class="font-bold block font-serif-title text-base text-[#1e314b]">List Foto VVIP:</span>
                    <p class="text-slate-700 whitespace-pre-line">{{ $pemesanan->catatan->list_foto_vvip ?? $pemesanan->catatan->list_foto_VVIP }}</p>
                </div>
                @endif

                @if(!empty($pemesanan->catatan->petugas_keluarga))
                <div class="p-4 bg-slate-50 rounded-xl border border-slate-200 space-y-1">
                    <span class="font-bold block font-serif-title text-base text-[#1e314b]">Petugas / Panitia Keluarga:</span>
                    <p class="text-slate-700 whitespace-pre-line">{{ $pemesanan->catatan->petugas_keluarga }}</p>
                </div>
                @endif

                @if(!empty($pemesanan->catatan->catatan_kebutuhan))
                <div class="md:col-span-2 p-4 bg-slate-50 rounded-xl border border-slate-200 space-y-1">
                    <span class="font-bold block font-serif-title text-base text-[#1e314b]">Catatan Tambahan & Kebutuhan Khusus:</span>
                    <p class="text-slate-700 whitespace-pre-line">{{ $pemesanan->catatan->catatan_kebutuhan }}</p>
                </div>
                @endif
            </div>
        @else
            <p class="text-sm text-slate-500 italic py-4 text-center">Belum ada catatan khusus dari tim organizer.</p>
        @endif
    </div>

</div>

<!-- SCRIPT ALPINE JS -->
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.min.js" defer></script>
@endsection