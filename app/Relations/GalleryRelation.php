<?php

namespace App\Relations;
use App\Models\User;

trait GalleryRelation
{
    public function user()
{
    return $this->belongsTo(User::class, 'uploaded_by');
}

}

?>