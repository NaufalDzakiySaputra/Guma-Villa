<?php

namespace App\Relations;

use App\Models\User;

trait NewsRelation
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
