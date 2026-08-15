<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Detail Warga — Nagari Koto Kaciak Barat</title>
    <meta name="description" content="Detail data warga" />
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
        .info-card {
            transition: all 0.2s ease;
        }
        .info-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
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
            <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8 py-8">
                <!-- Page Header -->
                <div class="mb-8">
                    <div class="flex items-center gap-4 mb-4">
                        <a href="{{ route('warga.index') }}" class="text-slate-600 hover:text-emerald-700 transition">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                        </a>
                        <h1 class="text-2xl font-semibold tracking-tight text-slate-900">Detail Data Warga</h1>
                    </div>
                </div>

                <!-- Status Banner -->
                @if($warga->is_wafat)
                    <div class="mb-6 bg-red-50 border border-red-200 rounded-2xl p-4 flex items-center gap-3">
                        <div class="h-10 w-10 rounded-full bg-red-200 flex items-center justify-center">
                            <svg class="h-5 w-5 text-red-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <p class="font-semibold text-red-800">Warga Sudah Wafat</p>
                            <p class="text-sm text-red-600">Tanggal wafat: {{ $warga->tanggal_wafat ? $warga->tanggal_wafat->format('d F Y') : '-' }}</p>
                        </div>
                    </div>
                @endif

                <!-- Main Info Card -->
                <div class="info-card bg-white rounded-2xl border border-slate-200 p-6 mb-6">
                    <div class="flex items-start gap-6">
                        <div class="h-20 w-20 rounded-2xl bg-emerald-100 flex items-center justify-center flex-shrink-0">
                            <svg class="h-10 w-10 text-emerald-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <div class="flex-1">
                            <div class="flex items-start justify-between">
                                <div>
                                    <h2 class="text-2xl font-bold text-slate-900">{{ $warga->nama_lengkap }}</h2>
                                    @if($warga->nama_panggilan)
                                        <p class="text-slate-500">"{{ $warga->nama_panggilan }}"</p>
                                    @endif
                                </div>
                                <div class="flex gap-2">
                                    <a href="{{ route('warga.edit', $warga) }}" class="px-4 py-2 rounded-full bg-emerald-700 text-white text-sm font-medium hover:bg-emerald-600 transition">
                                        Edit
                                    </a>
                                </div>
                            </div>
                            <div class="mt-4 grid gap-2 sm:grid-cols-2">
                                <div class="flex items-center gap-2">
                                    <span class="text-slate-500">NIK:</span>
                                    <span class="font-mono font-medium">{{ $warga->nik }}</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <span class="text-slate-500">Jenis Kelamin:</span>
                                    <span class="font-medium">{{ $warga->jenis_kelamin }}</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <span class="text-slate-500">Tempat/Tanggal Lahir:</span>
                                    <span class="font-medium">{{ $warga->tempat_lahir }}, {{ $warga->tanggal_lahir->format('d F Y') }}</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <span class="text-slate-500">Umur:</span>
                                    <span class="font-medium">{{ $warga->umur }} tahun</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <span class="text-slate-500">Agama:</span>
                                    <span class="font-medium">{{ $warga->agama }}</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <span class="text-slate-500">Status Perkawinan:</span>
                                    <span class="font-medium">{{ $warga->status_perkawinan }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Family Info -->
                <div class="info-card bg-white rounded-2xl border border-slate-200 p-6 mb-6">
                    <h3 class="text-lg font-semibold text-slate-900 mb-4">Keluarga</h3>
                    <div class="grid gap-4 sm:grid-cols-2">
                        <div>
                            <p class="text-sm text-slate-500 mb-1">Kartu Keluarga</p>
                            <p class="font-medium">{{ $warga->kartuKeluarga->nomor_kk ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-slate-500 mb-1">Jorong</p>
                            <p class="font-medium">{{ $warga->kartuKeluarga->jorong->nama_jorong ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-slate-500 mb-1">Hubungan dalam Keluarga</p>
                            <p class="font-medium">{{ $warga->hubungan_keluarga }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-slate-500 mb-1">Kepala Keluarga</p>
                            <p class="font-medium">{{ $warga->kartuKeluarga?->nama_kepala_keluarga ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-slate-500 mb-1">Nama Ayah Kandung</p>
                            <p class="font-medium">{{ $warga->nama_ayah_kandung ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-slate-500 mb-1">Nama Ibu Kandung</p>
                            <p class="font-medium">{{ $warga->nama_ibu_kandung ?? '-' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Address Info -->
                <div class="info-card bg-white rounded-2xl border border-slate-200 p-6 mb-6">
                    <h3 class="text-lg font-semibold text-slate-900 mb-4">Alamat</h3>
                    <div class="space-y-2">
                        <div>
                            <p class="text-sm text-slate-500 mb-1">Alamat Lengkap</p>
                            <p class="font-medium">{{ $warga->alamat_lengkap }}</p>
                        </div>
                        @if($warga->kelurahan || $warga->kecamatan || $warga->kabupaten || $warga->provinsi)
                            <div class="grid gap-2 sm:grid-cols-2 mt-4">
                                @if($warga->kelurahan)
                                    <div>
                                        <p class="text-sm text-slate-500 mb-1">Kelurahan</p>
                                        <p class="font-medium">{{ $warga->kelurahan }}</p>
                                    </div>
                                @endif
                                @if($warga->kecamatan)
                                    <div>
                                        <p class="text-sm text-slate-500 mb-1">Kecamatan</p>
                                        <p class="font-medium">{{ $warga->kecamatan }}</p>
                                    </div>
                                @endif
                                @if($warga->kabupaten)
                                    <div>
                                        <p class="text-sm text-slate-500 mb-1">Kabupaten</p>
                                        <p class="font-medium">{{ $warga->kabupaten }}</p>
                                    </div>
                                @endif
                                @if($warga->provinsi)
                                    <div>
                                        <p class="text-sm text-slate-500 mb-1">Provinsi</p>
                                        <p class="font-medium">{{ $warga->provinsi }}</p>
                                    </div>
                                @endif
                            </div>
                        @endif
                        <div class="mt-4">
                            <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-sm {{ $warga->sesuai_kk ? 'bg-emerald-100 text-emerald-700' : 'bg-amber-100 text-amber-700' }}">
                                @if($warga->sesuai_kk)
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                    Alamat sesuai KK
                                @else
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                    </svg>
                                    Alamat tidak sesuai KK
                                @endif
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Work & Education -->
                <div class="grid gap-6 sm:grid-cols-2 mb-6">
                    <div class="info-card bg-white rounded-2xl border border-slate-200 p-6">
                        <h3 class="text-lg font-semibold text-slate-900 mb-4">Pekerjaan</h3>
                        <div>
                            <p class="text-sm text-slate-500 mb-1">Pekerjaan</p>
                            <p class="font-medium">{{ $warga->pekerjaan_full }}</p>
                        </div>
                    </div>
                    <div class="info-card bg-white rounded-2xl border border-slate-200 p-6">
                        <h3 class="text-lg font-semibold text-slate-900 mb-4">Pendidikan</h3>
                        <div>
                            <p class="text-sm text-slate-500 mb-1">Tingkat Pendidikan</p>
                            <p class="font-medium">{{ $warga->pendidikan_full }}</p>
                        </div>
                    </div>
                </div>

                <!-- Additional Info -->
                <div class="info-card bg-white rounded-2xl border border-slate-200 p-6 mb-6">
                    <h3 class="text-lg font-semibold text-slate-900 mb-4">Data Tambahan</h3>
                    <div class="grid gap-4 sm:grid-cols-2">
                        @if($warga->golongan_darah)
                            <div>
                                <p class="text-sm text-slate-500 mb-1">Golongan Darah</p>
                                <p class="font-medium">{{ $warga->golongan_darah }}</p>
                            </div>
                        @endif
                        @if($warga->no_paspor)
                            <div>
                                <p class="text-sm text-slate-500 mb-1">No. Paspor</p>
                                <p class="font-medium font-mono">{{ $warga->no_paspor }}</p>
                            </div>
                        @endif
                        @if($warga->no_kitap)
                            <div>
                                <p class="text-sm text-slate-500 mb-1">No. KITAP</p>
                                <p class="font-medium font-mono">{{ $warga->no_kitap }}</p>
                            </div>
                        @endif
                        @if($warga->ayah_nik)
                            <div>
                                <p class="text-sm text-slate-500 mb-1">NIK Ayah</p>
                                <p class="font-medium font-mono">{{ $warga->ayah_nik }}</p>
                            </div>
                        @endif
                        @if($warga->ibu_nik)
                            <div>
                                <p class="text-sm text-slate-500 mb-1">NIK Ibu</p>
                                <p class="font-medium font-mono">{{ $warga->ibu_nik }}</p>
                            </div>
                        @endif
                    </div>
                    @if($warga->catatan)
                        <div class="mt-4">
                            <p class="text-sm text-slate-500 mb-1">Catatan</p>
                            <p class="font-medium">{{ $warga->catatan }}</p>
                        </div>
                    @endif
                </div>

                <!-- Action Buttons -->
                <div class="flex items-center justify-between">
                    <a href="{{ route('warga.index') }}" class="px-6 py-3 rounded-full border border-slate-300 text-slate-700 font-medium hover:bg-slate-50 transition">
                        Kembali
                    </a>
                    <div class="flex gap-2">
                        <a href="{{ route('warga.edit', $warga) }}" class="px-6 py-3 rounded-full bg-emerald-700 text-white font-medium shadow-glow hover:bg-emerald-600 transition">
                            Edit Data
                        </a>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>