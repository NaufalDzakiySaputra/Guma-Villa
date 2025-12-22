<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Relations\GalleryRelation;

class Gallery extends Model
{
    use HasFactory, GalleryRelation;

    protected $table = 'gallery';

    protected $fillable = [
        'title',
        'image_path',
        'uploaded_by',
    ];
}
