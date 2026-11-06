<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenugasanCrew extends Model
{
    use HasFactory;

    protected $table = 'penugasan_crew';
    protected $primaryKey = 'id_laporan';
    public $timestamps = false;

    protected $fillable = [
        'id_crew',
        'id_pemesanan',
        'jobdesk',
    ];

    public function crew()
    {
        return $this->belongsTo(Crew::class, 'id_crew', 'id_crew');
    }

    public function pemesanan()
    {
        return $this->belongsTo(PemesananAcara::class, 'id_pemesanan', 'id_pemesanan');
    }
}