<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('wargas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kartu_keluarga_id')->constrained('kartu_keluargas')->onDelete('cascade');
            $table->string('nik', 16)->unique();
            
            // Data Diri
            $table->string('nama_lengkap');
            $table->string('nama_panggilan')->nullable();
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan']);
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->enum('agama', ['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Konghucu', 'Lainnya']);
            
            // Status dan Keluarga
            $table->enum('status_perkawinan', ['Belum Menikah', 'Menikah', 'Cerai Hidup', 'Cerai Mati']);
            $table->enum('hubungan_keluarga', ['Kepala Keluarga', 'Istri', 'Anak', 'Orang Tua', 'Cucu', 'Famili Lain', 'Lainnya']);
            $table->string('nama_ayah_kandung')->nullable();
            $table->string('nama_ibu_kandung')->nullable();
            
            // Alamat dan Domisili
            $table->text('alamat_lengkap');
            $table->string('kelurahan')->nullable();
            $table->string('kecamatan')->nullable();
            $table->string('kabupaten')->nullable();
            $table->string('provinsi')->nullable();
            $table->boolean('sesuai_kk')->default(true);
            
            // Pekerjaan
            $table->enum('pekerjaan', [
                'Belum/Tidak Bekerja', 
                'Pegawai Negeri Sipil', 
                'TNI', 
                'Polri', 
                'Karyawan Swasta', 
                'Wiraswasta', 
                'Pedagang', 
                'Petani', 
                'Tukang', 
                'Buruh Tani', 
                'Pensiunan', 
                'Nelayan', 
                'Peternak', 
                'Jasa', 
                'Pengrajin', 
                'Pekerja Seni', 
                'Lainnya'
            ]);
            $table->string('pekerjaan_lain')->nullable();
            
            // Pendidikan
            $table->enum('tingkat_pendidikan', [
                'Tidak/Belum Sekolah',
                'Tidak Lulus SD',
                'SD/Sederajat',
                'SMP/Sederajat',
                'SMA/Sederajat',
                'D1',
                'D2',
                'D3',
                'S1/D4',
                'S2',
                'S3',
                'Pondok Pesantren',
                'Pendidikan Keagamaan',
                'Sekolah Luar Biasa',
                'Kursus Keterampilan',
                'Lainnya'
            ]);
            $table->string('pendidikan_lain')->nullable();
            
            // Data Tambahan
            $table->string('golongan_darah')->nullable();
            $table->string('no_paspor')->nullable();
            $table->string('no_kitap')->nullable();
            $table->string('ayah_nik')->nullable();
            $table->string('ibu_nik')->nullable();
            $table->boolean('is_wafat')->default(false);
            $table->date('tanggal_wafat')->nullable();
            
            $table->text('catatan')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
            
            // Indexes
            $table->index('nik');
            $table->index('kartu_keluarga_id');
            $table->index('nama_lengkap');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wargas');
    }
};
