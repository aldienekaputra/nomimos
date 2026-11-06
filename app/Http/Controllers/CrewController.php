<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PemesananAcara;
use App\Models\Crew;
use App\Models\PenugasanCrew;

class CrewController extends Controller
{
    public function index()
    {
        // 1. Ambil SEMUA event yang berstatus ACC beserta relasi Klien & Penugasan Crew
        $events = PemesananAcara::with(['klien', 'penugasanCrews.crew.user'])
            ->where('status_acc', 'ACC')
            ->orderBy('tgl_acara', 'ASC')
            ->get();

        // 2. Data master crew untuk modal penugasan
        $masterCrew = Crew::with('user')->get();

        return view('admin.crew', compact('events', 'masterCrew'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_pemesanan' => 'required',
            'id_crew'      => 'required',
            'jobdesk'      => 'required',
        ]);

        // Cek agar crew yang sama tidak ditugaskan ganda pada event yang sama
        $exists = PenugasanCrew::where('id_pemesanan', $request->id_pemesanan)
            ->where('id_crew', $request->id_crew)
            ->exists();

        if ($exists) {
            return back()->with('error', 'Crew ini sudah ditugaskan pada acara ini!');
        }

        PenugasanCrew::create([
            'id_pemesanan' => $request->id_pemesanan,
            'id_crew'      => $request->id_crew,
            'jobdesk'      => $request->jobdesk,
        ]);

        return back()->with('success', 'Crew berhasil ditugaskan ke acara!');
    }

    public function update(Request $request, $id)
    {
        $penugasan = PenugasanCrew::findOrFail($id);
        $penugasan->update([
            'id_crew' => $request->id_crew,
            'jobdesk' => $request->jobdesk,
        ]);

        return back()->with('success', 'Penugasan crew berhasil diperbarui!');
    }

    public function destroy($id)
    {
        PenugasanCrew::destroy($id);
        return back()->with('success', 'Penugasan crew berhasil dihapus!');
    }
}