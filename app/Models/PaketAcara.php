<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaketAcara extends Model
{
    use HasFactory;

    protected $table = 'paket_acara';
    protected $primaryKey = 'id_paket';
    public $timestamps = false;

    protected $fillable = [
        'nama_paket',
        'keterangan_paket',
        'harga_paket',
    ];
}