<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Relations\PackagesRelation;

class Packages extends Model
{
    use HasFactory, PackagesRelation;

    protected $fillable = [
        'nama',
        'description',
        'price',
        'service_type',
        'image_path',
        'user-id',
    ];
}
