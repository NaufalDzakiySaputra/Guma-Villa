<?php

namespace App\Relations;
use App\Models\User;
trait MenusRelation
{
public function User()
{
    return $this->belongsTo(User::class);
}

}

?>