<?php

namespace App\Relations;

use App\Models\Reservation;
use App\Models\User;

trait PaymentsRelation
{
    public function reservation()
    {
        return $this->belongsTo(Reservation::class, 'reservation_id');
    }
    
    public function verifier()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }
}