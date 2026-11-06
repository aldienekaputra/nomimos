<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PemesananAcara;
use App\Models\PaketAcara;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    // METHOD UNTUK MENAMPILKAN HALAMAN BOOKING LANDING PAGE
    public function index()
    {
        $pakets = PaketAcara::all();
        $pemesanans = PemesananAcara::select('tgl_acara', 'status_acc')->get();

        return view('landing.booking', compact('pakets', 'pemesanans'));
    }

    // METHOD PROSES SIMPAN BOOKING
    public function store(Request $request)
    {
        $request->validate([
            'id_paket'     => 'required|exists:paket_acara,id_paket',
            'tgl_acara'    => 'required|date',
            'lokasi_acara' => 'required|string|max:255',
        ]);

        $user = Auth::user();

        if (!$user || $user->role !== 'Klien' || !$user->klien) {
            return back()->with('error', 'Anda harus login sebagai akun Klien untuk melakukan booking!');
        }

        try {
            PemesananAcara::create([
                'id_klien'     => $user->klien->id_klien,
                'id_paket'     => $request->id_paket,
                'tgl_acara'    => $request->tgl_acara,
                'lokasi_acara' => $request->lokasi_acara,
                'status_acc'   => 'Pending',
            ]);

            return redirect()->route('klien.dashboard')->with('success', 'Booking berhasil dikirim! Mohon tunggu konfirmasi dari Admin NOMIMOS.');

        } catch (\Exception $e) {
            return back()->with('error', 'Gagal mengirim booking: ' . $e->getMessage());
        }
    }
}