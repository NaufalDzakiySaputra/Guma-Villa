<?php

namespace App\Relations;

use App\Models\Reservations;
use App\Models\User;

trait PackagesRelation
{
    public function reservations()
    {
        return $this->hasMany(Reservations::class, 'package_id');
    }

    public function users()
    {
        return $this->hasManyThrough(
            User::class,
            Reservations::class,
            'package_id', // FK di reservations
            'id',         // PK di users
            'id',         // PK di packages
            'user_id'     // FK di reservations
        );
    }
}
