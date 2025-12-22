<?php

namespace App\Relations;
use App\Models\Reservations;
trait PaymentsRelation
{
public function Reservations()
 { 
    return $this->belongsTo(Reservation::class);
 }
}

?>