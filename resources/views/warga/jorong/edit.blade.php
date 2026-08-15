<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Edit Jorong — Nagari Koto Kaciak Barat</title>
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
            <div class="mx-auto max-w-2xl px-4 sm:px-6 lg:px-8 py-8">
                <div class="mb-8">
                    <div class="flex items-center gap-4 mb-4">
                        <a href="{{ route('jorong.index') }}" class="text-slate-600 hover:text-emerald-700 transition">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                        </a>
                        <h1 class="text-2xl font-semibold tracking-tight text-slate-900">Edit Jorong</h1>
                    </div>
                    <p class="text-slate-600">Edit data jorong: <strong>{{ $jorong->nama_jorong }}</strong></p>
                </div>

                <form method="POST" action="{{ route('jorong.update', $jorong) }}" class="bg-white rounded-2xl border border-slate-200 p-6">
                    @csrf
                    @method('PUT')

                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">Nama Jorong <span class="text-red-500">*</span></label>
                            <input type="text" name="nama_jorong" required value="{{ old('nama_jorong', $jorong->nama_jorong) }}" placeholder="Nama jorong" class="w-full rounded-lg border border-slate-300 px-4 py-2 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 outline-none transition" />
                            @error('nama_jorong')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">Deskripsi</label>
                            <textarea name="deskripsi" rows="3" placeholder="Deskripsi jorong" class="w-full rounded-lg border border-slate-300 px-4 py-2 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 outline-none transition">{{ old('deskripsi', $jorong->deskripsi) }}</textarea>
                            @error('deskripsi')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid gap-4 sm:grid-cols-2">
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-2">NIK Ketua Jorong</label>
                                <input type="text" name="nik_ketua_jorong" maxlength="16" value="{{ old('nik_ketua_jorong', $jorong->nik_ketua_jorong) }}" placeholder="NIK ketua jorong" class="w-full rounded-lg border border-slate-300 px-4 py-2 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 outline-none transition" />
                                @error('nik_ketua_jorong')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-2">Nama Ketua Jorong</label>
                                <input type="text" name="nama_ketua_jorong" value="{{ old('nama_ketua_jorong', $jorong->nama_ketua_jorong) }}" placeholder="Nama ketua jorong" class="w-full rounded-lg border border-slate-300 px-4 py-2 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 outline-none transition" />
                                @error('nama_ketua_jorong')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div>
                            <label class="flex items-center gap-2">
                                <input type="checkbox" name="is_active" value="1" {{ $jorong->is_active ? 'checked' : '' }} class="rounded border-slate-300 text-emerald-600 focus:ring-emerald-500" />
                                <span class="text-sm text-slate-700">Jorong Aktif</span>
                            </label>
                        </div>
                    </div>

                    <div class="flex items-center justify-end gap-4 mt-6">
                        <a href="{{ route('jorong.index') }}" class="px-6 py-3 rounded-full border border-slate-300 text-slate-700 font-medium hover:bg-slate-50 transition">
                            Batal
                        </a>
                        <button type="submit" class="px-6 py-3 rounded-full bg-emerald-700 text-white font-medium shadow-glow hover:bg-emerald-600 transition">
                            Update Jorong
                        </button>
                    </div>
                </form>
            </div>
        </main>
    </div>
</body>
</html>