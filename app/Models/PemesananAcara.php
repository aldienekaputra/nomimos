<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PemesananAcara extends Model
{
    use HasFactory;

    protected $table = 'pemesanan_acara';
    protected $primaryKey = 'id_pemesanan';
    public $timestamps = false;

    // Kolom yang diizinkan untuk dikirim dari form / diisi massal
    protected $fillable = [
        'id_klien',
        'id_paket',
        'tgl_acara',
        'lokasi_acara',
        'status_acc',
    ];

    public function klien()
    {
        return $this->belongsTo(Klien::class, 'id_klien', 'id_klien');
    }

    public function rundowns()
    {
        return $this->hasMany(RundownAcara::class, 'id_pemesanan', 'id_pemesanan');
    }

    // ALIAS RUNDOWN TUNGGAL (UNTUK MEMENUHI CALL INI: with(['rundown']))
    public function rundown()
    {
        return $this->hasMany(RundownAcara::class, 'id_pemesanan', 'id_pemesanan');
    }

    public function moodboards()
    {
        return $this->hasMany(Moodboard::class, 'id_pemesanan', 'id_pemesanan');
    }

    // ALIAS MOODBOARD TUNGGAL (UNTUK MEMENUHI CALL INI: with(['moodboard']))
    public function moodboard()
    {
        return $this->hasMany(Moodboard::class, 'id_pemesanan', 'id_pemesanan');
    }

    public function catatan()
    {
        return $this->hasOne(CatatanAcara::class, 'id_pemesanan', 'id_pemesanan');
    }

    public function pembayaranVendors()
    {
        return $this->hasMany(PembayaranVendor::class, 'id_pemesanan', 'id_pemesanan');
    }

    public function keuangan()
    {
        return $this->hasOne(KeuanganAcara::class, 'id_pemesanan', 'id_pemesanan');
    }

    public function paket()
    {
        return $this->belongsTo(PaketAcara::class, 'id_paket', 'id_paket');
    }

    public function penugasanCrews()
    {
        return $this->hasMany(PenugasanCrew::class, 'id_pemesanan', 'id_pemesanan');
    }
}