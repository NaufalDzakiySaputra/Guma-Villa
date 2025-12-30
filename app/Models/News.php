<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Relations\NewsRelation;
use Carbon\Carbon;
use Illuminate\Support\Str;


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

    // ===========================================
    // ACCESSOR & HELPER METHODS
    // ===========================================

    /**
     * Format tanggal event (contoh: 15 Juni 2024)
     */
    public function getFormattedEventDateAttribute()
    {
        if (!$this->event_date) return null;
        
        $months = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];
        
        $day = $this->event_date->format('d');
        $month = $months[(int)$this->event_date->format('n')];
        $year = $this->event_date->format('Y');
        
        return "$day $month $year";
    }

    /**
     * Format tanggal singkat (contoh: 15 Jun 2024)
     */
    public function getShortEventDateAttribute()
    {
        if (!$this->event_date) return null;
        
        $months = [
            1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr',
            5 => 'Mei', 6 => 'Jun', 7 => 'Jul', 8 => 'Agu',
            9 => 'Sep', 10 => 'Okt', 11 => 'Nov', 12 => 'Des'
        ];
        
        $day = $this->event_date->format('d');
        $month = $months[(int)$this->event_date->format('n')];
        $year = $this->event_date->format('Y');
        
        return "$day $month $year";
    }

    /**
     * Cek apakah event sudah lewat
     */
    public function getIsPastEventAttribute()
    {
        return $this->event_date->isPast();
    }

    /**
     * Cek apakah event akan datang
     */
    public function getIsUpcomingEventAttribute()
    {
        return $this->event_date->isFuture();
    }

    /**
     * Hitung hari menuju event
     */
    public function getDaysUntilEventAttribute()
    {
        return Carbon::now()->diffInDays($this->event_date, false);
    }

    /**
     * Status badge untuk event
     */
    public function getEventStatusAttribute()
    {
        $days = $this->days_until_event;
        
        if ($days < 0) {
            return ['text' => 'Event Selesai', 'class' => 'danger'];
        } elseif ($days == 0) {
            return ['text' => 'Hari Ini', 'class' => 'success'];
        } elseif ($days <= 7) {
            return ['text' => 'Minggu Ini', 'class' => 'warning'];
        } else {
            return ['text' => 'Akan Datang', 'class' => 'info'];
        }
    }

    /**
     * Ringkasan deskripsi (untuk table view)
     */
    public function getExcerptAttribute($length = 100)
    {
        return Str::limit(strip_tags($this->description), $length);
    }

    /**
     * Scope untuk event yang akan datang
     */
    public function scopeUpcoming($query)
    {
        return $query->where('event_date', '>=', now());
    }

    /**
     * Scope untuk event yang sudah lewat
     */
    public function scopePast($query)
    {
        return $query->where('event_date', '<', now());
    }

    /**
     * Scope untuk event bulan ini
     */
    public function scopeThisMonth($query)
    {
        return $query->whereMonth('event_date', now()->month)
                     ->whereYear('event_date', now()->year);
    }
}