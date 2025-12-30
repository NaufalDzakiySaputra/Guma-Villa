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

    // 🔥 TAMBAHKAN CONSTANTS
    public const STATUS_PENDING = 'pending';
    public const STATUS_PAID = 'paid';      // Dulu 'success'
    public const STATUS_FAILED = 'failed';
    public const STATUS_VERIFIED = 'verified';
    public const STATUS_EXPIRED = 'expired';
    
    // 🔥 TAMBAHKAN HELPER METHOD
    public static function getStatuses()
    {
        return [
            self::STATUS_PENDING,
            self::STATUS_PAID,
            self::STATUS_FAILED,
            self::STATUS_VERIFIED,
            self::STATUS_EXPIRED,
        ];
    }

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
    
    // 🔥 TAMBAHKAN BOOT METHOD untuk auto sync
    protected static function booted()
    {
        parent::booted();
        
        static::updated(function ($payment) {
            if ($payment->isDirty('status') && $payment->reservation) {
                // Langsung update reservation dengan status yang sama
                $payment->reservation->update([
                    'payment_status' => $payment->status
                ]);
            }
        });
    }
}