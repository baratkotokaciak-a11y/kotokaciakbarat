<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Jorong extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'nama_jorong',
        'deskripsi',
        'nik_ketua_jorong',
        'nama_ketua_jorong',
        'jumlah_kk',
        'jumlah_warga',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function kartuKeluargas()
    {
        return $this->hasMany(KartuKeluarga::class);
    }

    public function wargas()
    {
        return $this->hasManyThrough(Warga::class, KartuKeluarga::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function updateCounters()
    {
        $this->jumlah_kk = $this->kartuKeluargas()->count();
        $this->jumlah_warga = $this->wargas()->count();
        $this->save();
    }
}
