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
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['admin', 'wali_jorong'])->default('wali_jorong')->after('email');
            $table->foreignId('jorong_id')->nullable()->after('role')->constrained('jorongs')->onDelete('set null');
            $table->string('phone')->nullable()->after('jorong_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['jorong_id']);
            $table->dropColumn(['role', 'jorong_id', 'phone']);
        });
    }
};
