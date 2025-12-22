<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Relations\MenusRelation; // Import the MenusRelation trait

class Menus extends Model
{
    use HasFactory, MenusRelation; // 

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