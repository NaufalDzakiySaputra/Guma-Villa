<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $table = 'menus';

    protected $fillable = [
        'name',
        'description',
        'price',
        'discount',
        'image_path',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'discount' => 'decimal:2',
    ];
}