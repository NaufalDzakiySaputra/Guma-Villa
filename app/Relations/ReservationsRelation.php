<?php

namespace App\Relations;
use App\Models\User;
use App\Models\Payments;
use App\Models\Packages;
trait ReservationsRelation
{
public function user()
{
    return $this->belongsTo(User::class);
}
public function payments()
{
    return this->hasMany(Payments::class);
}
public function packages()
{
    return $this->belongsTo(packages::class);
}
}

?>