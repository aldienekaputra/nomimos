@extends('layouts.klien')

@section('content')
<div class="max-w-6xl mx-auto space-y-10 py-4">

    <!-- BAGIAN 1: KEUANGAN WO -->
    <div class="space-y-4">
        <h2 class="font-serif-title text-2xl md:text-3xl font-bold text-black tracking-tight">
            Keuangan WO
        </h2>

        <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100 overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="font-serif-title text-sm md:text-base font-bold text-black border-b border-slate-100 pb-3">
                        <th class="py-3 px-2">No.</th>
                        <th class="py-3 px-2">Nama</th>
                        <th class="py-3 px-2">Tanggal</th>
                        <th class="py-3 px-2">Paket</th>
                        <th class="py-3 px-2">Nominal DP</th>
                        <th class="py-3 px-2">Sisa Tagihan</th>
                        <th class="py-3 px-2 text-center">Status</th>
                        <th class="py-3 px-2">Tgl Lns</th>
                        <th class="py-3 px-2">Jatuh Tempo</th>
                        <th class="py-3 px-2">Total</th>
                    </tr>
                </thead>
                <tbody class="font-sans text-xs md:text-sm text-black">
                    @if($pemesanan && $pemesanan->keuangan)
                        @php
                            $statusWo = $pemesanan->keuangan->status_pembayaran ?? 'Pending';
                            $isLunas = in_array(strtolower($statusWo), ['lunas', 'confirmed']);
                            $dp = $pemesanan->keuangan->dp_WO ?? 0;
                            $sisa = $pemesanan->keuangan->sisa_pelunasan_WO ?? 0;
                            $total = $dp + $sisa;
                        @endphp
                        <tr class="border-b border-slate-50">
                            <td class="py-4 px-2 font-semibold">1.</td>
                            <td class="py-4 px-2 font-medium">
                                {{ $klien ? $klien->nama_pria . ' / ' . $klien->nama_wanita : '-' }}
                            </td>
                            <td class="py-4 px-2">
                                {{ \Carbon\Carbon::parse($pemesanan->tgl_acara)->format('d/m/y') }}
                            </td>
                            <td class="py-4 px-2">
                                {{ $pemesanan->paket->nama_paket ?? '-' }}
                            </td>
                            <td class="py-4 px-2">
                                Rp {{ number_format($dp, 0, ',', '.') }}
                            </td>
                            <td class="py-4 px-2">
                                Rp {{ number_format($sisa, 0, ',', '.') }}
                            </td>
                            <td class="py-4 px-2 text-center">
                                <span class="px-4 py-1 rounded-full text-white text-xs font-semibold inline-block
                                    {{ $isLunas ? 'bg-emerald-500' : 'bg-amber-500' }}">
                                    {{ $isLunas ? 'Lunas' : 'Pending' }}
                                </span>
                            </td>
                            <td class="py-4 px-2">
                                {{ !empty($pemesanan->keuangan->tgl_hitung_pelunasan) ? \Carbon\Carbon::parse($pemesanan->keuangan->tgl_hitung_pelunasan)->format('d/m/y') : '-' }}
                            </td>
                            <td class="py-4 px-2">
                                {{ !empty($pemesanan->keuangan->tgl_Jatuh_tempo) ? \Carbon\Carbon::parse($pemesanan->keuangan->tgl_Jatuh_tempo)->format('d/m/y') : '-' }}
                            </td>
                            <td class="py-4 px-2 font-bold">
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

        <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100 overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="font-serif-title text-sm md:text-base font-bold text-black border-b border-slate-100 pb-3">
                        <th class="py-3 px-2">No.</th>
                        <th class="py-3 px-2">Nama Vendor</th>
                        <th class="py-3 px-2">Nominal DP</th>
                        <th class="py-3 px-2">Nominal Pelunasan</th>
                        <th class="py-3 px-2">Total Transaksi</th>
                        <th class="py-3 px-2">Tgl Bayar</th>
                        <th class="py-3 px-2 text-center">Status</th>
                    </tr>
                </thead>
                <tbody class="font-sans text-xs md:text-sm text-black">
                    @if($pemesanan && $pemesanan->pembayaranVendors && $pemesanan->pembayaranVendors->count() > 0)
                        @foreach($pemesanan->pembayaranVendors as $index => $pv)
                        @php
                            $totalTransaksi = ($pv->nominal_dp ?? 0) + ($pv->nominal_pelunasan ?? 0);
                            // MEMBACA KOLOM MYSQL: status_bayar_vendor
                            $statusVendor = $pv->status_bayar_vendor ?? 'Pending';
                            $isVendorLunas = in_array(strtolower($statusVendor), ['confirmed', 'lunas']);
                        @endphp
                        <tr class="border-b border-slate-50">
                            <td class="py-4 px-2 font-semibold">{{ $index + 1 }}</td>
                            <td class="py-4 px-2 font-medium">
                                {{ $pv->vendor->nama_vendor ?? ($pv->nama_vendor ?? '-') }}
                            </td>
                            <td class="py-4 px-2">
                                Rp {{ number_format($pv->nominal_dp ?? 0, 0, ',', '.') }}
                            </td>
                            <td class="py-4 px-2">
                                Rp {{ number_format($pv->nominal_pelunasan ?? 0, 0, ',', '.') }}
                            </td>
                            <td class="py-4 px-2 font-semibold">
                                Rp {{ number_format($totalTransaksi, 0, ',', '.') }}
                            </td>
                            <td class="py-4 px-2">
                                {{ !empty($pv->tgl_bayar) ? \Carbon\Carbon::parse($pv->tgl_bayar)->format('d/m/Y') : '-' }}
                            </td>
                            <td class="py-4 px-2 text-center">
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