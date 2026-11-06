<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PembayaranVendor extends Model
{
    use HasFactory;

    protected $table = 'pembayaran_vendor';
    protected $primaryKey = 'id_pay_vendor';
    public $timestamps = false;

    protected $fillable = [
        'id_pemesanan',
        'id_vendor',
        'nominal_dp',
        'nominal_pelunasan',
        'tgl_bayar',
        'status_bayar_vendor',
    ];

    public function vendor()
    {
        return $this->belongsTo(Vendor::class, 'id_vendor', 'id_vendor');
    }

    public function pemesanan()
    {
        return $this->belongsTo(PemesananAcara::class, 'id_pemesanan', 'id_pemesanan');
    }
}