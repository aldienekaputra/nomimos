<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PemesananAcara;
use App\Models\KeuanganAcara;

class FinanceController extends Controller
{
    public function index()
    {
        $events = PemesananAcara::with(['klien', 'paket', 'keuangan'])
            ->where('status_acc', 'ACC')
            ->orderBy('tgl_acara', 'ASC')
            ->get();

        return view('admin.keuangan', compact('events'));
    }

    public function update(Request $request, $id_pemesanan)
    {
        $request->validate([
            'status_pembayaran'     => 'required|string',
            'tgl_sewa_WO'           => 'required|date',
            'dp_WO'                 => 'required|numeric',
            'tgl_hitung_pelunasan' => 'required|date',
            'sisa_pelunasan_WO'     => 'required|numeric',
            'tgl_Jatuh_tempo'       => 'required|date',
        ]);

        KeuanganAcara::updateOrCreate(
            ['id_pemesanan' => $id_pemesanan],
            [
                'status_pembayaran'     => $request->status_pembayaran,
                'tgl_sewa_WO'           => $request->tgl_sewa_WO,
                'dp_WO'                 => $request->dp_WO,
                'tgl_hitung_pelunasan' => $request->tgl_hitung_pelunasan,
                'sisa_pelunasan_WO'     => $request->sisa_pelunasan_WO,
                'tgl_Jatuh_tempo'       => $request->tgl_Jatuh_tempo,
            ]
        );

        return back()->with('success', 'Rincian keuangan WO berhasil diperbarui!');
    }
}