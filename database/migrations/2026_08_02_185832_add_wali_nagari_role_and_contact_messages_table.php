<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('contact_messages')) {
            Schema::create('contact_messages', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('email');
                $table->string('phone')->nullable();
                $table->string('subject')->nullable();
                $table->text('message');
                $table->string('status')->default('unread'); // unread, read, replied
                $table->timestamp('read_at')->nullable();
                $table->text('reply_notes')->nullable();
                $table->timestamp('replied_at')->nullable();
                $table->timestamps();
            });
        }

        if (DB::getDriverName() === 'sqlite') {
            Schema::disableForeignKeyConstraints();

            $userSql = DB::table('sqlite_master')->where('type', 'table')->where('name', 'users')->value('sql');
            if ($userSql && (str_contains($userSql, 'CHECK') || str_contains($userSql, 'check'))) {
                DB::statement('CREATE TABLE users_new (id INTEGER PRIMARY KEY AUTOINCREMENT, name VARCHAR NOT NULL, email VARCHAR NOT NULL UNIQUE, email_verified_at DATETIME, password VARCHAR NOT NULL, remember_token VARCHAR, created_at DATETIME, updated_at DATETIME, role VARCHAR DEFAULT "wali_jorong", jorong_id INTEGER, phone VARCHAR, FOREIGN KEY (jorong_id) REFERENCES jorongs (id) ON DELETE SET NULL)');
                DB::statement('INSERT INTO users_new SELECT * FROM users');
                DB::statement('DROP TABLE users');
                DB::statement('ALTER TABLE users_new RENAME TO users');
            }

            Schema::enableForeignKeyConstraints();
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contact_messages');
    }
};


