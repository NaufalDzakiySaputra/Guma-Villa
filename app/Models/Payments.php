<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Relations\PaymentsRelation;
class Payment extends Model
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
        'paid_at',
    ];

    protected $casts = [
        'paid_at' => 'datetime',
        'amount' => 'decimal:2',
    ];

  
}