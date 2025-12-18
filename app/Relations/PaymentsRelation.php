<?php
use App\Models\Reservations;
trait PaymentsRelation
{
public function Reservations()
 { 
    return $this->belongsTo(Reservation::class);
 }
}

?>