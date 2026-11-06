<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Klien extends Model
{
    use HasFactory;

    protected $table = 'klien';
    protected $primaryKey = 'id_klien';
    public $timestamps = false;

    protected $fillable = [
        'id_user',
        'nama_pria',
        'nama_wanita',
        'no_hp',
        'alamat',
    ];
}