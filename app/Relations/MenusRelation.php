<?php

namespace App\Relations;

use App\Models\User;

trait MenusRelation
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}