<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Data Warga — Nagari Koto Kaciak Barat</title>
    <meta name="description" content="Sistem pencatatan data warga Nagari Koto Kaciak Barat" />
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
        .card-hover {
            transition: all 0.2s ease;
        }
        .card-hover:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
        }
        .status-badge {
            padding: 4px 12px;
            border-radius: 9999px;
            font-size: 12px;
            font-weight: 600;
        }
        .status-hidup { background: #dcfce7; color: #166534; }
        .status-wafat { background: #fee2e2; color: #991b1b; }
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
                    @if(auth()->user()->isWaliNagari())
                        <a href="{{ route('wali-nagari.dashboard') }}" class="text-emerald-700 font-semibold hover:text-emerald-800 transition">Dashboard Wali Nagari</a>
                    @endif
@if(auth()->user()->isAdmin())
                        <a href="{{ route('admin.edit') }}" class="text-slate-600 hover:text-emerald-700 transition">Admin Panel</a>
                        <a href="{{ route('users.index') }}" class="text-slate-600 hover:text-emerald-700 transition">Manajemen User</a>
                        <a href="{{ route('apbn.edit') }}" class="inline-flex items-center gap-1.5 rounded-full bg-emerald-700 px-4 py-1.5 text-sm font-semibold text-white shadow-sm transition hover:bg-emerald-600">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 17v-2m3 2v-4m3 4v-6m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            Input APBN
                        </a>
                    @endif
                    <div class="flex items-center gap-4">
                        <span class="text-slate-600">{{ auth()->user()->name }}</span>
                        @if(auth()->user()->isAdmin())
                            <span class="px-2 py-1 rounded-full bg-purple-100 text-purple-700 text-xs font-medium">Admin</span>
                        @elseif(auth()->user()->isWaliNagari())
                            <span class="px-2 py-1 rounded-full bg-emerald-100 text-emerald-800 text-xs font-semibold border border-emerald-300">Wali Nagari</span>
                        @else
                            <span class="px-2 py-1 rounded-full bg-blue-100 text-blue-700 text-xs font-medium">Wali Jorong</span>
                        @endif
                        @if(auth()->user()->isWaliJorong() && auth()->user()->jorong)
                            <span class="px-2 py-1 rounded-full bg-emerald-100 text-emerald-700 text-xs font-medium">
                                {{ auth()->user()->jorong->nama_jorong }}
                            </span>
                        @endif
                        <form action="{{ route('logout') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="text-slate-600 hover:text-red-600 transition">Logout</button>
                        </form>
                    </div>
                </nav>
            </div>
        </header>

        <main>
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-8">
                <!-- Page Header -->
                <div class="mb-8">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                        <div>
                            <h1 class="text-3xl font-semibold tracking-tight text-slate-900">Data Warga</h1>
                            <p class="mt-2 text-slate-600">
                                @if(auth()->user()->isWaliJorong() && $currentJorong)
                                    Kelola data kependudukan untuk Jorong: <strong>{{ $currentJorong->nama_jorong }}</strong>
                                @else
                                    Kelola data kependudukan Nagari Koto Kaciak Barat
                                @endif
                            </p>
                        </div>
                        <a href="{{ route('warga.create') }}" class="inline-flex items-center justify-center rounded-full bg-emerald-700 px-6 py-3 text-sm font-semibold text-white shadow-glow transition hover:bg-emerald-600">
                            <svg class="mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                            Tambah Warga
                        </a>
                    </div>
                </div>

                <!-- Quick Stats -->
                <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4 mb-8">
                    <div class="rounded-2xl bg-gradient-to-br from-emerald-50 to-emerald-100 p-6 border border-emerald-200">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-emerald-600">Total Warga</p>
                                <p class="mt-2 text-3xl font-bold text-emerald-700">{{ $wargas->total() }}</p>
                            </div>
                            <div class="h-12 w-12 rounded-xl bg-emerald-200 flex items-center justify-center">
                                <svg class="h-6 w-6 text-emerald-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                    <div class="rounded-2xl bg-gradient-to-br from-blue-50 to-blue-100 p-6 border border-blue-200">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-blue-600">Warga Hidup</p>
                                <p class="mt-2 text-3xl font-bold text-blue-700">{{ App\Models\Warga::hidup()->count() }}</p>
                            </div>
                            <div class="h-12 w-12 rounded-xl bg-blue-200 flex items-center justify-center">
                                <svg class="h-6 w-6 text-blue-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                    <div class="rounded-2xl bg-gradient-to-br from-red-50 to-red-100 p-6 border border-red-200">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-red-600">Warga Wafat</p>
                                <p class="mt-2 text-3xl font-bold text-red-700">{{ App\Models\Warga::wafat()->count() }}</p>
                            </div>
                            <div class="h-12 w-12 rounded-xl bg-red-200 flex items-center justify-center">
                                <svg class="h-6 w-6 text-red-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                    <div class="rounded-2xl bg-gradient-to-br from-purple-50 to-purple-100 p-6 border border-purple-200">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-purple-600">Total KK</p>
                                <p class="mt-2 text-3xl font-bold text-purple-700">{{ App\Models\KartuKeluarga::count() }}</p>
                            </div>
                            <div class="h-12 w-12 rounded-xl bg-purple-200 flex items-center justify-center">
                                <svg class="h-6 w-6 text-purple-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Search and Filter -->
                <div class="bg-white rounded-2xl border border-slate-200 p-6 mb-6">
                    <form method="GET" action="{{ route('warga.index') }}" class="space-y-4">
                        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-2">Cari Warga</label>
                                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari Nama Warga..." class="w-full rounded-lg border border-slate-300 px-4 py-2 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 outline-none transition" />
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-2">Jorong</label>
                                <select name="jorong_id" class="w-full rounded-lg border border-slate-300 px-4 py-2 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 outline-none transition">
                                    <option value="">Semua Jorong</option>
                                    @foreach(auth()->user()->getAccessibleJorongs() as $jorong)
                                        <option value="{{ $jorong->id }}" {{ request('jorong_id') == $jorong->id ? 'selected' : '' }}>{{ $jorong->nama_jorong }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-2">Status</label>
                                <select name="status" class="w-full rounded-lg border border-slate-300 px-4 py-2 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 outline-none transition">
                                    <option value="">Semua Status</option>
                                    <option value="hidup" {{ request('status') == 'hidup' ? 'selected' : '' }}>Hidup</option>
                                    <option value="wafat" {{ request('status') == 'wafat' ? 'selected' : '' }}>Wafat</option>
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

                <!-- Data Table -->
                <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-slate-50 border-b border-slate-200">
                                <tr>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">Nama Lengkap</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">Jorong</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-200">
                                @forelse($wargas as $warga)
                                    <tr class="hover:bg-slate-50 transition">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-slate-900">{{ $warga->nama_lengkap }}</div>
                                            @if($warga->nama_panggilan)
                                                <div class="text-xs text-slate-500">"{{ $warga->nama_panggilan }}"</div>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-700">
                                            {{ $warga->kartuKeluarga->jorong->nama_jorong ?? '-' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($warga->is_wafat)
                                                <span class="status-badge status-wafat">Wafat</span>
                                            @else
                                                <span class="status-badge status-hidup">Hidup</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                                            <div class="flex items-center gap-2">
                                                <a href="{{ route('warga.show', $warga) }}" class="text-emerald-600 hover:text-emerald-700 font-medium">Lihat</a>
                                                <a href="{{ route('warga.edit', $warga) }}" class="text-slate-600 hover:text-slate-700">Edit</a>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-12 text-center text-slate-500">
                                            <div class="flex flex-col items-center">
                                                <svg class="h-12 w-12 text-slate-300 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                                </svg>
                                                <p class="text-lg font-medium">Belum ada data warga</p>
                                                <p class="text-sm">Mulai dengan menambahkan data warga baru</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    @if($wargas->hasPages())
                        <div class="px-6 py-4 border-t border-slate-200 flex items-center justify-between">
                            <div class="text-sm text-slate-600">
                                Menampilkan {{ $wargas->firstItem() }}-{{ $wargas->lastItem() }} dari {{ $wargas->total() }} data
                            </div>
                            {{ $wargas->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </main>
    </div>
</body>
</html>