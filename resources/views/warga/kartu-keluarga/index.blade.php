<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Data Kartu Keluarga — Nagari Koto Kaciak Barat</title>
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
                    @if(auth()->user()->isWaliJorong() && auth()->user()->jorong)
                        <span class="px-2 py-1 rounded-full bg-emerald-100 text-emerald-700 text-xs font-medium">
                            {{ auth()->user()->jorong->nama_jorong }}
                        </span>
                    @endif
                </nav>
            </div>
        </header>

        <main>
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-8">
                <div class="flex items-center justify-between mb-8">
                    <div>
                        <h1 class="text-3xl font-semibold tracking-tight text-slate-900">Data Kartu Keluarga</h1>
                        <p class="mt-2 text-slate-600">
                            @if(auth()->user()->isWaliJorong() && $currentJorong)
                                Kelola data kartu keluarga untuk Jorong: <strong>{{ $currentJorong->nama_jorong }}</strong>
                            @else
                                Kelola data kartu keluarga di Nagari Koto Kaciak Barat
                            @endif
                        </p>
                    </div>
                    <div class="flex gap-2">
                        <a href="{{ route('kartu-keluarga.create-wizard') }}" class="inline-flex items-center justify-center rounded-full bg-emerald-700 px-6 py-3 text-sm font-semibold text-white shadow-glow transition hover:bg-emerald-600">
                            + Tambah KK (Wizard)
                        </a>
                        <a href="{{ route('kartu-keluarga.create') }}" class="inline-flex items-center justify-center rounded-full border border-emerald-700 px-6 py-3 text-sm font-semibold text-emerald-700 transition hover:bg-emerald-50">
                            + Tambah KK Lama
                        </a>
                    </div>
                </div>

                <!-- Search and Filter -->
                <div class="bg-white rounded-2xl border border-slate-200 p-6 mb-6">
                    <form method="GET" action="{{ route('kartu-keluarga.index') }}" class="space-y-4">
                        <div class="grid gap-4 sm:grid-cols-3">
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-2">Cari KK</label>
                                <input type="text" name="search" value="{{ request('search') }}" placeholder="No. KK atau Kepala Keluarga..." class="w-full rounded-lg border border-slate-300 px-4 py-2 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 outline-none transition" />
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-2">Jorong</label>
                                <select name="jorong_id" class="w-full rounded-lg border border-slate-300 px-4 py-2 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 outline-none transition">
                                    <option value="">Semua Jorong</option>
                                    @foreach($jorongs as $jorong)
                                        <option value="{{ $jorong->id }}" {{ request('jorong_id') == $jorong->id ? 'selected' : '' }}>{{ $jorong->nama_jorong }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="flex items-end">
                                <button type="submit" class="w-full rounded-lg bg-emerald-700 px-4 py-2 text-white font-medium hover:bg-emerald-600 transition">
                                    Cari
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-slate-50 border-b border-slate-200">
                                <tr>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-slate-600 uppercase">No. KK</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-slate-600 uppercase">Kepala Keluarga</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-slate-600 uppercase">Jorong</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-slate-600 uppercase">Alamat</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-slate-600 uppercase">Jumlah Anggota</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-slate-600 uppercase">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-200">
                                @forelse($kartuKeluargas as $kk)
                                    <tr class="hover:bg-slate-50 transition">
                                        <td class="px-6 py-4 font-mono font-medium text-slate-900">{{ $kk->nomor_kk }}</td>
                                        <td class="px-6 py-4 font-medium text-slate-900">{{ $kk->nama_kepala_keluarga }}</td>
                                        <td class="px-6 py-4 text-slate-700">{{ $kk->jorong->nama_jorong ?? '-' }}</td>
                                        <td class="px-6 py-4 text-slate-700">{{ $kk->alamat }}</td>
                                        <td class="px-6 py-4 text-slate-700">{{ $kk->jumlah_anggota }}</td>
                                        <td class="px-6 py-4">
                                            <div class="flex items-center gap-2">
                                                <a href="{{ route('kartu-keluarga.show', $kk) }}" class="text-emerald-600 hover:text-emerald-700 font-medium">Lihat</a>
                                                <a href="{{ route('kartu-keluarga.edit', $kk) }}" class="text-slate-600 hover:text-slate-700">Edit</a>
                                                <a href="{{ route('warga.create', ['kk_id' => $kk->id]) }}" class="text-blue-600 hover:text-blue-700">+ Warga</a>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-12 text-center text-slate-500">
                                            <p class="text-lg font-medium">Belum ada data kartu keluarga</p>
                                            <p class="text-sm">Mulai dengan menambahkan kartu keluarga baru</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    @if($kartuKeluargas->hasPages())
                        <div class="px-6 py-4 border-t border-slate-200">
                            {{ $kartuKeluargas->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </main>
    </div>
</body>
</html>