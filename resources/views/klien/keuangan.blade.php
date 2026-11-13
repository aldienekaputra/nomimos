@extends('layouts.klien')

@section('content')
<div class="max-w-6xl mx-auto space-y-8 md:space-y-10 py-2 md:py-4">

    <!-- BAGIAN 1: KEUANGAN WO -->
    <div class="space-y-4">
        <h2 class="font-serif-title text-2xl md:text-3xl font-bold text-black tracking-tight">
            Keuangan WO
        </h2>

        <div class="bg-white rounded-2xl p-4 sm:p-6 shadow-sm border border-slate-100 overflow-x-auto">
            <table class="w-full text-left border-collapse min-w-[750px]">
                <thead>
                    <tr class="font-serif-title text-sm md:text-base font-bold text-black border-b border-slate-100 pb-3">
                        <th class="py-3 px-2 whitespace-nowrap">No.</th>
                        <th class="py-3 px-2 whitespace-nowrap">Nama</th>
                        <th class="py-3 px-2 whitespace-nowrap">Tanggal</th>
                        <th class="py-3 px-2 whitespace-nowrap">Paket</th>
                        <th class="py-3 px-2 whitespace-nowrap">Nominal DP</th>
                        <th class="py-3 px-2 whitespace-nowrap">Sisa Tagihan</th>
                        <th class="py-3 px-2 text-center whitespace-nowrap">Status</th>
                        <th class="py-3 px-2 whitespace-nowrap">Tgl Lns</th>
                        <th class="py-3 px-2 whitespace-nowrap">Jatuh Tempo</th>
                        <th class="py-3 px-2 whitespace-nowrap">Total</th>
                    </tr>
                </thead>
                <tbody class="font-sans text-xs md:text-sm text-black">
                    @if($pemesanan && $pemesanan->keuangan)
                        @php
                            $statusWo = $pemesanan->keuangan->status_pembayaran ?? 'Pending';
                            $isLunas = in_array(strtolower($statusWo), ['lunas', 'confirmed']);
                            // Mendukung lowercase (PostgreSQL Supabase) & uppercase (MySQL lokal)
                            $dp = $pemesanan->keuangan->dp_wo ?? ($pemesanan->keuangan->dp_WO ?? 0);
                            $sisa = $pemesanan->keuangan->sisa_pelunasan_wo ?? ($pemesanan->keuangan->sisa_pelunasan_WO ?? 0);
                            $tglJatuhTempo = $pemesanan->keuangan->tgl_jatuh_tempo ?? ($pemesanan->keuangan->tgl_Jatuh_tempo ?? null);
                            $total = $dp + $sisa;
                        @endphp
                        <tr class="border-b border-slate-50">
                            <td class="py-4 px-2 font-semibold whitespace-nowrap">1.</td>
                            <td class="py-4 px-2 font-medium whitespace-nowrap">
                                {{ $klien ? $klien->nama_pria . ' / ' . $klien->nama_wanita : '-' }}
                            </td>
                            <td class="py-4 px-2 whitespace-nowrap">
                                {{ \Carbon\Carbon::parse($pemesanan->tgl_acara)->format('d/m/y') }}
                            </td>
                            <td class="py-4 px-2 whitespace-nowrap">
                                {{ $pemesanan->paket->nama_paket ?? '-' }}
                            </td>
                            <td class="py-4 px-2 whitespace-nowrap">
                                Rp {{ number_format($dp, 0, ',', '.') }}
                            </td>
                            <td class="py-4 px-2 whitespace-nowrap">
                                Rp {{ number_format($sisa, 0, ',', '.') }}
                            </td>
                            <td class="py-4 px-2 text-center whitespace-nowrap">
                                <span class="px-4 py-1 rounded-full text-white text-xs font-semibold inline-block
                                    {{ $isLunas ? 'bg-emerald-500' : 'bg-amber-500' }}">
                                    {{ $isLunas ? 'Lunas' : 'Pending' }}
                                </span>
                            </td>
                            <td class="py-4 px-2 whitespace-nowrap">
                                {{ !empty($pemesanan->keuangan->tgl_hitung_pelunasan) ? \Carbon\Carbon::parse($pemesanan->keuangan->tgl_hitung_pelunasan)->format('d/m/y') : '-' }}
                            </td>
                            <td class="py-4 px-2 whitespace-nowrap">
                                {{ !empty($tglJatuhTempo) ? \Carbon\Carbon::parse($tglJatuhTempo)->format('d/m/y') : '-' }}
                            </td>
                            <td class="py-4 px-2 font-bold whitespace-nowrap">
                                Rp {{ number_format($total > 0 ? $total : ($pemesanan->paket->harga_paket ?? 0), 0, ',', '.') }}
                            </td>
                        </tr>
                    @else
                        <tr>
                            <td colspan="10" class="py-6 text-center text-slate-400 italic">Belum ada data keuangan WO untuk acara ini.</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>

    <!-- BAGIAN 2: KEUANGAN VENDOR -->
    <div class="space-y-4">
        <h2 class="font-serif-title text-2xl md:text-3xl font-bold text-black tracking-tight">
            Keuangan Vendor
        </h2>

        <div class="bg-white rounded-2xl p-4 sm:p-6 shadow-sm border border-slate-100 overflow-x-auto">
            <table class="w-full text-left border-collapse min-w-[650px]">
                <thead>
                    <tr class="font-serif-title text-sm md:text-base font-bold text-black border-b border-slate-100 pb-3">
                        <th class="py-3 px-2 whitespace-nowrap">No.</th>
                        <th class="py-3 px-2 whitespace-nowrap">Nama Vendor</th>
                        <th class="py-3 px-2 whitespace-nowrap">Nominal DP</th>
                        <th class="py-3 px-2 whitespace-nowrap">Nominal Pelunasan</th>
                        <th class="py-3 px-2 whitespace-nowrap">Total Transaksi</th>
                        <th class="py-3 px-2 whitespace-nowrap">Tgl Bayar</th>
                        <th class="py-3 px-2 text-center whitespace-nowrap">Status</th>
                    </tr>
                </thead>
                <tbody class="font-sans text-xs md:text-sm text-black">
                    @if($pemesanan && $pemesanan->pembayaranVendors && $pemesanan->pembayaranVendors->count() > 0)
                        @foreach($pemesanan->pembayaranVendors as $index => $pv)
                        @php
                            $totalTransaksi = ($pv->nominal_dp ?? 0) + ($pv->nominal_pelunasan ?? 0);
                            $statusVendor = $pv->status_bayar_vendor ?? 'Pending';
                            $isVendorLunas = in_array(strtolower($statusVendor), ['confirmed', 'lunas']);
                        @endphp
                        <tr class="border-b border-slate-50">
                            <td class="py-4 px-2 font-semibold whitespace-nowrap">{{ $index + 1 }}</td>
                            <td class="py-4 px-2 font-medium whitespace-nowrap">
                                {{ $pv->vendor->nama_vendor ?? ($pv->nama_vendor ?? '-') }}
                            </td>
                            <td class="py-4 px-2 whitespace-nowrap">
                                Rp {{ number_format($pv->nominal_dp ?? 0, 0, ',', '.') }}
                            </td>
                            <td class="py-4 px-2 whitespace-nowrap">
                                Rp {{ number_format($pv->nominal_pelunasan ?? 0, 0, ',', '.') }}
                            </td>
                            <td class="py-4 px-2 font-semibold whitespace-nowrap">
                                Rp {{ number_format($totalTransaksi, 0, ',', '.') }}
                            </td>
                            <td class="py-4 px-2 whitespace-nowrap">
                                {{ !empty($pv->tgl_bayar) ? \Carbon\Carbon::parse($pv->tgl_bayar)->format('d/m/Y') : '-' }}
                            </td>
                            <td class="py-4 px-2 text-center whitespace-nowrap">
                                <span class="px-4 py-1 rounded-full text-white text-xs font-semibold inline-block 
                                    {{ $isVendorLunas ? 'bg-emerald-500' : 'bg-amber-500' }}">
                                    {{ $isVendorLunas ? 'Lunas' : 'Pending' }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="7" class="py-6 text-center text-slate-400 italic">Belum ada data pembayaran vendor untuk acara ini.</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection