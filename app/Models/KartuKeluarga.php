<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class KartuKeluarga extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'jorong_id',
        'nomor_kk',
        'kepala_keluarga',
        'alamat',
        'rt',
        'rw',
        'kode_pos',
        'telepon',
        'tanggal_pembuatan',
        'tanggal_berlaku',
        'jumlah_anggota',
        'kelompok_sosial',
        'catatan',
        'is_active',
    ];

    protected $casts = [
        'tanggal_pembuatan' => 'date',
        'tanggal_berlaku' => 'date',
        'is_active' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function($kk) {
            if ($kk->wargas()->count() > 0) {
                return false; // Prevent deletion
            }
        });
    }

    public function jorong()
    {
        return $this->belongsTo(Jorong::class);
    }

    public function wargas()
    {
        return $this->hasMany(Warga::class);
    }

    public function kepalaKeluarga()
    {
        return $this->hasOne(Warga::class)->where('hubungan_keluarga', 'Kepala Keluarga');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function updateJumlahAnggota()
    {
        $this->jumlah_anggota = $this->wargas()->count();
        $this->save();
    }

    public function getAlamatLengkapAttribute()
    {
        $alamat = $this->alamat;
        if ($this->rt) $alamat .= " RT {$this->rt}";
        if ($this->rw) $alamat .= " RW {$this->rw}";
        if ($this->kode_pos) $alamat .= " {$this->kode_pos}";
        return $alamat;
    }

    public function hasFamilyMembers()
    {
        return $this->wargas()->count() > 0;
    }

    public function hasKepalaKeluarga()
    {
        return $this->kepalaKeluarga()->exists();
    }

    public function canBeDeleted()
    {
        return !$this->hasFamilyMembers();
    }

    public function getNamaKepalaKeluargaAttribute()
    {
        return $this->attributes['kepala_keluarga']
            ?? $this->kepalaKeluarga?->nama_lengkap
            ?? '-';
    }
}
