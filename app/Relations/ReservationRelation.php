<?php

namespace App\Relations;

use App\Models\User;
use App\Models\Payments;
use App\Models\Packages;

trait ReservationRelation
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function payments()
    {
        return $this->hasMany(Payments::class, 'reservation_id');
    }
    
    public function packages()
    {
        return $this->belongsTo(Packages::class, 'package_id');
    }
}