<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Relations\MenusRelation;

class Menus extends Model
{
    use HasFactory, MenusRelation;

    protected $table = 'menus';

    protected $fillable = [
        'name',
        'description',
        'price',
        'discount',
        'image_path',
        'user_id', // Pastikan user_id juga bisa diisi
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'discount' => 'decimal:2',
    ];

    //Rumus Hitung Harga Setelah Diskon
    public function getHargaDiskonAttribute()
    {
        // Harga dikurangi (Harga x Diskon / 100)
        return $this->price - ($this->price * ($this->discount / 100));
    }

    // Rumus Format Rupiah untuk Harga Asli
    public function getFormatHargaAttribute()
    {
        return 'Rp ' . number_format($this->price, 0, ',', '.');
    }

    // Rumus Format Rupiah untuk Harga Setelah Diskon
    public function getFormatDiskonAttribute()
    {
        return 'Rp ' . number_format($this->harga_diskon, 0, ',', '.');
    }
}