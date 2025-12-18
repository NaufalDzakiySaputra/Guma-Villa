<?php
use App\Models\Reservations;
use App\Models\Menus;
use App\Models\gallery;
use App\Models\Packages;
USE App\Models\News;
trait UserRelation
{
public function Reservations()
{
    return $this->hasMany(Reservation::class);
}
public function Menus()
{
    return $this->hasMany(Menus::class);
}
Public function Gallery()
{
    return $this->hasMany(Gallery::class, 'upload_by');
}
public function Packages()
{
    return $this->hasManyThrough(Packages::class, 'user_id', 'id', 'id', 'package_id');
}
public function News()
{
    return $this->hasMany(\App\Models\News::class);
}

}

?>