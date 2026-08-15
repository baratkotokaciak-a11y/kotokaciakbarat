<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'admin@nagari.go.id'],
            [
                'name' => 'Admin Nagari',
                'password' => bcrypt('admin123'),
                'role' => 'admin',
                'phone' => '081234567890',
            ]
        );

        User::firstOrCreate(
            ['email' => 'walinagari@nagari.go.id'],
            [
                'name' => 'Reza Fahlevi, S.H., M.H.',
                'password' => bcrypt('walinagari123'),
                'role' => 'wali_nagari',
                'phone' => '081299887766',
            ]
        );

        if (\App\Models\ContactMessage::count() === 0) {
            \App\Models\ContactMessage::create([
                'name' => 'Budi Santoso',
                'email' => 'budisantoso@gmail.com',
                'phone' => '081345678901',
                'subject' => 'Permohonan Perbaikan Jalan Jorong Lungguk Batu',
                'message' => 'Assalamu`alaikum Bapak Wali Nagari, kami warga Jorong Lungguk Batu memohon perhatian terkait kondisi jalan kabupaten yang mengalami kerusakan akibat hujan deras.',
                'status' => 'unread',
            ]);

            \App\Models\ContactMessage::create([
                'name' => 'Siti Rahmah',
                'email' => 'sitirahmah@yahoo.com',
                'phone' => '082198765432',
                'subject' => 'Pertanyaan Syarat Pembuatan Surat Keterangan Usaha (SKU)',
                'message' => 'Selamat pagi Kantor Nagari, mohon informasi persyaratan administrasi yang perlu dibawa untuk pembuatan Surat Keterangan Usaha UMKM. Terima kasih.',
                'status' => 'unread',
            ]);

            \App\Models\ContactMessage::create([
                'name' => 'Rahmat Hidayat',
                'email' => 'rahmat.h@gmail.com',
                'phone' => '085211223344',
                'subject' => 'Apresiasi Program Pelatihan UMKM Nagari',
                'message' => 'Terima kasih Bapak Wali Nagari dan jajaran atas terselenggaranya pelatihan pemasaran digital UMKM minggu lalu. Sangat bermanfaat bagi usaha kami.',
                'status' => 'read',
                'read_at' => now()->subHours(5),
            ]);
        }
    }
}
