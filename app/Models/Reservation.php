<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Relations\ReservationRelation;

class Reservation extends Model
{
    use HasFactory;
    use ReservationRelation;
    
    protected $fillable = [
        'user_id',
        'nama_lengkap',
        'nik',
        'no_telepon',
        'service_type',
        'package_id',
        'date',
        'checkin_date',
        'checkout_date',
        'jumlah_orang',
        'total_amount',
        'status',
        'notes',
        'payment_status',
        'payment_method'
    ];

    protected $casts = [
        'date' => 'date',
        'checkin_date' => 'date',
        'checkout_date' => 'date',
        'total_amount' => 'decimal:2',
    ];
}