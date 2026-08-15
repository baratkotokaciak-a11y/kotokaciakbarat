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
        Schema::create('kartu_keluargas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('jorong_id')->constrained('jorongs')->onDelete('cascade');
            $table->string('nomor_kk', 16)->unique();
            $table->string('kepala_keluarga');
            $table->string('alamat');
            $table->string('rt', 3)->nullable();
            $table->string('rw', 3)->nullable();
            $table->string('kode_pos', 5)->nullable();
            $table->string('telepon')->nullable();
            $table->date('tanggal_pembuatan')->nullable();
            $table->date('tanggal_berlaku')->nullable();
            $table->integer('jumlah_anggota')->default(0);
            $table->enum('kelompok_sosial', ['Miskin', 'Rentan Miskin', 'Menengah', 'Mampu'])->nullable();
            $table->text('catatan')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
            
            // Indexes
            $table->index('nomor_kk');
            $table->index('jorong_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kartu_keluargas');
    }
};
