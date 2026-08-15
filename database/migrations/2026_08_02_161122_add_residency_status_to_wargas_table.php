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
        Schema::table('wargas', function (Blueprint $table) {
            // Make kartu_keluarga_id nullable to support temporary residents
            $table->dropForeign(['kartu_keluarga_id']);
            $table->foreignId('kartu_keluarga_id')->nullable()->change();
            $table->foreign('kartu_keluarga_id')->references('id')->on('kartu_keluargas')->onDelete('cascade');
            
            // Add residency status field
            $table->boolean('is_tetap')->default(true)->after('kartu_keluarga_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('wargas', function (Blueprint $table) {
            // Remove residency status field
            $table->dropColumn('is_tetap');
            
            // Make kartu_keluarga_id required again
            $table->dropForeign(['kartu_keluarga_id']);
            $table->foreignId('kartu_keluarga_id')->nullable(false)->change();
            $table->foreign('kartu_keluarga_id')->references('id')->on('kartu_keluargas')->onDelete('cascade');
        });
    }
};
