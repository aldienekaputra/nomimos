<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CatatanAcara extends Model
{
    use HasFactory;

    protected $table = 'catatan_acara';
    protected $primaryKey = 'id_note';
    public $timestamps = false;

    protected $fillable = [
        'id_pemesanan',
        'list_vip',
        'req_lagu',
        'list_foto_vvip',
        'catatan_kebutuhan',
        'petugas_keluarga',
    ];
}