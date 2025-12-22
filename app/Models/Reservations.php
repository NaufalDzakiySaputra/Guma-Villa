<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Relations\ReservationsRelation;
class Reservations extends Model
{
    use HasFactory;
    use ReservationsRelation;
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
