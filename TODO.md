# Todo: Portal Berita Redesign - Mirip Beranda Utama

## Steps:
- [x] Approved plan
- [ ] **Step 1**: Rewrite `resources/views/news_page.blade.php` - Full restyle matching `home_dynamic.blade.php` design
- [ ] **Step 2**: Rewrite `resources/views/news_detail.blade.php` - Full restyle matching `home_dynamic.blade.php` design
- [ ] **Step 3**: Test the pages load correctly

# Todo: Transparansi APBN di Halaman Utama Publik

## Steps:
- [x] Buat data transparansi APBN di `public/data/apbn.json`
- [x] Muat data APBN di `HomeController::loadProfileData()`
- [x] Tambahkan section `#apbn` di `home_dynamic.blade.php` (ringkasan, sumber dana, rincian per bidang, daftar program, alokasi per jorong)
- [x] Tambahkan link "APBN" di navigasi (nav_items) dan footer
- [x] Tambahkan section banner hero di bagian paling atas halaman utama (`#banner`)
- [x] Validasi JSON profile_data dan apbn.json
- [x] Validasi kompilasi Blade (php artisan view:cache)

# Todo: Halaman Input APBN (Admin)

## Steps:
- [x] Tambah method `edit()` dan `store()` di `APBNController`
- [x] Buat view `resources/views/apbn/edit.blade.php` dengan form dinamis (sumber dana, bidang, program, jorong)
- [x] Tambah route admin `GET/POST /admin/apbn` (hanya akses `role:admin`)
- [x] Tambahkan kartu "Transparansi APBN" di dashboard admin
- [x] Validasi PHP syntax, route, dan kompilasi Blade
