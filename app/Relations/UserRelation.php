<?php

namespace App\Relations;

use App\Models\Reservation; // ← PERUBAHAN INI SAJA
use App\Models\Menus;
use App\Models\Gallery;
use App\Models\Packages;
use App\Models\News;

trait UserRelation
{
    public function Reservations()
    {
        return $this->hasMany(Reservation::class); // ← Reservation bukan Reservations
    }
    
    public function Menus()
    {
        return $this->hasMany(Menus::class);
    }
    
    public function Gallery()
    {
        return $this->hasMany(Gallery::class, 'upload_by');
    }
    
    public function Packages()
    {
        return $this->hasMany(Packages::class, 'user_id');
    }
    
    public function News()
    {
        return $this->hasMany(News::class);
    }
}