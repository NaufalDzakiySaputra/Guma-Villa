<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasFactory;

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