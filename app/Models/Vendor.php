<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    use HasFactory;

    protected $table = 'vendor';
    protected $primaryKey = 'id_vendor';
    public $timestamps = false;

    protected $fillable = [
        'nama_vendor',
        'kategori_vendor',
        'no_hp',
    ];
}