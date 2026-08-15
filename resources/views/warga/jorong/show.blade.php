<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Detail Jorong — Nagari Koto Kaciak Barat</title>
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
                    <a href="{{ route('kartu-keluarga.index') }}" class="text-slate-600 hover:text-emerald-700 transition">Kartu Keluarga</a>
                    <a href="{{ route('jorong.index') }}" class="text-emerald-700 font-medium">Jorong</a>
                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('admin.edit') }}" class="text-slate-600 hover:text-emerald-700 transition">Admin Panel</a>
                    @endif
                </nav>
            </div>
        </header>

        <main>
            <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8 py-8">
                <div class="mb-8">
                    <div class="flex items-center gap-4 mb-4">
                        <a href="{{ route('jorong.index') }}" class="text-slate-600 hover:text-emerald-700 transition">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                        </a>
                        <h1 class="text-2xl font-semibold tracking-tight text-slate-900">Detail Jorong</h1>
                    </div>
                </div>

                <!-- Jorong Info Card -->
                <div class="bg-white rounded-2xl border border-slate-200 p-6 mb-6">
                    <div class="flex items-start justify-between mb-6">
                        <div>
                            <h2 class="text-2xl font-bold text-slate-900">{{ $jorong->nama_jorong }}</h2>
                            @if($jorong->deskripsi)
                                <p class="text-slate-500">{{ $jorong->deskripsi }}</p>
                            @endif
                        </div>
                        <div class="flex gap-2">
                            <a href="{{ route('jorong.edit', $jorong) }}" class="px-4 py-2 rounded-full bg-emerald-700 text-white text-sm font-medium hover:bg-emerald-600 transition">
                                Edit
                            </a>
                        </div>
                    </div>

                    <div class="grid gap-4 sm:grid-cols-2">
                        @if($jorong->nama_ketua_jorong)
                            <div>
                                <p class="text-sm text-slate-500 mb-1">Ketua Jorong</p>
                                <p class="font-medium">{{ $jorong->nama_ketua_jorong }}</p>
                                @if($jorong->nik_ketua_jorong)
                                    <p class="text-sm text-slate-500">NIK: {{ $jorong->nik_ketua_jorong }}</p>
                                @endif
                            </div>
                        @endif
                        <div>
                            <p class="text-sm text-slate-500 mb-1">Status</p>
                            @if($jorong->is_active)
                                <span class="px-2 py-1 rounded-full bg-emerald-100 text-emerald-700 text-xs font-medium">Aktif</span>
                            @else
                                <span class="px-2 py-1 rounded-full bg-slate-100 text-slate-700 text-xs font-medium">Non-Aktif</span>
                            @endif
                        </div>
                        <div>
                            <p class="text-sm text-slate-500 mb-1">Jumlah Kartu Keluarga</p>
                            <p class="font-medium">{{ $jorong->jumlah_kk }} KK</p>
                        </div>
                        <div>
                            <p class="text-sm text-slate-500 mb-1">Jumlah Warga</p>
                            <p class="font-medium">{{ $jorong->jumlah_warga }} orang</p>
                        </div>
                    </div>
                </div>

                <!-- Kartu Keluarga List -->
                <div class="bg-white rounded-2xl border border-slate-200 p-6 mb-6">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-lg font-semibold text-slate-900">Kartu Keluarga di Jorong Ini</h3>
                        <a href="{{ route('kartu-keluarga.create') }}?jorong_id={{ $jorong->id }}" class="px-4 py-2 rounded-full bg-emerald-700 text-white text-sm font-medium hover:bg-emerald-600 transition">
                            + Tambah KK
                        </a>
                    </div>

                    @if($jorong->kartuKeluargas->count() > 0)
                        <div class="space-y-3">
                            @foreach($jorong->kartuKeluargas as $kk)
                                <div class="flex items-center justify-between p-4 bg-slate-50 rounded-xl">
                                    <div class="flex items-center gap-4">
                                        <div class="h-10 w-10 rounded-full bg-emerald-100 flex items-center justify-center">
                                            <svg class="h-5 w-5 text-emerald-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="font-medium text-slate-900">{{ $kk->nomor_kk }}</p>
                                            <p class="text-sm text-slate-500">{{ $kk->nama_kepala_keluarga }} • {{ $kk->jumlah_anggota }} anggota</p>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <a href="{{ route('kartu-keluarga.show', $kk) }}" class="text-emerald-600 hover:text-emerald-700 text-sm font-medium">Lihat</a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8 text-slate-500">
                            <p class="text-lg font-medium">Belum ada kartu keluarga</p>
                            <p class="text-sm">Tambahkan kartu keluarga untuk jorong ini</p>
                        </div>
                    @endif
                </div>

                <!-- Action Buttons -->
                <div class="flex items-center justify-between">
                    <a href="{{ route('jorong.index') }}" class="px-6 py-3 rounded-full border border-slate-300 text-slate-700 font-medium hover:bg-slate-50 transition">
                        Kembali
                    </a>
                    <div class="flex gap-2">
                        <a href="{{ route('jorong.edit', $jorong) }}" class="px-6 py-3 rounded-full bg-emerald-700 text-white font-medium shadow-glow hover:bg-emerald-600 transition">
                            Edit Data
                        </a>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>