@extends('layouts.crew')

@section('content')
<div class="max-w-6xl mx-auto space-y-8 py-2">

    <!-- HEADER & WELCOME -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 border-b border-slate-300 pb-6">
        <div>
            <h1 class="font-serif-title text-3xl md:text-4xl font-bold text-black tracking-tight">
                Dashboard Tim Crew
            </h1>
            <p class="font-serif-title text-sm md:text-base text-slate-600 mt-1">
                Selamat bekerja, {{ $crew->nama_crew ?? Auth::user()->username }}! Berikut adalah daftar penugasan event Anda.
            </p>
        </div>
        <div class="bg-white px-5 py-3 rounded-2xl shadow-sm border border-slate-200 flex items-center gap-3">
            <div class="w-10 h-10 rounded-full bg-[#1e314b] text-white flex items-center justify-center font-bold text-lg font-serif-title">
                {{ strtoupper(substr($crew->nama_crew ?? Auth::user()->username, 0, 1)) }}
            </div>
            <div>
                <span class="block text-xs text-slate-400 font-semibold uppercase tracking-wider">Peran Crew</span>
                <span class="text-sm font-bold text-slate-800">{{ $crew->peran ?? 'Team Event' }}</span>
            </div>
        </div>
    </div>

    <!-- DAFTAR PENUGASAN JOBDESK EVENT -->
    <div class="space-y-4">
        <h2 class="font-serif-title text-xl md:text-2xl font-bold text-black tracking-tight">
            Jadwal & Jobdesk Penugasan
        </h2>

        <div class="bg-white rounded-3xl p-6 md:p-8 shadow-sm border border-slate-100 overflow-x-auto">
            @if($jobdesks && $jobdesks->count() > 0)
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="font-serif-title text-sm md:text-base font-bold text-black border-b border-slate-200 pb-3">
                            <th class="py-3 px-3 w-12 text-center">No</th>
                            <th class="py-3 px-3">Nama Event / Pengantin</th>
                            <th class="py-3 px-3">Tanggal Acara</th>
                            <th class="py-3 px-3">Lokasi</th>
                            <th class="py-3 px-3">Tugas / Jobdesk</th>
                        </tr>
                    </thead>
                    <tbody class="font-sans text-xs md:text-sm text-black divide-y divide-slate-100">
                        @foreach($jobdesks as $index => $jd)
                        @php
                            $pemesanan = $jd->pemesanan;
                            $klien = $pemesanan->klien ?? null;
                        @endphp
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="py-4 px-3 text-center font-semibold text-slate-600">{{ $index + 1 }}</td>
                            <td class="py-4 px-3 font-serif-title font-bold text-black">
                                {{ $klien ? $klien->nama_pria . ' & ' . $klien->nama_wanita : 'Event #' . $jd->id_pemesanan }}
                            </td>
                            <td class="py-4 px-3 font-medium text-slate-700">
                                {{ !empty($pemesanan->tgl_acara) ? \Carbon\Carbon::parse($pemesanan->tgl_acara)->format('d M Y') : '-' }}
                            </td>
                            <td class="py-4 px-3 text-slate-600">
                                {{ $pemesanan->lokasi_acara ?? '-' }}
                            </td>
                            <td class="py-4 px-3">
                                <span class="bg-slate-100 px-3 py-1.5 rounded-lg text-xs font-semibold text-[#1e314b] inline-block border border-slate-200">
                                    {{ $jd->jobdesk ?? 'Pendamping Acara' }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="py-12 text-center space-y-2">
                    <p class="font-serif-title text-base font-semibold text-slate-700">
                        Belum Ada Penugasan Acara
                    </p>
                    <p class="text-xs text-slate-400">
                        Anda belum ditugaskan ke event manapun oleh admin. Silakan cek kembali nanti.
                    </p>
                </div>
            @endif
        </div>
    </div>

</div>
@endsection