<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Tambah Kartu Keluarga (Wizard) — Nagari Koto Kaciak Barat</title>
    <link rel="preconnect" href="https://fonts.bunny.net" />
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <style>
            /*! tailwindcss v4.0.7 | MIT License | https://tailwindcss.com */@layer theme{:root,:host{--font-sans:'Instrument Sans',ui-sans-serif,system-ui,sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol","Noto Color Emoji";--font-serif:ui-serif,Georgia,Cambria,"Times New Roman",Times,serif;--font-mono:ui-monospace,SFMono-Regular,Menlo,Monaco,Consolas,"Liberation Mono","Courier New",monospace;}}
            @layer utilities{.bg-emerald-700{background-color:#047857;}.bg-emerald-600{background-color:#059669;}.bg-emerald-50{background-color:#ecfdf5;}.text-emerald-700{color:#047857;}.text-slate-700{color:#334155;}.text-slate-500{color:#64748b;}.shadow-glow{box-shadow:0 20px 50px rgba(4,120,87,.18);}.ring-emerald-500{box-shadow:0 0 0 3px rgba(16,185,129,.15);}}
        </style>
    @endif
    <style>
        .wizard-step {
            display: none;
        }
        .wizard-step.active {
            display: block;
        }
        .step-indicator {
            transition: all 0.3s ease;
        }
        .step-indicator.active {
            background-color: #047857;
            color: white;
        }
        .step-indicator.completed {
            background-color: #059669;
            color: white;
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-900 font-sans antialiased">
    <div class="min-h-screen bg-white">
        <!-- Header -->
        <header class="sticky top-0 z-30 border-b border-slate-200 bg-white/95 backdrop-blur-sm">
            <div class="mx-auto flex max-w-7xl items-center justify-between px-4 py-4 sm:px-6 lg:px-8">
                <a href="{{ url('/') }}" class="flex items-center gap-3 text-emerald-700 font-semibold text-lg">
                    <span class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-100 text-emerald-700 ring-1 ring-emerald-200">N</span>
                    Nagari Kaciak Barat
                </a>
                <nav class="flex items-center gap-6 text-sm">
                    <a href="{{ url('/') }}" class="text-slate-600 hover:text-emerald-700 transition">Beranda</a>
                    <a href="{{ route('warga.index') }}" class="text-slate-600 hover:text-emerald-700 transition">Data Warga</a>
                    <a href="{{ route('kartu-keluarga.index') }}" class="text-emerald-700 font-medium">Kartu Keluarga</a>
                    <a href="{{ route('jorong.index') }}" class="text-slate-600 hover:text-emerald-700 transition">Jorong</a>
                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('admin.edit') }}" class="text-slate-600 hover:text-emerald-700 transition">Admin Panel</a>
                    @endif
                </nav>
            </div>
        </header>

        <main>
            <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8 py-8">
                <div class="mb-8">
                    <div class="flex items-center gap-4 mb-4">
                        <a href="{{ route('kartu-keluarga.index') }}" class="text-slate-600 hover:text-emerald-700 transition">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                        </a>
                        <h1 class="text-2xl font-semibold tracking-tight text-slate-900">Tambah Kartu Keluarga</h1>
                    </div>
                    <p class="text-slate-600">Buat kartu keluarga baru beserta kepala keluarga dalam satu transaksi</p>
                </div>

                <!-- Step Indicators -->
                <div class="flex items-center justify-center mb-8">
                    <div class="flex items-center gap-4">
                        <div class="step-indicator active w-10 h-10 rounded-full flex items-center justify-center border-2 border-emerald-700 font-semibold" data-step="1">1</div>
                        <div class="w-16 h-1 bg-slate-200"></div>
                        <div class="step-indicator w-10 h-10 rounded-full flex items-center justify-center border-2 border-slate-300 font-semibold" data-step="2">2</div>
                        <div class="w-16 h-1 bg-slate-200"></div>
                        <div class="step-indicator w-10 h-10 rounded-full flex items-center justify-center border-2 border-slate-300 font-semibold" data-step="3">3</div>
                    </div>
                </div>

                <form method="POST" action="{{ route('kartu-keluarga.store-wizard') }}" id="wizardForm">
                    @csrf

                    <!-- Step 1: Select Jorong -->
                    <div class="wizard-step active" data-step="1">
                        <div class="bg-white rounded-2xl border border-slate-200 p-6">
                            <div class="flex items-center gap-3 mb-6">
                                <div class="h-10 w-10 rounded-xl bg-emerald-100 flex items-center justify-center">
                                    <svg class="h-5 w-5 text-emerald-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                </div>
                                <div>
                                    <h2 class="text-lg font-semibold text-slate-900">Pilih Jorong</h2>
                                    <p class="text-sm text-slate-500">Pilih jorong untuk kartu keluarga ini</p>
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-2">Jorong <span class="text-red-500">*</span></label>
                                <select name="jorong_id" required class="w-full rounded-lg border border-slate-300 px-4 py-2 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 outline-none transition">
                                    <option value="">Pilih Jorong</option>
                                    @foreach($jorongs as $jorong)
                                        <option value="{{ $jorong->id }}">{{ $jorong->nama_jorong }}</option>
                                    @endforeach
                                </select>
                                @error('jorong_id')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mt-6 flex justify-end">
                                <button type="button" onclick="nextStep(1)" class="px-6 py-2 rounded-full bg-emerald-700 text-white font-medium hover:bg-emerald-600 transition">
                                    Lanjut →
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Step 2: KK Details -->
                    <div class="wizard-step" data-step="2">
                        <div class="bg-white rounded-2xl border border-slate-200 p-6">
                            <div class="flex items-center gap-3 mb-6">
                                <div class="h-10 w-10 rounded-xl bg-blue-100 flex items-center justify-center">
                                    <svg class="h-5 w-5 text-blue-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                    </svg>
                                </div>
                                <div>
                                    <h2 class="text-lg font-semibold text-slate-900">Data Kartu Keluarga</h2>
                                    <p class="text-sm text-slate-500">Lengkapi informasi kartu keluarga</p>
                                </div>
                            </div>

                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-slate-700 mb-2">Nomor KK <span class="text-red-500">*</span></label>
                                    <input type="text" name="nomor_kk" required maxlength="16" placeholder="Nomor kartu keluarga" class="w-full rounded-lg border border-slate-300 px-4 py-2 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 outline-none transition" />
                                    @error('nomor_kk')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-slate-700 mb-2">Alamat <span class="text-red-500">*</span></label>
                                    <textarea name="alamat" required rows="3" placeholder="Alamat lengkap" class="w-full rounded-lg border border-slate-300 px-4 py-2 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 outline-none transition"></textarea>
                                    @error('alamat')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="grid gap-4 sm:grid-cols-3">
                                    <div>
                                        <label class="block text-sm font-medium text-slate-700 mb-2">RT</label>
                                        <input type="text" name="rt" maxlength="3" placeholder="RT" class="w-full rounded-lg border border-slate-300 px-4 py-2 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 outline-none transition" />
                                        @error('rt')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-slate-700 mb-2">RW</label>
                                        <input type="text" name="rw" maxlength="3" placeholder="RW" class="w-full rounded-lg border border-slate-300 px-4 py-2 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 outline-none transition" />
                                        @error('rw')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-slate-700 mb-2">Kode Pos</label>
                                        <input type="text" name="kode_pos" maxlength="5" placeholder="Kode pos" class="w-full rounded-lg border border-slate-300 px-4 py-2 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 outline-none transition" />
                                        @error('kode_pos')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <div class="grid gap-4 sm:grid-cols-2">
                                    <div>
                                        <label class="block text-sm font-medium text-slate-700 mb-2">Telepon</label>
                                        <input type="text" name="telepon" maxlength="20" placeholder="Nomor telepon" class="w-full rounded-lg border border-slate-300 px-4 py-2 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 outline-none transition" />
                                        @error('telepon')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-slate-700 mb-2">Kelompok Sosial</label>
                                        <select name="kelompok_sosial" class="w-full rounded-lg border border-slate-300 px-4 py-2 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 outline-none transition">
                                            <option value="">Pilih Kelompok Sosial</option>
                                            <option value="Miskin">Miskin</option>
                                            <option value="Rentan Miskin">Rentan Miskin</option>
                                            <option value="Menengah">Menengah</option>
                                            <option value="Mampu">Mampu</option>
                                        </select>
                                        @error('kelompok_sosial')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <div class="grid gap-4 sm:grid-cols-2">
                                    <div>
                                        <label class="block text-sm font-medium text-slate-700 mb-2">Tanggal Pembuatan</label>
                                        <input type="date" name="tanggal_pembuatan" class="w-full rounded-lg border border-slate-300 px-4 py-2 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 outline-none transition" />
                                        @error('tanggal_pembuatan')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-slate-700 mb-2">Tanggal Berlaku</label>
                                        <input type="date" name="tanggal_berlaku" class="w-full rounded-lg border border-slate-300 px-4 py-2 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 outline-none transition" />
                                        @error('tanggal_berlaku')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-slate-700 mb-2">Catatan</label>
                                    <textarea name="catatan" rows="2" placeholder="Catatan tambahan" class="w-full rounded-lg border border-slate-300 px-4 py-2 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 outline-none transition"></textarea>
                                    @error('catatan')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="mt-6 flex justify-between">
                                <button type="button" onclick="prevStep(2)" class="px-6 py-2 rounded-full border border-slate-300 text-slate-700 font-medium hover:bg-slate-50 transition">
                                    ← Kembali
                                </button>
                                <button type="button" onclick="nextStep(2)" class="px-6 py-2 rounded-full bg-emerald-700 text-white font-medium hover:bg-emerald-600 transition">
                                    Lanjut →
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Step 3: Head of Family Data -->
                    <div class="wizard-step" data-step="3">
                        <div class="bg-white rounded-2xl border border-slate-200 p-6">
                            <div class="flex items-center gap-3 mb-6">
                                <div class="h-10 w-10 rounded-xl bg-purple-100 flex items-center justify-center">
                                    <svg class="h-5 w-5 text-purple-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                </div>
                                <div>
                                    <h2 class="text-lg font-semibold text-slate-900">Data Kepala Keluarga</h2>
                                    <p class="text-sm text-slate-500">Lengkapi data kepala keluarga</p>
                                </div>
                            </div>

                            <div class="space-y-4">
                                <div class="grid gap-4 sm:grid-cols-2">
                                    <div>
                                        <label class="block text-sm font-medium text-slate-700 mb-2">NIK <span class="text-red-500">*</span></label>
                                        <input type="text" name="kepala_keluarga_nik" required maxlength="16" placeholder="Nomor Induk Kependudukan" class="w-full rounded-lg border border-slate-300 px-4 py-2 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 outline-none transition" />
                                        @error('kepala_keluarga_nik')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-slate-700 mb-2">Nama Lengkap <span class="text-red-500">*</span></label>
                                        <input type="text" name="kepala_keluarga_nama" required placeholder="Nama lengkap kepala keluarga" class="w-full rounded-lg border border-slate-300 px-4 py-2 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 outline-none transition" />
                                        @error('kepala_keluarga_nama')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <div class="grid gap-4 sm:grid-cols-2">
                                    <div>
                                        <label class="block text-sm font-medium text-slate-700 mb-2">Jenis Kelamin <span class="text-red-500">*</span></label>
                                        <select name="kepala_keluarga_jenis_kelamin" required class="w-full rounded-lg border border-slate-300 px-4 py-2 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 outline-none transition">
                                            <option value="">Pilih Jenis Kelamin</option>
                                            <option value="Laki-laki">Laki-laki</option>
                                            <option value="Perempuan">Perempuan</option>
                                        </select>
                                        @error('kepala_keluarga_jenis_kelamin')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-slate-700 mb-2">Agama <span class="text-red-500">*</span></label>
                                        <select name="kepala_keluarga_agama" required class="w-full rounded-lg border border-slate-300 px-4 py-2 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 outline-none transition">
                                            <option value="">Pilih Agama</option>
                                            <option value="Islam">Islam</option>
                                            <option value="Kristen">Kristen</option>
                                            <option value="Katolik">Katolik</option>
                                            <option value="Hindu">Hindu</option>
                                            <option value="Buddha">Buddha</option>
                                            <option value="Konghucu">Konghucu</option>
                                            <option value="Lainnya">Lainnya</option>
                                        </select>
                                        @error('kepala_keluarga_agama')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <div class="grid gap-4 sm:grid-cols-2">
                                    <div>
                                        <label class="block text-sm font-medium text-slate-700 mb-2">Tempat Lahir <span class="text-red-500">*</span></label>
                                        <input type="text" name="kepala_keluarga_tempat_lahir" required placeholder="Tempat lahir" class="w-full rounded-lg border border-slate-300 px-4 py-2 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 outline-none transition" />
                                        @error('kepala_keluarga_tempat_lahir')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-slate-700 mb-2">Tanggal Lahir <span class="text-red-500">*</span></label>
                                        <input type="date" name="kepala_keluarga_tanggal_lahir" required class="w-full rounded-lg border border-slate-300 px-4 py-2 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 outline-none transition" />
                                        @error('kepala_keluarga_tanggal_lahir')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <div class="grid gap-4 sm:grid-cols-2">
                                    <div>
                                        <label class="block text-sm font-medium text-slate-700 mb-2">Status Perkawinan <span class="text-red-500">*</span></label>
                                        <select name="kepala_keluarga_status_perkawinan" required class="w-full rounded-lg border border-slate-300 px-4 py-2 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 outline-none transition">
                                            <option value="">Pilih Status Perkawinan</option>
                                            <option value="Belum Menikah">Belum Menikah</option>
                                            <option value="Menikah">Menikah</option>
                                            <option value="Cerai Hidup">Cerai Hidup</option>
                                            <option value="Cerai Mati">Cerai Mati</option>
                                        </select>
                                        @error('kepala_keluarga_status_perkawinan')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-slate-700 mb-2">Pekerjaan <span class="text-red-500">*</span></label>
                                        <select name="kepala_keluarga_pekerjaan" required class="w-full rounded-lg border border-slate-300 px-4 py-2 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 outline-none transition">
                                            <option value="">Pilih Pekerjaan</option>
                                            <option value="Belum/Tidak Bekerja">Belum/Tidak Bekerja</option>
                                            <option value="Pegawai Negeri Sipil">Pegawai Negeri Sipil</option>
                                            <option value="TNI">TNI</option>
                                            <option value="Polri">Polri</option>
                                            <option value="Karyawan Swasta">Karyawan Swasta</option>
                                            <option value="Wiraswasta">Wiraswasta</option>
                                            <option value="Pedagang">Pedagang</option>
                                            <option value="Petani">Petani</option>
                                            <option value="Tukang">Tukang</option>
                                            <option value="Buruh Tani">Buruh Tani</option>
                                            <option value="Pensiunan">Pensiunan</option>
                                            <option value="Nelayan">Nelayan</option>
                                            <option value="Peternak">Peternak</option>
                                            <option value="Jasa">Jasa</option>
                                            <option value="Pengrajin">Pengrajin</option>
                                            <option value="Pekerja Seni">Pekerja Seni</option>
                                            <option value="Lainnya">Lainnya</option>
                                        </select>
                                        @error('kepala_keluarga_pekerjaan')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-slate-700 mb-2">Alamat Lengkap <span class="text-red-500">*</span></label>
                                    <textarea name="kepala_keluarga_alamat_lengkap" required rows="2" placeholder="Alamat lengkap kepala keluarga" class="w-full rounded-lg border border-slate-300 px-4 py-2 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 outline-none transition"></textarea>
                                    @error('kepala_keluarga_alamat_lengkap')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="grid gap-4 sm:grid-cols-2">
                                    <div>
                                        <label class="block text-sm font-medium text-slate-700 mb-2">Nama Ayah Kandung</label>
                                        <input type="text" name="kepala_keluarga_nama_ayah_kandung" maxlength="100" placeholder="Nama ayah kandung" class="w-full rounded-lg border border-slate-300 px-4 py-2 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 outline-none transition" />
                                        @error('kepala_keluarga_nama_ayah_kandung')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-slate-700 mb-2">Nama Ibu Kandung</label>
                                        <input type="text" name="kepala_keluarga_nama_ibu_kandung" maxlength="100" placeholder="Nama ibu kandung" class="w-full rounded-lg border border-slate-300 px-4 py-2 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 outline-none transition" />
                                        @error('kepala_keluarga_nama_ibu_kandung')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <div class="grid gap-4 sm:grid-cols-2">
                                    <div>
                                        <label class="block text-sm font-medium text-slate-700 mb-2">NIK Ayah</label>
                                        <input type="text" name="kepala_keluarga_ayah_nik" maxlength="16" placeholder="NIK ayah" class="w-full rounded-lg border border-slate-300 px-4 py-2 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 outline-none transition" />
                                        @error('kepala_keluarga_ayah_nik')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-slate-700 mb-2">NIK Ibu</label>
                                        <input type="text" name="kepala_keluarga_ibu_nik" maxlength="16" placeholder="NIK ibu" class="w-full rounded-lg border border-slate-300 px-4 py-2 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 outline-none transition" />
                                        @error('kepala_keluarga_ibu_nik')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-slate-700 mb-2">Catatan</label>
                                    <textarea name="kepala_keluarga_catatan" rows="2" placeholder="Catatan tambahan" class="w-full rounded-lg border border-slate-300 px-4 py-2 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 outline-none transition"></textarea>
                                    @error('kepala_keluarga_catatan')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-slate-700 mb-2">Pendidikan <span class="text-red-500">*</span></label>
                                    <select name="kepala_keluarga_tingkat_pendidikan" required class="w-full rounded-lg border border-slate-300 px-4 py-2 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 outline-none transition">
                                        <option value="">Pilih Pendidikan</option>
                                        <option value="Tidak/Belum Sekolah">Tidak/Belum Sekolah</option>
                                        <option value="Tidak Lulus SD">Tidak Lulus SD</option>
                                        <option value="SD/Sederajat">SD/Sederajat</option>
                                        <option value="SMP/Sederajat">SMP/Sederajat</option>
                                        <option value="SMA/Sederajat">SMA/Sederajat</option>
                                        <option value="D1">D1</option>
                                        <option value="D2">D2</option>
                                        <option value="D3">D3</option>
                                        <option value="S1/D4">S1/D4</option>
                                        <option value="S2">S2</option>
                                        <option value="S3">S3</option>
                                        <option value="Pondok Pesantren">Pondok Pesantren</option>
                                        <option value="Pendidikan Keagamaan">Pendidikan Keagamaan</option>
                                        <option value="Sekolah Luar Biasa">Sekolah Luar Biasa</option>
                                        <option value="Kursus Keterampilan">Kursus Keterampilan</option>
                                        <option value="Lainnya">Lainnya</option>
                                    </select>
                                    @error('kepala_keluarga_tingkat_pendidikan')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-slate-700 mb-2">Golongan Darah</label>
                                    <select name="kepala_keluarga_golongan_darah" class="w-full rounded-lg border border-slate-300 px-4 py-2 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 outline-none transition">
                                        <option value="">Pilih Golongan Darah</option>
                                        <option value="A">A</option>
                                        <option value="B">B</option>
                                        <option value="AB">AB</option>
                                        <option value="O">O</option>
                                    </select>
                                    @error('kepala_keluarga_golongan_darah')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-slate-700 mb-2">No. Paspor</label>
                                    <input type="text" name="kepala_keluarga_no_paspor" maxlength="20" placeholder="Nomor paspor" class="w-full rounded-lg border border-slate-300 px-4 py-2 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 outline-none transition" />
                                    @error('kepala_keluarga_no_paspor')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-slate-700 mb-2">Alamat Sesuai KK</label>
                                    <div class="flex items-center gap-2">
                                        <input type="checkbox" name="kepala_keluarga_sesuai_kk" value="1" checked class="rounded border-slate-300 text-emerald-600 focus:ring-emerald-500" />
                                        <span class="text-sm text-slate-600">Alamat sesuai dengan kartu keluarga</span>
                                    </div>
                                    @error('kepala_keluarga_sesuai_kk')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="mt-6 flex justify-between">
                                <button type="button" onclick="prevStep(3)" class="px-6 py-2 rounded-full border border-slate-300 text-slate-700 font-medium hover:bg-slate-50 transition">
                                    ← Kembali
                                </button>
                                <button type="submit" class="px-6 py-2 rounded-full bg-emerald-700 text-white font-medium hover:bg-emerald-600 transition">
                                    Simpan Kartu Keluarga
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </main>
    </div>

    <script>
        function nextStep(currentStep) {
            // Validate current step
            const currentStepEl = document.querySelector(`.wizard-step[data-step="${currentStep}"]`);
            const requiredFields = currentStepEl.querySelectorAll('[required]');
            let isValid = true;

            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    isValid = false;
                    field.classList.add('border-red-500');
                } else {
                    field.classList.remove('border-red-500');
                }
            });

            if (!isValid) {
                alert('Harap lengkapi semua field yang wajib diisi.');
                return;
            }

            // Move to next step
            currentStepEl.classList.remove('active');
            document.querySelector(`.wizard-step[data-step="${currentStep + 1}"]`).classList.add('active');
            
            // Update indicators
            document.querySelector(`.step-indicator[data-step="${currentStep}"]`).classList.remove('active');
            document.querySelector(`.step-indicator[data-step="${currentStep}"]`).classList.add('completed');
            document.querySelector(`.step-indicator[data-step="${currentStep + 1}"]`).classList.add('active');
        }

        function prevStep(currentStep) {
            // Move to previous step
            document.querySelector(`.wizard-step[data-step="${currentStep}"]`).classList.remove('active');
            document.querySelector(`.wizard-step[data-step="${currentStep - 1}"]`).classList.add('active');
            
            // Update indicators
            document.querySelector(`.step-indicator[data-step="${currentStep}"]`).classList.remove('active');
            document.querySelector(`.step-indicator[data-step="${currentStep - 1}"]`).classList.remove('completed');
            document.querySelector(`.step-indicator[data-step="${currentStep - 1}"]`).classList.add('active');
        }
    </script>
</body>
</html>