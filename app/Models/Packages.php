<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Relations\PackagesRelation;
class Packages extends Model
{
    use HasFactory;
    use PackageRelation;
    protected $table = 'packages';

    protected $fillable = [
        'nama',
        'description',
        'price',
        'service_type',
    ];

    protected $casts = [
        'price' => 'decimal:2',
    ];
}