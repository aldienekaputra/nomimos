<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Moodboard extends Model
{
    use HasFactory;

    protected $table = 'moodboard';
    protected $primaryKey = 'id_moodboard';
    public $timestamps = false;

    protected $fillable = [
        'id_pemesanan',
        'url_gambar',
        'keterangan',
    ];
}