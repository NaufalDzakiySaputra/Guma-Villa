<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Relations\PackagesRelation;

class Packages extends Model
{
    use HasFactory, PackagesRelation;

    protected $fillable = [
        'user_id',
        'nama',
        'description',
        'price',
        'max_people',
        'service_type',
        'image_path',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'max_people' => 'integer',
    ];
}