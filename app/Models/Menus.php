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
        'user_id',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'discount' => 'decimal:2',
    ];

    // ===========================================
    // ACCESSOR UNTUK DISKON DAN HARGA
    // ===========================================

    /**
     * Tambahkan properti virtual yang akan otomatis tersedia
     */
    protected $appends = [
        'harga_diskon', 
        'format_harga', 
        'format_diskon', 
        'display_price',
        'discount_badge',
        'savings_amount',
        'has_discount'
    ];

    /**
     * Hitung harga setelah diskon
     */
    public function getHargaDiskonAttribute()
    {
        if ($this->discount > 0) {
            return $this->price - ($this->price * ($this->discount / 100));
        }
        return $this->price;
    }

    /**
     * Format Rupiah untuk harga asli
     */
    public function getFormatHargaAttribute()
    {
        return 'Rp ' . number_format($this->price, 0, ',', '.');
    }

    /**
     * Format Rupiah untuk harga setelah diskon
     */
    public function getFormatDiskonAttribute()
    {
        if ($this->discount > 0) {
            return 'Rp ' . number_format($this->harga_diskon, 0, ',', '.');
        }
        return $this->format_harga;
    }

    /**
     * Data lengkap untuk display harga
     */
    public function getDisplayPriceAttribute()
    {
        return [
            'original' => $this->price,
            'discounted' => $this->discount > 0 ? $this->harga_diskon : null,
            'discount_percent' => $this->discount,
            'has_discount' => $this->discount > 0,
            'formatted_original' => $this->format_harga,
            'formatted_discounted' => $this->discount > 0 ? $this->format_diskon : null,
        ];
    }

    /**
     * Badge diskon (contoh: "-20%")
     */
    public function getDiscountBadgeAttribute()
    {
        if ($this->discount > 0) {
            return '-' . number_format($this->discount, 0) . '%';
        }
        return null;
    }

    /**
     * Jumlah uang yang dihemat (dalam Rupiah)
     */
    public function getSavingsAmountAttribute()
    {
        if ($this->discount > 0) {
            return $this->price - $this->harga_diskon;
        }
        return 0;
    }

    /**
     * Cek apakah ada diskon (boolean)
     */
    public function getHasDiscountAttribute()
    {
        return $this->discount > 0;
    }

    /**
     * Format jumlah hemat
     */
    public function getFormattedSavingsAttribute()
    {
        if ($this->has_discount) {
            return 'Rp ' . number_format($this->savings_amount, 0, ',', '.');
        }
        return null;
    }

    /**
     * Scope untuk menu dengan diskon
     */
    public function scopeWithDiscount($query)
    {
        return $query->where('discount', '>', 0);
    }

    /**
     * Scope untuk menu tanpa diskon
     */
    public function scopeWithoutDiscount($query)
    {
        return $query->where('discount', '=', 0)->orWhereNull('discount');
    }

    /**
     * Scope untuk menu dengan gambar
     */
    public function scopeWithImage($query)
    {
        return $query->whereNotNull('image_path');
    }

    /**
     * Scope untuk menu tanpa gambar
     */
    public function scopeWithoutImage($query)
    {
        return $query->whereNull('image_path');
    }
}