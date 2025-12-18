<?php
use App\Models\Reservations;
use App\Models\User;
trait PackagesRelations
{
public function Reservations()
{
    return $this->hasMany(Reservations::class);
}
public function user()
{
    return $this->hasManyThrough(User::class, Reservations::class, 'package_id', 'id', 'id', 'user_id');
}


}

?>