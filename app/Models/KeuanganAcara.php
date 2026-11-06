<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KeuanganAcara extends Model
{
    use HasFactory;

    protected $table = 'keuangan_acara';
    protected $primaryKey = 'id_keuangan';
    public $timestamps = false;

    protected $fillable = [
        'id_pemesanan',
        'status_pembayaran',
        'tgl_sewa_WO',
        'dp_WO',
        'tgl_hitung_pelunasan',
        'sisa_pelunasan_WO',
        'tgl_Jatuh_tempo',
    ];

    public function pemesanan()
    {
        return $this->belongsTo(PemesananAcara::class, 'id_pemesanan', 'id_pemesanan');
    }
}