<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PemesananAcara;

class AdminController extends Controller
{
    public function index()
    {
        // Mengambil data pemesanan beserta relasi Klien, Paket, dan Keuangan
        $events = PemesananAcara::with(['klien', 'paket', 'keuangan'])
            ->orderBy('id_pemesanan', 'DESC')
            ->get();

        return view('admin.dashboard', compact('events'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status_acc' => 'required|in:Pending,ACC,Batal',
        ]);

        $pemesanan = PemesananAcara::findOrFail($id);
        $pemesanan->update([
            'status_acc' => $request->status_acc
        ]);

        return redirect()->back()->with('success', 'Status pemesanan berhasil diperbarui!');
    }

    public function keuangan()
    {
        // Ambil seluruh pemesanan yang sudah ACC beserta relasinya
        $events = PemesananAcara::with(['klien', 'paket', 'keuangan'])
            ->where('status_acc', 'ACC')
            ->orderBy('tgl_acara', 'ASC')
            ->get();

        return view('admin.keuangan', compact('events'));
    }
}