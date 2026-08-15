<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Edit Kartu Keluarga — Nagari Koto Kaciak Barat</title>
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
                    <a href="{{ route('kartu-keluarga.index') }}" class="text-emerald-700 font-medium">Kartu Keluarga</a>
                    <a href="{{ route('jorong.index') }}" class="text-slate-600 hover:text-emerald-700 transition">Jorong</a>
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
                        <a href="{{ route('kartu-keluarga.show', $kartuKeluarga) }}" class="text-slate-600 hover:text-emerald-700 transition">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                        </a>
                        <h1 class="text-2xl font-semibold tracking-tight text-slate-900">Edit Kartu Keluarga</h1>
                    </div>
                    <p class="text-slate-600">Edit data kartu keluarga: <strong>{{ $kartuKeluarga->nomor_kk }}</strong></p>
                </div>

                <form method="POST" action="{{ route('kartu-keluarga.update', $kartuKeluarga) }}" class="bg-white rounded-2xl border border-slate-200 p-6">
                    @csrf
                    @method('PUT')

                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">Jorong <span class="text-red-500">*</span></label>
                            <select name="jorong_id" required class="w-full rounded-lg border border-slate-300 px-4 py-2 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 outline-none transition">
                                <option value="">Pilih Jorong</option>
                                @foreach($jorongs as $jorong)
                                    <option value="{{ $jorong->id }}" {{ $kartuKeluarga->jorong_id == $jorong->id ? 'selected' : '' }}>{{ $jorong->nama_jorong }}</option>
                                @endforeach
                            </select>
                            @error('jorong_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">Nomor KK <span class="text-red-500">*</span></label>
                            <input type="text" name="nomor_kk" required maxlength="16" value="{{ old('nomor_kk', $kartuKeluarga->nomor_kk) }}" placeholder="Nomor kartu keluarga" class="w-full rounded-lg border border-slate-300 px-4 py-2 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 outline-none transition" />
                            @error('nomor_kk')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">Kepala Keluarga <span class="text-red-500">*</span></label>
                            <input type="text" name="kepala_keluarga" required value="{{ old('kepala_keluarga', $kartuKeluarga->getRawOriginal('kepala_keluarga') ?: ($kartuKeluarga->kepalaKeluarga?->nama_lengkap ?? '')) }}" placeholder="Nama kepala keluarga" class="w-full rounded-lg border border-slate-300 px-4 py-2 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 outline-none transition" />
                            @error('kepala_keluarga')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">Alamat <span class="text-red-500">*</span></label>
                            <textarea name="alamat" required rows="3" placeholder="Alamat lengkap" class="w-full rounded-lg border border-slate-300 px-4 py-2 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 outline-none transition">{{ old('alamat', $kartuKeluarga->alamat) }}</textarea>
                            @error('alamat')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid gap-4 sm:grid-cols-3">
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-2">RT</label>
                                <input type="text" name="rt" maxlength="3" value="{{ old('rt', $kartuKeluarga->rt) }}" placeholder="RT" class="w-full rounded-lg border border-slate-300 px-4 py-2 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 outline-none transition" />
                                @error('rt')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-2">RW</label>
                                <input type="text" name="rw" maxlength="3" value="{{ old('rw', $kartuKeluarga->rw) }}" placeholder="RW" class="w-full rounded-lg border border-slate-300 px-4 py-2 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 outline-none transition" />
                                @error('rw')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-2">Kode Pos</label>
                                <input type="text" name="kode_pos" maxlength="5" value="{{ old('kode_pos', $kartuKeluarga->kode_pos) }}" placeholder="Kode pos" class="w-full rounded-lg border border-slate-300 px-4 py-2 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 outline-none transition" />
                                @error('kode_pos')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="grid gap-4 sm:grid-cols-2">
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-2">Telepon</label>
                                <input type="text" name="telepon" value="{{ old('telepon', $kartuKeluarga->telepon) }}" placeholder="Nomor telepon" class="w-full rounded-lg border border-slate-300 px-4 py-2 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 outline-none transition" />
                                @error('telepon')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-2">Kelompok Sosial</label>
                                <select name="kelompok_sosial" class="w-full rounded-lg border border-slate-300 px-4 py-2 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 outline-none transition">
                                    <option value="">Pilih Kelompok Sosial</option>
                                    <option value="Miskin" {{ $kartuKeluarga->kelompok_sosial == 'Miskin' ? 'selected' : '' }}>Miskin</option>
                                    <option value="Rentan Miskin" {{ $kartuKeluarga->kelompok_sosial == 'Rentan Miskin' ? 'selected' : '' }}>Rentan Miskin</option>
                                    <option value="Menengah" {{ $kartuKeluarga->kelompok_sosial == 'Menengah' ? 'selected' : '' }}>Menengah</option>
                                    <option value="Mampu" {{ $kartuKeluarga->kelompok_sosial == 'Mampu' ? 'selected' : '' }}>Mampu</option>
                                </select>
                                @error('kelompok_sosial')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="grid gap-4 sm:grid-cols-2">
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-2">Tanggal Pembuatan</label>
                                <input type="date" name="tanggal_pembuatan" value="{{ old('tanggal_pembuatan', $kartuKeluarga->tanggal_pembuatan ? $kartuKeluarga->tanggal_pembuatan->format('Y-m-d') : '') }}" class="w-full rounded-lg border border-slate-300 px-4 py-2 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 outline-none transition" />
                                @error('tanggal_pembuatan')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-2">Tanggal Berlaku</label>
                                <input type="date" name="tanggal_berlaku" value="{{ old('tanggal_berlaku', $kartuKeluarga->tanggal_berlaku ? $kartuKeluarga->tanggal_berlaku->format('Y-m-d') : '') }}" class="w-full rounded-lg border border-slate-300 px-4 py-2 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 outline-none transition" />
                                @error('tanggal_berlaku')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">Catatan</label>
                            <textarea name="catatan" rows="2" placeholder="Catatan tambahan" class="w-full rounded-lg border border-slate-300 px-4 py-2 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 outline-none transition">{{ old('catatan', $kartuKeluarga->catatan) }}</textarea>
                            @error('catatan')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="flex items-center gap-2">
                                <input type="checkbox" name="is_active" value="1" {{ $kartuKeluarga->is_active ? 'checked' : '' }} class="rounded border-slate-300 text-emerald-600 focus:ring-emerald-500" />
                                <span class="text-sm text-slate-700">Kartu Keluarga Aktif</span>
                            </label>
                        </div>
                    </div>

                    <div class="flex items-center justify-end gap-4 mt-6">
                        <a href="{{ route('kartu-keluarga.show', $kartuKeluarga) }}" class="px-6 py-3 rounded-full border border-slate-300 text-slate-700 font-medium hover:bg-slate-50 transition">
                            Batal
                        </a>
                        <button type="submit" class="px-6 py-3 rounded-full bg-emerald-700 text-white font-medium shadow-glow hover:bg-emerald-600 transition">
                            Update Kartu Keluarga
                        </button>
                    </div>
                </form>
            </div>
        </main>
    </div>
</body>
</html>