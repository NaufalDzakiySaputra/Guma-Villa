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
        'service_type',
        'package_id',
        'date',
        'status',
        'notes',
        'payment_status'
    ];

    
}
