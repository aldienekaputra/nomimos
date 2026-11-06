<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PemesananAcara;
use App\Models\Vendor;
use App\Models\PembayaranVendor;

class VendorController extends Controller
{
    public function index()
    {
        // 1. Ambil seluruh acara yang berstatus ACC beserta relasi Klien & Pembayaran Vendor
        $events = PemesananAcara::with(['klien', 'pembayaranVendors.vendor'])
            ->where('status_acc', 'ACC')
            ->orderBy('tgl_acara', 'ASC')
            ->get();

        // 2. Ambil master vendor untuk dropdown modal tambah vendor
        $masterVendor = Vendor::all();

        return view('admin.vendor', compact('events', 'masterVendor'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_pemesanan'        => 'required',
            'nominal_dp'          => 'required|numeric',
            'nominal_pelunasan'   => 'required|numeric',
            'tgl_bayar'           => 'required|date',
            'status_bayar_vendor' => 'required',
        ]);

        // 1. Cek apakah user memilih vendor lama atau menginput vendor baru
        if ($request->filled('id_vendor')) {
            $idVendor = $request->id_vendor;
        } else {
            // Validasi input vendor baru
            $request->validate([
                'nama_vendor_baru'     => 'required|string|max:100',
                'kategori_vendor_baru' => 'required|string|max:100',
                'no_hp_baru'           => 'nullable|string|max:20',
            ]);

            // Simpan vendor baru ke tabel 'vendor'
            $vendorBaru = Vendor::create([
                'nama_vendor'     => $request->nama_vendor_baru,
                'kategori_vendor' => $request->kategori_vendor_baru,
                'no_hp'           => $request->no_hp_baru ?? '-',
            ]);

            $idVendor = $vendorBaru->id_vendor;
        }

        // 2. Simpan ke transaksi pembayaran_vendor
        PembayaranVendor::create([
            'id_pemesanan'        => $request->id_pemesanan,
            'id_vendor'           => $idVendor,
            'nominal_dp'          => $request->nominal_dp,
            'nominal_pelunasan'   => $request->nominal_pelunasan,
            'tgl_bayar'           => $request->tgl_bayar,
            'status_bayar_vendor' => $request->status_bayar_vendor,
        ]);

        return back()->with('success', 'Vendor berhasil ditambahkan ke acara!');
    }

    public function update(Request $request, $id)
    {
        $payVendor = PembayaranVendor::findOrFail($id);
        
        // Update data pembayaran
        $payVendor->update([
            'nominal_dp'          => $request->nominal_dp,
            'nominal_pelunasan'   => $request->nominal_pelunasan,
            'tgl_bayar'           => $request->tgl_bayar,
            'status_bayar_vendor' => $request->status_bayar_vendor,
        ]);

        // Update detail vendornya jika ada perubahan nama/kategori
        if ($payVendor->vendor) {
            $payVendor->vendor->update([
                'nama_vendor'     => $request->nama_vendor,
                'kategori_vendor' => $request->kategori_vendor,
            ]);
        }

        return back()->with('success', 'Data vendor berhasil diperbarui!');
    }

    public function destroy($id)
    {
        PembayaranVendor::destroy($id);
        return back()->with('success', 'Vendor berhasil dihapus dari acara!');
    }
}