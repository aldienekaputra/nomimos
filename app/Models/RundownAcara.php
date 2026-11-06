<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RundownAcara extends Model
{
    use HasFactory;

    protected $table = 'rundown_acara';
    protected $primaryKey = 'id_rundown';
    public $timestamps = false;

    protected $fillable = [
        'id_pemesanan',
        'waktu_mulai',
        'waktu_selesai',
        'nama_kegiatan',
        'penanggung_jawab',
        'keterangan',
    ];
}