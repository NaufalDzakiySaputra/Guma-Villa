<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // HAPUS INI atau PERBAIKI:
    // protected $casts = [
    //     'password' => 'hashed', // <== INI SALAH, HAPUS!
    // ];
    
    // Jika ada casts lain, biarkan hanya ini:
    protected $casts = [
        'email_verified_at' => 'datetime',
        // JANGAN masukkan password di sini!
    ];
}