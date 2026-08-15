<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    protected $fillable = ['title', 'type', 'topic', 'author', 'editor', 'date', 'summary', 'body', 'image', 'caption'];
    protected $casts = ['date' => 'datetime'];

    public function getFormattedTayangAttribute(): string
    {
        $date = $this->date ?? $this->created_at;
        if (!$date) {
            return 'Jumat, 7 Agustus 2026 19:28 WIB';
        }
        $days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
        $months = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];

        $dayName = $days[$date->dayOfWeek];
        $dayNum = $date->day;
        $monthName = $months[$date->month];
        $year = $date->year;
        $time = $date->format('H:i');

        return "{$dayName}, {$dayNum} {$monthName} {$year} {$time} WIB";
    }

    public function getImageAttribute($value): string
    {
        if (empty($value)) {
            return 'https://images.unsplash.com/photo-1519337265831-281ec6cc8514?auto=format&fit=crop&w=800&q=80';
        }

        if (str_starts_with($value, 'http://') || str_starts_with($value, 'https://')) {
            return $value;
        }

        $path = ltrim($value, '/');

        if (str_starts_with($path, 'storage/')) {
            return asset($path);
        }

        if (file_exists(public_path($path))) {
            return asset($path);
        }

        return asset('storage/' . $path);
    }
}
