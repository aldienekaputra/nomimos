<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PemesananAcara;
use App\Models\RundownAcara;
use App\Models\Moodboard;
use App\Models\CatatanAcara;

class ClientController extends Controller
{
    public function index()
    {
        // Ambil SEMUA event berstatus ACC beserta relasi klien, rundowns, moodboards, dan catatan
        $events = PemesananAcara::with(['klien', 'rundowns', 'moodboards', 'catatan'])
            ->where('status_acc', 'ACC')
            ->orderBy('tgl_acara', 'ASC')
            ->get();

        return view('admin.klien', compact('events'));
    }

    // --- CRUD RUNDOWN ---
    public function storeRundown(Request $request)
    {
        $request->validate([
            'id_pemesanan'     => 'required',
            'waktu_mulai'      => 'required',
            'waktu_selesai'    => 'required',
            'nama_kegiatan'    => 'required',
            'penanggung_jawab' => 'required',
        ]);

        RundownAcara::create($request->all());

        return back()->with('success', 'Rundown berhasil ditambahkan!');
    }

    public function updateRundown(Request $request, $id)
    {
        $rundown = RundownAcara::findOrFail($id);
        $rundown->update($request->all());

        return back()->with('success', 'Rundown berhasil diperbarui!');
    }

    public function destroyRundown($id)
    {
        RundownAcara::destroy($id);
        return back()->with('success', 'Rundown berhasil dihapus!');
    }

    // --- CRUD MOODBOARD (BASE64 STORAGE) ---
    public function storeMoodboard(Request $request)
    {
        $request->validate([
            'id_pemesanan' => 'required',
            'gambar'       => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:5048',
            'keterangan'   => 'required',
        ]);

        $file = $request->file('gambar');
        // Convert file gambar ke data URL Base64 untuk disimpan di Supabase
        $base64 = 'data:' . $file->getMimeType() . ';base64,' . base64_encode(file_get_contents($file->getRealPath()));

        Moodboard::create([
            'id_pemesanan' => $request->id_pemesanan,
            'url_gambar'   => $base64,
            'keterangan'   => $request->keterangan,
        ]);

        return back()->with('success', 'Gambar moodboard berhasil diupload!');
    }

    public function updateMoodboard(Request $request, $id)
    {
        $request->validate([
            'gambar'     => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5048',
            'keterangan' => 'required',
        ]);

        $moodboard = Moodboard::findOrFail($id);
        $data = ['keterangan' => $request->keterangan];

        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $data['url_gambar'] = 'data:' . $file->getMimeType() . ';base64,' . base64_encode(file_get_contents($file->getRealPath()));
        }

        $moodboard->update($data);

        return back()->with('success', 'Moodboard berhasil diperbarui!');
    }

    public function destroyMoodboard($id)
    {
        $moodboard = Moodboard::findOrFail($id);
        $moodboard->delete();

        return back()->with('success', 'Moodboard berhasil dihapus!');
    }

    // --- CRUD CATATAN ACARA ---
    public function updateCatatan(Request $request, $id_pemesanan)
    {
        CatatanAcara::updateOrCreate(
            ['id_pemesanan' => $id_pemesanan],
            [
                'list_vip'          => $request->list_VIP,
                'req_lagu'          => $request->req_lagu,
                'list_foto_vvip'    => $request->list_foto_VVIP,
                'catatan_kebutuhan' => $request->catatan_kebutuhan,
                'petugas_keluarga'  => $request->petugas_keluarga,
            ]
        );

        return back()->with('success', 'Catatan acara berhasil disimpan!');
    }
}