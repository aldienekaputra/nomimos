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
        'tgl_sewa_wo',
        'dp_wo',
        'tgl_hitung_pelunasan',
        'sisa_pelunasan_wo',
        'tgl_jatuh_tempo',
    ];

    public function pemesanan()
    {
        return $this->belongsTo(PemesananAcara::class, 'id_pemesanan', 'id_pemesanan');
    }
}