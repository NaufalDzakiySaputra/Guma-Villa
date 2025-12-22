<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Relations\NewsRelation;

class News extends Model
{
    use HasFactory; 
    use NewsRelation;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'event_date',
        'image_path',
    ];

    protected $dates = ['event_date'];
}