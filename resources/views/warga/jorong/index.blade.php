<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Data Jorong — Nagari Koto Kaciak Barat</title>
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
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-8">
                <div class="flex items-center justify-between mb-8">
                    <div>
                        <h1 class="text-3xl font-semibold tracking-tight text-slate-900">Data Jorong</h1>
                        <p class="mt-2 text-slate-600">Kelola data jorong di Nagari Koto Kaciak Barat</p>
                    </div>
                    <a href="{{ route('jorong.create') }}" class="inline-flex items-center justify-center rounded-full bg-emerald-700 px-6 py-3 text-sm font-semibold text-white shadow-glow transition hover:bg-emerald-600">
                        + Tambah Jorong
                    </a>
                </div>

                <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-slate-50 border-b border-slate-200">
                                <tr>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-slate-600 uppercase">Nama Jorong</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-slate-600 uppercase">Ketua Jorong</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-slate-600 uppercase">Jumlah KK</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-slate-600 uppercase">Jumlah Warga</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-slate-600 uppercase">Status</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-slate-600 uppercase">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-200">
                                @forelse($jorongs as $jorong)
                                    <tr class="hover:bg-slate-50 transition">
                                        <td class="px-6 py-4 font-medium text-slate-900">{{ $jorong->nama_jorong }}</td>
                                        <td class="px-6 py-4 text-slate-700">{{ $jorong->nama_ketua_jorong ?? '-' }}</td>
                                        <td class="px-6 py-4 text-slate-700">{{ $jorong->jumlah_kk }}</td>
                                        <td class="px-6 py-4 text-slate-700">{{ $jorong->jumlah_warga }}</td>
                                        <td class="px-6 py-4">
                                            @if($jorong->is_active)
                                                <span class="px-2 py-1 rounded-full bg-emerald-100 text-emerald-700 text-xs font-medium">Aktif</span>
                                            @else
                                                <span class="px-2 py-1 rounded-full bg-slate-100 text-slate-700 text-xs font-medium">Non-Aktif</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="flex items-center gap-2">
                                                <a href="{{ route('jorong.edit', $jorong) }}" class="text-emerald-600 hover:text-emerald-700 font-medium">Edit</a>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-12 text-center text-slate-500">
                                            <p class="text-lg font-medium">Belum ada data jorong</p>
                                            <p class="text-sm">Mulai dengan menambahkan jorong baru</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    @if($jorongs->hasPages())
                        <div class="px-6 py-4 border-t border-slate-200">
                            {{ $jorongs->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </main>
    </div>
</body>
</html>