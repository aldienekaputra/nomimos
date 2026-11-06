<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Crew extends Model
{
    use HasFactory;

    protected $table = 'crew';
    protected $primaryKey = 'id_crew';
    public $timestamps = false;

    protected $fillable = [
        'id_user',
        'nama_crew',
        'no_hp',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }
}