<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Relations\PaymentsRelation;

class Payments extends Model
{
    use HasFactory;
    use PaymentsRelation;
    
    protected $table = 'payments';

    protected $fillable = [
        'reservation_id',
        'amount',
        'method',
        'transaction_code',
        'status',
        'proof_image',
        'payment_notes',
        'paid_at',
        'verified_at',
        'verified_by',
    ];

    protected $casts = [
        'paid_at' => 'datetime',
        'verified_at' => 'datetime',
        'amount' => 'decimal:2',
    ];
}