<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Warga extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'kartu_keluarga_id',
        'is_tetap',
        'nik',
        'nama_lengkap',
        'nama_panggilan',
        'jenis_kelamin',
        'tempat_lahir',
        'tanggal_lahir',
        'agama',
        'status_perkawinan',
        'hubungan_keluarga',
        'nama_ayah_kandung',
        'nama_ibu_kandung',
        'alamat_lengkap',
        'kelurahan',
        'kecamatan',
        'kabupaten',
        'provinsi',
        'sesuai_kk',
        'pekerjaan',
        'pekerjaan_lain',
        'tingkat_pendidikan',
        'pendidikan_lain',
        'golongan_darah',
        'no_paspor',
        'no_kitap',
        'ayah_nik',
        'ibu_nik',
        'is_wafat',
        'tanggal_wafat',
        'catatan',
        'is_active',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'tanggal_wafat' => 'date',
        'sesuai_kk' => 'boolean',
        'is_wafat' => 'boolean',
        'is_active' => 'boolean',
        'is_tetap' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();

        static::saving(function($warga) {
            // Permanent residents must have a KK
            if ($warga->is_tetap && is_null($warga->kartu_keluarga_id)) {
                return false;
            }
        });
    }

    public function kartuKeluarga()
    {
        return $this->belongsTo(KartuKeluarga::class);
    }

    public function jorong()
    {
        return $this->hasOneThrough(Jorong::class, KartuKeluarga::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeWafat($query)
    {
        return $query->where('is_wafat', true);
    }

    public function scopeHidup($query)
    {
        return $query->where('is_wafat', false);
    }

    public function scopeTetap($query)
    {
        return $query->where('is_tetap', true);
    }

    public function scopeTemporary($query)
    {
        return $query->where('is_tetap', false);
    }

    public function scopeWithoutKK($query)
    {
        return $query->whereNull('kartu_keluarga_id');
    }

    public function getUmurAttribute()
    {
        return Carbon::parse($this->tanggal_lahir)->age;
    }

    public function getPekerjaanFullAttribute()
    {
        return $this->pekerjaan === 'Lainnya' ? $this->pekerjaan_lain : $this->pekerjaan;
    }

    public function getPendidikanFullAttribute()
    {
        return $this->tingkat_pendidikan === 'Lainnya' ? $this->pendidikan_lain : $this->tingkat_pendidikan;
    }

    public function getStatusDisplayAttribute()
    {
        if ($this->is_wafat) {
            return 'Wafat';
        }
        return $this->status_perkawinan;
    }

    public static function getPekerjaanOptions()
    {
        return [
            'Belum/Tidak Bekerja' => 'Belum/Tidak Bekerja',
            'Pegawai Negeri Sipil' => 'Pegawai Negeri Sipil',
            'TNI' => 'TNI',
            'Polri' => 'Polri',
            'Karyawan Swasta' => 'Karyawan Swasta',
            'Wiraswasta' => 'Wiraswasta',
            'Pedagang' => 'Pedagang',
            'Petani' => 'Petani',
            'Tukang' => 'Tukang',
            'Buruh Tani' => 'Buruh Tani',
            'Pensiunan' => 'Pensiunan',
            'Nelayan' => 'Nelayan',
            'Peternak' => 'Peternak',
            'Jasa' => 'Jasa',
            'Pengrajin' => 'Pengrajin',
            'Pekerja Seni' => 'Pekerja Seni',
            'Lainnya' => 'Lainnya',
        ];
    }

    public static function getPendidikanOptions()
    {
        return [
            'Tidak/Belum Sekolah' => 'Tidak/Belum Sekolah',
            'Tidak Lulus SD' => 'Tidak Lulus SD',
            'SD/Sederajat' => 'SD/Sederajat',
            'SMP/Sederajat' => 'SMP/Sederajat',
            'SMA/Sederajat' => 'SMA/Sederajat',
            'D1' => 'D1',
            'D2' => 'D2',
            'D3' => 'D3',
            'S1/D4' => 'S1/D4',
            'S2' => 'S2',
            'S3' => 'S3',
            'Pondok Pesantren' => 'Pondok Pesantren',
            'Pendidikan Keagamaan' => 'Pendidikan Keagamaan',
            'Sekolah Luar Biasa' => 'Sekolah Luar Biasa',
            'Kursus Keterampilan' => 'Kursus Keterampilan',
            'Lainnya' => 'Lainnya',
        ];
    }

    public function canConvertToPermanent()
    {
        return !$this->is_tetap && is_null($this->kartu_keluarga_id);
    }

    public function convertToPermanent($kartuKeluargaId)
    {
        if (!$this->canConvertToPermanent()) {
            return false;
        }

        $this->kartu_keluarga_id = $kartuKeluargaId;
        $this->is_tetap = true;
        return $this->save();
    }

    public function transferToKK($newKartuKeluargaId)
    {
        if (!$this->kartu_keluarga_id) {
            return false; // Cannot transfer if not already in a KK
        }

        $oldKkId = $this->kartu_keluarga_id;
        $this->kartu_keluarga_id = $newKartuKeluargaId;
        
        if ($this->save()) {
            // Update counters for both KKs
            if ($oldKkId) {
                KartuKeluarga::find($oldKkId)->updateJumlahAnggota();
            }
            if ($newKartuKeluargaId) {
                KartuKeluarga::find($newKartuKeluargaId)->updateJumlahAnggota();
            }
            return true;
        }

        return false;
    }
}
