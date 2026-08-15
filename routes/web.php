<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\JorongController;
use App\Http\Controllers\KartuKeluargaController;
use App\Http\Controllers\WargaController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\WaliNagariController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index']);
Route::get('/berita', [HomeController::class, 'newsPage'])->name('news.page');
Route::get('/berita/{index}', [HomeController::class, 'newsDetail'])->name('news.detail');
Route::post('/contact', [HomeController::class, 'submitContact'])->name('contact.submit');

// Authentication Routes
Route::get('/login', [UserController::class, 'loginForm'])->name('login');
Route::post('/login', [UserController::class, 'login'])->name('login.post');
Route::post('/logout', [UserController::class, 'logout'])->name('logout');

// Data Warga Routes (Protected)
Route::middleware('auth')->group(function () {
    Route::prefix('data-warga')->name('warga.')->group(function () {
        Route::get('/', [WargaController::class, 'index'])->name('index');
        Route::get('/create', [WargaController::class, 'create'])->name('create');
        Route::post('/', [WargaController::class, 'store'])->name('store');
        Route::get('/{warga}', [WargaController::class, 'show'])->name('show');
        Route::get('/{warga}/edit', [WargaController::class, 'edit'])->name('edit');
        Route::put('/{warga}', [WargaController::class, 'update'])->name('update');
        Route::delete('/{warga}', [WargaController::class, 'destroy'])->name('destroy');
        Route::post('/{warga}/transfer', [WargaController::class, 'transfer'])->name('transfer');
        Route::post('/{warga}/convert', [WargaController::class, 'convertToPermanent'])->name('convert');
    });

    // Kartu Keluarga Routes (Protected)
    Route::prefix('kartu-keluarga')->name('kartu-keluarga.')->group(function () {
        // Public APBN Transparency route moved outside auth group (removed here)
        Route::get('/', [KartuKeluargaController::class, 'index'])->name('index');
        Route::get('/create', [KartuKeluargaController::class, 'create'])->name('create');
        Route::get('/create-wizard', [KartuKeluargaController::class, 'createWizard'])->name('create-wizard');
        Route::post('/', [KartuKeluargaController::class, 'store'])->name('store');
        Route::post('/wizard', [KartuKeluargaController::class, 'storeWizard'])->name('store-wizard');
        Route::get('/{kartuKeluarga}', [KartuKeluargaController::class, 'show'])->name('show');
        Route::get('/{kartuKeluarga}/edit', [KartuKeluargaController::class, 'edit'])->name('edit');
        Route::put('/{kartuKeluarga}', [KartuKeluargaController::class, 'update'])->name('update');
        Route::delete('/{kartuKeluarga}', [KartuKeluargaController::class, 'destroy'])->name('destroy');
    });

    // Jorong Routes (Protected)
    Route::prefix('jorong')->name('jorong.')->group(function () {
        Route::get('/', [JorongController::class, 'index'])->name('index');
        Route::get('/create', [JorongController::class, 'create'])->name('create');
        Route::post('/', [JorongController::class, 'store'])->name('store');
        Route::get('/{jorong}', [JorongController::class, 'show'])->name('show');
        Route::get('/{jorong}/edit', [JorongController::class, 'edit'])->name('edit');
        Route::put('/{jorong}', [JorongController::class, 'update'])->name('update');
        Route::delete('/{jorong}', [JorongController::class, 'destroy'])->name('destroy');
    });

// Admin Panel & User Management Routes (Admin Only)
    Route::middleware('role:admin')->group(function () {
        Route::get('/admin', [HomeController::class, 'admin'])->name('admin.edit');
        Route::get('/admin/section/{section}', [HomeController::class, 'adminSection'])->name('admin.section.edit');
        Route::post('/admin/section/{section}', [HomeController::class, 'saveAdminSection'])->name('admin.section.save');

        // APBN Management (Admin Only)
        Route::get('/admin/apbn', [App\Http\Controllers\APBNController::class, 'edit'])->name('apbn.edit');
        Route::post('/admin/apbn', [App\Http\Controllers\APBNController::class, 'store'])->name('apbn.store');

        Route::prefix('users')->name('users.')->group(function () {
            Route::get('/', [UserController::class, 'index'])->name('index');
            Route::get('/create', [UserController::class, 'create'])->name('create');
            Route::post('/', [UserController::class, 'store'])->name('store');
            Route::get('/{user}', [UserController::class, 'show'])->name('show');
            Route::get('/{user}/edit', [UserController::class, 'edit'])->name('edit');
            Route::put('/{user}', [UserController::class, 'update'])->name('update');
            Route::delete('/{user}', [UserController::class, 'destroy'])->name('destroy');
        });
    });

        // Admin Data Nagari Routes
        Route::middleware(['auth', 'role:admin'])->group(function () {
            Route::get('/data-nagari', [App\Http\Controllers\DataNagariController::class, 'index'])
                ->name('data-nagari');
        });

        // News Management (News Editor Only)
        Route::middleware(['auth', 'role:news_editor'])->group(function () {
            Route::resource('news', App\Http\Controllers\NewsController::class);
        });

    // Activity Log Routes (Admin Only)
    Route::prefix('activity-logs')->name('activity-logs.')->group(function () {
        Route::get('/', [ActivityLogController::class, 'index'])->name('index');
        Route::get('/{activityLog}', [ActivityLogController::class, 'show'])->name('show');
        Route::delete('/{activityLog}', [ActivityLogController::class, 'destroy'])->name('destroy');
    });

    // Wali Nagari Executive Routes
    Route::middleware('role:wali_nagari')->prefix('wali-nagari')->name('wali-nagari.')->group(function () {
        Route::get('/', [WaliNagariController::class, 'dashboard'])->name('dashboard');
        Route::get('/messages', [WaliNagariController::class, 'messages'])->name('messages.index');
        Route::get('/messages/{message}', [WaliNagariController::class, 'showMessage'])->name('messages.show');
        Route::post('/messages/{message}/toggle-read', [WaliNagariController::class, 'toggleRead'])->name('messages.toggle-read');
        Route::post('/messages/{message}/reply', [WaliNagariController::class, 'replyMessage'])->name('messages.reply');
        Route::delete('/messages/{message}', [WaliNagariController::class, 'destroyMessage'])->name('messages.destroy');
    });

// Public APBN Transparency page
Route::get('/apbn', [App\Http\Controllers\APBNController::class, 'index'])->name('apbn.index');
});
