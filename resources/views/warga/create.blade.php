<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Tambah Warga — Nagari Koto Kaciak Barat</title>
    <meta name="description" content="Tambah data warga baru" />
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
        html { scroll-behavior: smooth; }
        .form-section {
            transition: all 0.3s ease;
        }
        .form-section:hover {
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        }
        .form-input {
            transition: border-color 0.2s, box-shadow 0.2s;
        }
        .form-input:focus {
            border-color: #047857;
            box-shadow: 0 0 0 3px rgba(4,120,87,0.1);
        }
        .conditional-field {
            display: none;
        }
        .conditional-field.show {
            display: block;
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
                    <a href="{{ route('warga.index') }}" class="text-emerald-700 font-medium">Data Warga</a>
                    <a href="{{ route('kartu-keluarga.index') }}" class="text-slate-600 hover:text-emerald-700 transition">Kartu Keluarga</a>
                    <a href="{{ route('jorong.index') }}" class="text-slate-600 hover:text-emerald-700 transition">Jorong</a>
                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('admin.edit') }}" class="text-slate-600 hover:text-emerald-700 transition">Admin Panel</a>
                    @endif
                    @if(auth()->user()->isWaliJorong() && auth()->user()->jorong)
                        <span class="px-2 py-1 rounded-full bg-emerald-100 text-emerald-700 text-xs font-medium">
                            {{ auth()->user()->jorong->nama_jorong }}
                        </span>
                    @endif
                </nav>
            </div>
        </header>

        <main>
            <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8 py-8">
                <!-- Page Header -->
                <div class="mb-8">
                    <div class="flex items-center gap-4 mb-4">
                        <a href="{{ route('warga.index') }}" class="text-slate-600 hover:text-emerald-700 transition">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                        </a>
                        <h1 class="text-2xl font-semibold tracking-tight text-slate-900">Tambah Data Warga</h1>
                    </div>
                    <p class="text-slate-600">
                        @if(auth()->user()->isWaliJorong() && auth()->user()->jorong)
                            Lengkapi formulir di bawah ini untuk menambahkan data warga baru di Jorong: <strong>{{ auth()->user()->jorong->nama_jorong }}</strong>
                        @else
                            Lengkapi formulir di bawah ini untuk menambahkan data warga baru.
                        @endif
                    </p>
                </div>

                <form method="POST" action="{{ route('warga.store') }}" class="space-y-6">
                    @csrf

                    <!-- Section 2: Data Diri -->
                    <div class="form-section bg-white rounded-2xl border border-slate-200 p-6">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="h-10 w-10 rounded-xl bg-blue-100 flex items-center justify-center">
                                <svg class="h-5 w-5 text-blue-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </div>
                            <div>
                                <h2 class="text-lg font-semibold text-slate-900">Data Diri</h2>
                                <p class="text-sm text-slate-500">Informasi pribadi warga</p>
                            </div>
                        </div>

                        <div class="grid gap-4 sm:grid-cols-2">
                            <div class="sm:col-span-2">
                                <label class="block text-sm font-medium text-slate-700 mb-2">Nama Lengkap <span class="text-red-500">*</span></label>
                                <input type="text" name="nama_lengkap" required placeholder="Nama lengkap sesuai KTP" class="form-input w-full rounded-lg border border-slate-300 px-4 py-2 outline-none" />
                                @error('nama_lengkap')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-2">Nama Panggilan</label>
                                <input type="text" name="nama_panggilan" placeholder="Nama sehari-hari" class="form-input w-full rounded-lg border border-slate-300 px-4 py-2 outline-none" />
                                @error('nama_panggilan')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-2">Jenis Kelamin <span class="text-red-500">*</span></label>
                                <select name="jenis_kelamin" required class="form-input w-full rounded-lg border border-slate-300 px-4 py-2 outline-none">
                                    <option value="">Pilih Jenis Kelamin</option>
                                    <option value="Laki-laki">Laki-laki</option>
                                    <option value="Perempuan">Perempuan</option>
                                </select>
                                @error('jenis_kelamin')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-2">Tempat Lahir <span class="text-red-500">*</span></label>
                                <input type="text" name="tempat_lahir" required placeholder="Kota kelahiran" class="form-input w-full rounded-lg border border-slate-300 px-4 py-2 outline-none" />
                                @error('tempat_lahir')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-2">Tanggal Lahir <span class="text-red-500">*</span></label>
                                <input type="date" name="tanggal_lahir" required class="form-input w-full rounded-lg border border-slate-300 px-4 py-2 outline-none" />
                                @error('tanggal_lahir')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="sm:col-span-2">
                                <label class="block text-sm font-medium text-slate-700 mb-2">Agama <span class="text-red-500">*</span></label>
                                <select name="agama" required class="form-input w-full rounded-lg border border-slate-300 px-4 py-2 outline-none">
                                    <option value="">Pilih Agama</option>
                                    <option value="Islam">Islam</option>
                                    <option value="Kristen">Kristen</option>
                                    <option value="Katolik">Katolik</option>
                                    <option value="Hindu">Hindu</option>
                                    <option value="Buddha">Buddha</option>
                                    <option value="Konghucu">Konghucu</option>
                                    <option value="Lainnya">Lainnya</option>
                                </select>
                                @error('agama')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Section 3: Status dan Keluarga -->
                    <div class="form-section bg-white rounded-2xl border border-slate-200 p-6">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="h-10 w-10 rounded-xl bg-purple-100 flex items-center justify-center">
                                <svg class="h-5 w-5 text-purple-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                            </div>
                            <div>
                                <h2 class="text-lg font-semibold text-slate-900">Status dan Keluarga</h2>
                                <p class="text-sm text-slate-500">Status perkawinan dan hubungan keluarga</p>
                            </div>
                        </div>

                        <div class="grid gap-4 sm:grid-cols-2">
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-2">Status Perkawinan <span class="text-red-500">*</span></label>
                                <select name="status_perkawinan" required class="form-input w-full rounded-lg border border-slate-300 px-4 py-2 outline-none">
                                    <option value="">Pilih Status</option>
                                    <option value="Belum Menikah">Belum Menikah</option>
                                    <option value="Menikah">Menikah</option>
                                    <option value="Cerai Hidup">Cerai Hidup</option>
                                    <option value="Cerai Mati">Cerai Mati</option>
                                </select>
                                @error('status_perkawinan')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-2">Hubungan dalam Keluarga <span class="text-red-500">*</span></label>
                                <select name="hubungan_keluarga" required class="form-input w-full rounded-lg border border-slate-300 px-4 py-2 outline-none">
                                    <option value="">Pilih Hubungan</option>
                                    <option value="Kepala Keluarga">Kepala Keluarga</option>
                                    <option value="Istri">Istri</option>
                                    <option value="Anak">Anak</option>
                                    <option value="Orang Tua">Orang Tua</option>
                                    <option value="Cucu">Cucu</option>
                                    <option value="Famili Lain">Famili Lain</option>
                                    <option value="Lainnya">Lainnya</option>
                                </select>
                                @error('hubungan_keluarga')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-2">Nama Ayah Kandung</label>
                                <input type="text" name="nama_ayah_kandung" placeholder="Nama ayah kandung" class="form-input w-full rounded-lg border border-slate-300 px-4 py-2 outline-none" />
                                @error('nama_ayah_kandung')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-2">Nama Ibu Kandung</label>
                                <input type="text" name="nama_ibu_kandung" placeholder="Nama ibu kandung" class="form-input w-full rounded-lg border border-slate-300 px-4 py-2 outline-none" />
                                @error('nama_ibu_kandung')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Section 4: Alamat dan Domisili -->
                    <div class="form-section bg-white rounded-2xl border border-slate-200 p-6">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="h-10 w-10 rounded-xl bg-orange-100 flex items-center justify-center">
                                <svg class="h-5 w-5 text-orange-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </div>
                            <div>
                                <h2 class="text-lg font-semibold text-slate-900">Alamat dan Domisili</h2>
                                <p class="text-sm text-slate-500">Alamat lengkap dan domisili</p>
                            </div>
                        </div>

                        <div class="grid gap-4">
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-2">Alamat Lengkap <span class="text-red-500">*</span></label>
                                <textarea name="alamat_lengkap" required rows="3" placeholder="Alamat lengkap tempat tinggal" class="form-input w-full rounded-lg border border-slate-300 px-4 py-2 outline-none"></textarea>
                                @error('alamat_lengkap')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="grid gap-4 sm:grid-cols-2">
                                <div>
                                    <label class="block text-sm font-medium text-slate-700 mb-2">Kelurahan</label>
                                    <input type="text" name="kelurahan" placeholder="Kelurahan/Desa" class="form-input w-full rounded-lg border border-slate-300 px-4 py-2 outline-none" />
                                    @error('kelurahan')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-slate-700 mb-2">Kecamatan</label>
                                    <input type="text" name="kecamatan" placeholder="Kecamatan" class="form-input w-full rounded-lg border border-slate-300 px-4 py-2 outline-none" />
                                    @error('kecamatan')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-slate-700 mb-2">Kabupaten</label>
                                    <input type="text" name="kabupaten" placeholder="Kabupaten/Kota" class="form-input w-full rounded-lg border border-slate-300 px-4 py-2 outline-none" />
                                    @error('kabupaten')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-slate-700 mb-2">Provinsi</label>
                                    <input type="text" name="provinsi" placeholder="Provinsi" class="form-input w-full rounded-lg border border-slate-300 px-4 py-2 outline-none" />
                                    @error('provinsi')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div>
                                <label class="flex items-center gap-2">
                                    <input type="checkbox" name="sesuai_kk" value="1" checked class="rounded border-slate-300 text-emerald-600 focus:ring-emerald-500" />
                                    <span class="text-sm text-slate-700">Alamat sesuai dengan Kartu Keluarga</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Section 5: Pekerjaan -->
                    <div class="form-section bg-white rounded-2xl border border-slate-200 p-6">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="h-10 w-10 rounded-xl bg-teal-100 flex items-center justify-center">
                                <svg class="h-5 w-5 text-teal-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <div>
                                <h2 class="text-lg font-semibold text-slate-900">Pekerjaan</h2>
                                <p class="text-sm text-slate-500">Pekerjaan atau mata pencarian</p>
                            </div>
                        </div>

                        <div class="grid gap-4 sm:grid-cols-2">
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-2">Pekerjaan <span class="text-red-500">*</span></label>
                                <select name="pekerjaan" required id="pekerjaan" class="form-input w-full rounded-lg border border-slate-300 px-4 py-2 outline-none">
                                    <option value="">Pilih Pekerjaan</option>
                                    @foreach(App\Models\Warga::getPekerjaanOptions() as $key => $value)
                                        <option value="{{ $key }}">{{ $value }}</option>
                                    @endforeach
                                </select>
                                @error('pekerjaan')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div id="pekerjaan_lain_container" class="conditional-field">
                                <label class="block text-sm font-medium text-slate-700 mb-2">Pekerjaan Lain</label>
                                <input type="text" name="pekerjaan_lain" placeholder="Jelaskan pekerjaan lain" class="form-input w-full rounded-lg border border-slate-300 px-4 py-2 outline-none" />
                                @error('pekerjaan_lain')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Section 6: Pendidikan -->
                    <div class="form-section bg-white rounded-2xl border border-slate-200 p-6">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="h-10 w-10 rounded-xl bg-indigo-100 flex items-center justify-center">
                                <svg class="h-5 w-5 text-indigo-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222" />
                                </svg>
                            </div>
                            <div>
                                <h2 class="text-lg font-semibold text-slate-900">Pendidikan</h2>
                                <p class="text-sm text-slate-500">Tingkat pendidikan terakhir</p>
                            </div>
                        </div>

                        <div class="grid gap-4 sm:grid-cols-2">
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-2">Tingkat Pendidikan <span class="text-red-500">*</span></label>
                                <select name="tingkat_pendidikan" required id="pendidikan" class="form-input w-full rounded-lg border border-slate-300 px-4 py-2 outline-none">
                                    <option value="">Pilih Pendidikan</option>
                                    @foreach(App\Models\Warga::getPendidikanOptions() as $key => $value)
                                        <option value="{{ $key }}">{{ $value }}</option>
                                    @endforeach
                                </select>
                                @error('tingkat_pendidikan')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div id="pendidikan_lain_container" class="conditional-field">
                                <label class="block text-sm font-medium text-slate-700 mb-2">Pendidikan Lain</label>
                                <input type="text" name="pendidikan_lain" placeholder="Jelaskan pendidikan lain" class="form-input w-full rounded-lg border border-slate-300 px-4 py-2 outline-none" />
                                @error('pendidikan_lain')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Section 7: Data Tambahan -->
                    <div class="form-section bg-white rounded-2xl border border-slate-200 p-6">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="h-10 w-10 rounded-xl bg-slate-100 flex items-center justify-center">
                                <svg class="h-5 w-5 text-slate-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                            <div>
                                <h2 class="text-lg font-semibold text-slate-900">Data Tambahan</h2>
                                <p class="text-sm text-slate-500">Informasi tambahan (opsional)</p>
                            </div>
                        </div>

                        <div class="grid gap-4 sm:grid-cols-2">
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-2">Golongan Darah</label>
                                <select name="golongan_darah" class="form-input w-full rounded-lg border border-slate-300 px-4 py-2 outline-none">
                                    <option value="">Pilih Golongan Darah</option>
                                    <option value="A">A</option>
                                    <option value="B">B</option>
                                    <option value="AB">AB</option>
                                    <option value="O">O</option>
                                </select>
                                @error('golongan_darah')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-2">No. Paspor</label>
                                <input type="text" name="no_paspor" placeholder="Nomor paspor" class="form-input w-full rounded-lg border border-slate-300 px-4 py-2 outline-none" />
                                @error('no_paspor')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-2">No. KITAP</label>
                                <input type="text" name="no_kitap" placeholder="Nomor KITAP" class="form-input w-full rounded-lg border border-slate-300 px-4 py-2 outline-none" />
                                @error('no_kitap')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-2">NIK Ayah</label>
                                <input type="text" name="ayah_nik" placeholder="NIK ayah" class="form-input w-full rounded-lg border border-slate-300 px-4 py-2 outline-none" />
                                @error('ayah_nik')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-2">NIK Ibu</label>
                                <input type="text" name="ibu_nik" placeholder="NIK ibu" class="form-input w-full rounded-lg border border-slate-300 px-4 py-2 outline-none" />
                                @error('ibu_nik')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="flex items-center gap-2">
                                    <input type="checkbox" name="is_wafat" value="1" id="is_wafat" class="rounded border-slate-300 text-emerald-600 focus:ring-emerald-500" />
                                    <span class="text-sm text-slate-700">Warga sudah wafat</span>
                                </label>
                            </div>
                            <div id="tanggal_wafat_container" class="conditional-field sm:col-span-2">
                                <label class="block text-sm font-medium text-slate-700 mb-2">Tanggal Wafat</label>
                                <input type="date" name="tanggal_wafat" id="tanggal_wafat" class="form-input w-full rounded-lg border border-slate-300 px-4 py-2 outline-none" />
                                @error('tanggal_wafat')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="sm:col-span-2">
                                <label class="block text-sm font-medium text-slate-700 mb-2">Catatan</label>
                                <textarea name="catatan" rows="3" placeholder="Catatan tambahan" class="form-input w-full rounded-lg border border-slate-300 px-4 py-2 outline-none"></textarea>
                                @error('catatan')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex items-center justify-end gap-4">
                        <a href="{{ route('warga.index') }}" class="px-6 py-3 rounded-full border border-slate-300 text-slate-700 font-medium hover:bg-slate-50 transition">
                            Batal
                        </a>
                        <button type="submit" class="px-6 py-3 rounded-full bg-emerald-700 text-white font-medium shadow-glow hover:bg-emerald-600 transition">
                            Simpan Data Warga
                        </button>
                    </div>
                </form>
            </div>
        </main>
    </div>

    <script>
        // Show/hide conditional fields
        document.getElementById('pekerjaan').addEventListener('change', function() {
            const lainContainer = document.getElementById('pekerjaan_lain_container');
            if (this.value === 'Lainnya') {
                lainContainer.classList.add('show');
            } else {
                lainContainer.classList.remove('show');
            }
        });

        document.getElementById('pendidikan').addEventListener('change', function() {
            const lainContainer = document.getElementById('pendidikan_lain_container');
            if (this.value === 'Lainnya') {
                lainContainer.classList.add('show');
            } else {
                lainContainer.classList.remove('show');
            }
        });

        document.getElementById('is_wafat').addEventListener('change', function() {
            const wafatContainer = document.getElementById('tanggal_wafat_container');
            if (this.checked) {
                wafatContainer.classList.add('show');
            } else {
                wafatContainer.classList.remove('show');
            }
        });
    </script>
</body>
</html>