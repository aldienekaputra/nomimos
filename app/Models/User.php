<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'users';
    protected $primaryKey = 'id_user';
    public $timestamps = false;

    protected $fillable = [
        'username',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
    ];

    // Mengunci kolom password agar dibaca presisi oleh Auth Laravel
    public function getAuthPassword()
    {
        return $this->password;
    }

    // RELASI KE TABEL KLIEN (1:1)
    public function klien()
    {
        return $this->hasOne(Klien::class, 'id_user', 'id_user');
    }

    // RELASI KE TABEL CREW (1:1)
    public function crew()
    {
        return $this->hasOne(Crew::class, 'id_user', 'id_user');
    }
}