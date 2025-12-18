<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    use HasFactory;

    protected $table = 'gallery';

    protected $fillable = [
        'title',
        'image_path',
        'uploaded_by',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }
}