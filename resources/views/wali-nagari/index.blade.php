<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Dashboard Executive — Wali Nagari Koto Kaciak Barat</title>
    <meta name="description" content="Dashboard Eksekutif dan Ringkasan Statistik Wali Nagari Koto Kaciak Barat" />
    <link rel="preconnect" href="https://fonts.bunny.net" />
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <style>
            /*! tailwindcss v4.0.7 | MIT License | https://tailwindcss.com */
            @layer theme{:root,:host{--font-sans:'Instrument Sans',ui-sans-serif,system-ui,sans-serif;}}
        </style>
    @endif
    <style>
        html { scroll-behavior: smooth; }
        .card-hover { transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1); }
        .card-hover:hover { transform: translateY(-3px); box-shadow: 0 12px 30px -10px rgba(4, 120, 87, 0.15); }
        .status-unread { background: #fee2e2; color: #991b1b; border: 1px solid #fca5a5; }
        .status-read { background: #e0f2fe; color: #0369a1; border: 1px solid #7dd3fc; }
        .status-replied { background: #dcfce7; color: #166534; border: 1px solid #86efac; }
        .pulse-badge { animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite; }
        @keyframes pulse { 0%, 100% { opacity: 1; } 50% { opacity: 0.5; } }
    </style>
</head>
<body class="bg-slate-50 text-slate-900 font-sans antialiased min-h-screen">
    <div class="min-h-screen flex flex-col">
        <!-- Executive Header -->
        <header class="sticky top-0 z-30 border-b border-slate-200 bg-white/95 backdrop-blur-md shadow-sm">
            <div class="mx-auto flex max-w-7xl items-center justify-between px-4 py-3 sm:px-6 lg:px-8">
                <div class="flex items-center gap-4">
                    <a href="{{ url('/') }}" class="flex items-center gap-3">
                        <span class="inline-flex h-11 w-11 items-center justify-center rounded-2xl bg-gradient-to-br from-emerald-600 to-teal-800 text-white font-bold text-xl shadow-md ring-2 ring-emerald-500/20">
                            WN
                        </span>
                        <div>
                            <span class="block text-xs font-semibold uppercase tracking-wider text-emerald-700">Pemerintahan Nagari</span>
                            <span class="block text-base font-bold text-slate-900 leading-tight">Dashboard Wali Nagari</span>
                        </div>
                    </a>
                </div>

                <!-- Navigation Links -->
                <nav class="hidden lg:flex items-center gap-2 text-sm font-medium">
                    <a href="{{ route('wali-nagari.dashboard') }}" class="px-3 py-2 rounded-xl bg-emerald-50 text-emerald-700 font-semibold border border-emerald-200/60">
                        📊 Ringkasan Eksekutif
                    </a>
                    <a href="{{ route('wali-nagari.messages.index') }}" class="px-3 py-2 rounded-xl text-slate-600 hover:text-emerald-700 hover:bg-slate-100 transition relative">
                        ✉️ Pesan Kontak
                        @if($unreadMessagesCount > 0)
                            <span class="inline-flex items-center justify-center px-2 py-0.5 ml-1 text-xs font-bold leading-none text-white bg-red-600 rounded-full">
                                {{ $unreadMessagesCount }}
                            </span>
                        @endif
                    </a>
                    <a href="{{ route('warga.index') }}" class="px-3 py-2 rounded-xl text-slate-600 hover:text-emerald-700 hover:bg-slate-100 transition">
                        👥 Data Warga
                    </a>
                    <a href="{{ route('kartu-keluarga.index') }}" class="px-3 py-2 rounded-xl text-slate-600 hover:text-emerald-700 hover:bg-slate-100 transition">
                        🏠 Kartu Keluarga
                    </a>
                    <a href="{{ route('jorong.index') }}" class="px-3 py-2 rounded-xl text-slate-600 hover:text-emerald-700 hover:bg-slate-100 transition">
                        🗺️ Jorong
                    </a>
                    @if(auth()->user()->canViewActivityLogs())
                        <a href="{{ route('activity-logs.index') }}" class="px-3 py-2 rounded-xl text-slate-600 hover:text-emerald-700 hover:bg-slate-100 transition">
                            📜 Log Aktivitas
                        </a>
                    @endif
                </nav>

                <!-- User & Actions -->
                <div class="flex items-center gap-3">
                    <div class="hidden sm:flex flex-col text-right">
                        <span class="text-sm font-semibold text-slate-900">{{ auth()->user()->name }}</span>
                        <span class="text-xs text-emerald-700 font-medium">Wali Nagari Koto Kaciak Barat</span>
                    </div>
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl border border-slate-200 text-xs font-semibold text-slate-700 hover:bg-red-50 hover:text-red-600 hover:border-red-200 transition">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="flex-1 py-8 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto w-full">
            @if(session('success'))
                <div class="mb-6 rounded-2xl bg-emerald-50 border border-emerald-200 p-4 flex items-center justify-between text-emerald-800">
                    <div class="flex items-center gap-3">
                        <svg class="h-5 w-5 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span class="text-sm font-medium">{{ session('success') }}</span>
                    </div>
                    <button onclick="this.parentElement.remove()" class="text-emerald-600 hover:text-emerald-800">&times;</button>
                </div>
            @endif

            <!-- 1. Executive Briefing Banner -->
            <div class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-emerald-900 via-teal-900 to-slate-900 text-white p-6 sm:p-8 mb-8 shadow-xl">
                <div class="absolute -right-10 -bottom-10 w-80 h-80 bg-emerald-500/10 rounded-full blur-3xl pointer-events-none"></div>
                <div class="absolute right-40 top-0 w-60 h-60 bg-teal-400/10 rounded-full blur-2xl pointer-events-none"></div>
                
                <div class="relative z-10 grid gap-6 lg:grid-cols-3 items-center">
                    <div class="lg:col-span-2 space-y-3">
                        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-emerald-500/20 text-emerald-300 text-xs font-semibold border border-emerald-400/30">
                            <span class="w-2 h-2 rounded-full bg-emerald-400 pulse-badge"></span>
                            Executive Summary Kependudukan & Pelayanan Nagari
                        </div>
                        <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-white">
                            Selamat Datang, Bapak Wali Nagari
                        </h1>
                        <p class="text-slate-200 text-sm sm:text-base leading-relaxed">
                            Berikut adalah ringkasan eksekutif kondisi kependudukan, sebaran wilayah jorong, serta aspirasi dan pesan warga dari kanal publik <strong>Kontak Kami</strong> Nagari Koto Kaciak Barat.
                        </p>
                    </div>

                    <div class="bg-white/10 backdrop-blur-md rounded-2xl p-5 border border-white/10 space-y-3 text-sm">
                        <div class="flex items-center justify-between border-b border-white/10 pb-2">
                            <span class="text-slate-300">Total Kependudukan:</span>
                            <span class="font-bold text-emerald-300 text-lg">{{ number_format($summaryBrief['total_penduduk']) }} Warga</span>
                        </div>
                        <div class="flex items-center justify-between border-b border-white/10 pb-2">
                            <span class="text-slate-300">Proporsi Warga Tetap:</span>
                            <span class="font-bold text-teal-300">{{ $summaryBrief['persentase_tetap'] }}%</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-slate-300">Pesan Perlu Tindakan:</span>
                            <span class="font-bold {{ $summaryBrief['pesan_perlu_tindakan'] > 0 ? 'text-amber-300 font-extrabold' : 'text-slate-300' }}">
                                {{ $summaryBrief['pesan_perlu_tindakan'] }} Pesan Baru
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 2. Core KPI Cards Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
                <!-- KPI 1: Total Warga -->
                <div class="bg-white rounded-2xl p-6 border border-slate-200 card-hover shadow-sm flex flex-col justify-between">
                    <div class="flex items-center justify-between mb-4">
                        <span class="text-xs font-bold uppercase tracking-wider text-emerald-700 bg-emerald-50 px-2.5 py-1 rounded-lg">Kependudukan</span>
                        <div class="w-12 h-12 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </div>
                    </div>
                    <div>
                        <div class="text-3xl font-extrabold text-slate-900 mb-1">{{ number_format($totalWarga) }}</div>
                        <div class="text-xs text-slate-500 flex items-center gap-2">
                            <span class="text-emerald-600 font-semibold">● {{ number_format($wargaHidup) }} Hidup</span>
                            <span>•</span>
                            <span class="text-red-500 font-semibold">● {{ number_format($wargaWafat) }} Wafat</span>
                        </div>
                    </div>
                </div>

                <!-- KPI 2: Total KK -->
                <div class="bg-white rounded-2xl p-6 border border-slate-200 card-hover shadow-sm flex flex-col justify-between">
                    <div class="flex items-center justify-between mb-4">
                        <span class="text-xs font-bold uppercase tracking-wider text-blue-700 bg-blue-50 px-2.5 py-1 rounded-lg">Kartu Keluarga</span>
                        <div class="w-12 h-12 rounded-xl bg-blue-100 text-blue-700 flex items-center justify-center">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                            </svg>
                        </div>
                    </div>
                    <div>
                        <div class="text-3xl font-extrabold text-slate-900 mb-1">{{ number_format($totalKK) }}</div>
                        <div class="text-xs text-slate-500">
                            Tersebar di <span class="font-semibold text-slate-700">{{ $totalJorong }} Wilayah Jorong</span>
                        </div>
                    </div>
                </div>

                <!-- KPI 3: Status Penduduk -->
                <div class="bg-white rounded-2xl p-6 border border-slate-200 card-hover shadow-sm flex flex-col justify-between">
                    <div class="flex items-center justify-between mb-4">
                        <span class="text-xs font-bold uppercase tracking-wider text-purple-700 bg-purple-50 px-2.5 py-1 rounded-lg">Status Tinggal</span>
                        <div class="w-12 h-12 rounded-xl bg-purple-100 text-purple-700 flex items-center justify-center">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                        </div>
                    </div>
                    <div>
                        <div class="text-3xl font-extrabold text-slate-900 mb-1">{{ number_format($wargaTetap) }}</div>
                        <div class="text-xs text-slate-500">
                            Penduduk Tetap | <span class="text-purple-600 font-semibold">{{ number_format($wargaSementara) }} Pendatang/Sementara</span>
                        </div>
                    </div>
                </div>

                <!-- KPI 4: Pesan Kontak Masuk -->
                <div class="bg-white rounded-2xl p-6 border border-slate-200 card-hover shadow-sm flex flex-col justify-between">
                    <div class="flex items-center justify-between mb-4">
                        <span class="text-xs font-bold uppercase tracking-wider text-amber-700 bg-amber-50 px-2.5 py-1 rounded-lg">Pesan Publik</span>
                        <div class="w-12 h-12 rounded-xl bg-amber-100 text-amber-700 flex items-center justify-center relative">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            @if($unreadMessagesCount > 0)
                                <span class="absolute -top-1 -right-1 w-3.5 h-3.5 bg-red-600 rounded-full border-2 border-white"></span>
                            @endif
                        </div>
                    </div>
                    <div>
                        <div class="flex items-baseline gap-2">
                            <div class="text-3xl font-extrabold text-slate-900">{{ number_format($totalMessages) }}</div>
                            <div class="text-xs font-bold text-red-600">({{ $unreadMessagesCount }} Belum dibaca)</div>
                        </div>
                        <div class="text-xs text-slate-500 mt-1">
                            Aspirasi & Pertanyaan dari Publik
                        </div>
                    </div>
                </div>
            </div>

            <!-- 3. Demographic & Regional Breakdown Section -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
                <!-- Sebaran per Jorong (2 cols) -->
                <div class="lg:col-span-2 bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-sm">
                    <div class="flex items-center justify-between mb-6 border-b border-slate-100 pb-4">
                        <div>
                            <h2 class="text-lg font-bold text-slate-900">Sebaran Kependudukan per Jorong</h2>
                            <p class="text-xs text-slate-500">Distribusi jumlah warga dan Kepala Keluarga di setiap wilayah Jorong</p>
                        </div>
                        <a href="{{ route('jorong.index') }}" class="text-xs font-semibold text-emerald-700 hover:underline">Kelola Jorong &rarr;</a>
                    </div>

                    <div class="space-y-5">
                        @forelse($jorongStats as $stat)
                            <div class="space-y-1.5">
                                <div class="flex items-center justify-between text-sm">
                                    <div class="flex items-center gap-2">
                                        <span class="font-bold text-slate-800">{{ $stat['nama'] }}</span>
                                        <span class="text-xs px-2 py-0.5 rounded bg-slate-100 text-slate-600 font-mono">Kode: {{ $stat['kode'] }}</span>
                                    </div>
                                    <div class="text-xs text-slate-600">
                                        <span class="font-bold text-emerald-700">{{ number_format($stat['warga_count']) }} Warga</span>
                                        <span class="text-slate-400">({{ number_format($stat['kk_count']) }} KK)</span>
                                        <span class="font-semibold text-slate-800 ml-1">{{ $stat['percentage'] }}%</span>
                                    </div>
                                </div>
                                <div class="w-full bg-slate-100 h-3 rounded-full overflow-hidden">
                                    <div class="bg-gradient-to-r from-emerald-500 to-teal-600 h-full rounded-full transition-all duration-500" style="width: {{ max($stat['percentage'], 2) }}%"></div>
                                </div>
                            </div>
                        @empty
                            <p class="text-sm text-slate-500 italic">Belum ada data Jorong terdaftar.</p>
                        @endforelse
                    </div>
                </div>

                <!-- Gender & Residency Stats Summary (1 col) -->
                <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-sm flex flex-col justify-between">
                    <div>
                        <h2 class="text-lg font-bold text-slate-900 mb-1">Rasio Demografi</h2>
                        <p class="text-xs text-slate-500 mb-6">Komposisi Jenis Kelamin & Legalitas Tinggal</p>

                        <!-- Gender Ratio -->
                        <div class="space-y-4 mb-6">
                            <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Jenis Kelamin</span>
                            <div class="grid grid-cols-2 gap-3">
                                <div class="p-4 rounded-2xl bg-blue-50/60 border border-blue-100 text-center">
                                    <span class="block text-2xl font-black text-blue-700">{{ number_format($lakiLaki) }}</span>
                                    <span class="text-xs font-semibold text-blue-600">Laki-laki</span>
                                </div>
                                <div class="p-4 rounded-2xl bg-pink-50/60 border border-pink-100 text-center">
                                    <span class="block text-2xl font-black text-pink-700">{{ number_format($perempuan) }}</span>
                                    <span class="text-xs font-semibold text-pink-600">Perempuan</span>
                                </div>
                            </div>
                        </div>

                        <!-- Status Kependudukan -->
                        <div class="space-y-4">
                            <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Status Kependudukan</span>
                            <div class="space-y-2">
                                <div class="flex items-center justify-between text-xs p-3 rounded-xl bg-slate-50 border border-slate-100">
                                    <span class="font-medium text-slate-700">Penduduk Tetap Nagari</span>
                                    <span class="font-bold text-emerald-700">{{ number_format($wargaTetap) }} Warga</span>
                                </div>
                                <div class="flex items-center justify-between text-xs p-3 rounded-xl bg-slate-50 border border-slate-100">
                                    <span class="font-medium text-slate-700">Penduduk Sementara / Pendatang</span>
                                    <span class="font-bold text-purple-700">{{ number_format($wargaSementara) }} Warga</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-6 pt-4 border-t border-slate-100 text-center">
                        <a href="{{ route('warga.index') }}" class="inline-flex items-center gap-1 text-xs font-bold text-emerald-700 hover:text-emerald-800">
                            Kelola Seluruh Data Warga &rarr;
                        </a>
                    </div>
                </div>
            </div>

            <!-- 4. Public Contact Messages Section (TEMPAT PESAN KONTAK KAMI) -->
            <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-sm mb-8">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6 border-b border-slate-100 pb-4">
                    <div>
                        <div class="flex items-center gap-2">
                            <h2 class="text-xl font-bold text-slate-900">Pesanan & Aspirasi Masuk (Kontak Kami)</h2>
                            @if($unreadMessagesCount > 0)
                                <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-red-100 text-red-700 border border-red-200">
                                    {{ $unreadMessagesCount }} Belum Dibaca
                                </span>
                            @endif
                        </div>
                        <p class="text-xs text-slate-500 mt-1">Pesan, pertanyaan, dan pengaduan dari warga melalui halaman publik Kontak Kami Nagari</p>
                    </div>

                    <a href="{{ route('wali-nagari.messages.index') }}" class="inline-flex items-center justify-center px-4 py-2.5 rounded-xl bg-emerald-700 text-white text-xs font-bold hover:bg-emerald-600 transition shadow-sm">
                        📨 Lihat Semua Kotak Pesan ({{ $totalMessages }})
                    </a>
                </div>

                @if($recentMessages->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-slate-50 text-slate-500 text-xs font-bold uppercase tracking-wider border-b border-slate-200">
                                    <th class="py-3.5 px-4 rounded-l-xl">Pengirim</th>
                                    <th class="py-3.5 px-4">Subjek & Pesan</th>
                                    <th class="py-3.5 px-4">Waktu Terima</th>
                                    <th class="py-3.5 px-4">Status</th>
                                    <th class="py-3.5 px-4 text-right rounded-r-xl">Tindakan</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 text-sm">
                                @foreach($recentMessages as $msg)
                                    <tr class="hover:bg-slate-50/80 transition {{ $msg->isUnread() ? 'bg-amber-50/30 font-medium' : '' }}">
                                        <!-- Pengirim -->
                                        <td class="py-4 px-4 whitespace-nowrap">
                                            <div class="font-bold text-slate-900">{{ $msg->name }}</div>
                                            <div class="text-xs text-slate-500">{{ $msg->email }}</div>
                                            @if($msg->phone)
                                                <div class="text-xs font-mono text-emerald-700">{{ $msg->phone }}</div>
                                            @endif
                                        </td>

                                        <!-- Subjek & Pesan -->
                                        <td class="py-4 px-4 max-w-md">
                                            <div class="font-semibold text-slate-800 line-clamp-1">{{ $msg->subject ?? 'Pesan Publik' }}</div>
                                            <div class="text-xs text-slate-500 line-clamp-2 mt-0.5">{{ $msg->message }}</div>
                                        </td>

                                        <!-- Waktu -->
                                        <td class="py-4 px-4 whitespace-nowrap text-xs text-slate-500 font-mono">
                                            {{ $msg->created_at->format('d M Y, H:i') }}
                                        </td>

                                        <!-- Status -->
                                        <td class="py-4 px-4 whitespace-nowrap">
                                            @if($msg->status === 'unread')
                                                <span class="px-2.5 py-1 rounded-full text-xs font-bold status-unread inline-flex items-center gap-1">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-red-600"></span> Belum Dibaca
                                                </span>
                                            @elseif($msg->status === 'replied')
                                                <span class="px-2.5 py-1 rounded-full text-xs font-bold status-replied inline-flex items-center gap-1">
                                                    ✓ Dibalas
                                                </span>
                                            @else
                                                <span class="px-2.5 py-1 rounded-full text-xs font-semibold status-read inline-flex items-center gap-1">
                                                    Sudah Dibaca
                                                </span>
                                            @endif
                                        </td>

                                        <!-- Tindakan -->
                                        <td class="py-4 px-4 whitespace-nowrap text-right">
                                            <div class="flex items-center justify-end gap-2">
                                                <button onclick="openMessageModal({{ $msg->id }})" class="px-3 py-1.5 rounded-lg bg-slate-100 hover:bg-emerald-100 text-slate-700 hover:text-emerald-800 text-xs font-semibold transition">
                                                    Detail & Balas
                                                </button>

                                                <form action="{{ route('wali-nagari.messages.toggle-read', $msg) }}" method="POST" class="inline">
                                                    @csrf
                                                    <button type="submit" class="px-2.5 py-1.5 rounded-lg border border-slate-200 text-xs font-medium hover:bg-slate-100 text-slate-600 transition" title="Ubah status baca">
                                                        {{ $msg->isUnread() ? 'Tandai Dibaca' : 'Buka Kembali' }}
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="py-12 text-center text-slate-400">
                        <svg class="mx-auto h-12 w-12 text-slate-300 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                        </svg>
                        <p class="text-base font-semibold text-slate-600">Belum ada pesan kontak masuk</p>
                        <p class="text-xs text-slate-500">Pesan dari pengirim di bagian Kontak Kami akan ditampilkan secara otomatis di sini.</p>
                    </div>
                @endif
            </div>

            <!-- 5. Executive Activity Log Oversight -->
            @if($recentActivities->count() > 0)
                <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-sm">
                    <div class="flex items-center justify-between mb-6 border-b border-slate-100 pb-4">
                        <div>
                            <h2 class="text-lg font-bold text-slate-900">Aktivitas Sistem & Tata Kelola Nagari</h2>
                            <p class="text-xs text-slate-500">Pengawasan perubahan data oleh perangkat nagari</p>
                        </div>
                        <a href="{{ route('activity-logs.index') }}" class="text-xs font-semibold text-emerald-700 hover:underline">Log Selengkapnya &rarr;</a>
                    </div>

                    <div class="space-y-4">
                        @foreach($recentActivities as $log)
                            <div class="flex items-start gap-4 p-3 rounded-2xl hover:bg-slate-50 transition border border-transparent hover:border-slate-100 text-xs sm:text-sm">
                                <div class="w-8 h-8 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center font-bold text-xs shrink-0">
                                    {{ strtoupper(substr($log->user->name ?? 'S', 0, 1)) }}
                                </div>
                                <div class="flex-1">
                                    <div class="flex flex-wrap items-center justify-between gap-1">
                                        <span class="font-bold text-slate-900">{{ $log->user->name ?? 'Sistem' }}</span>
                                        <span class="text-xs text-slate-400 font-mono">{{ $log->created_at->diffForHumans() }}</span>
                                    </div>
                                    <p class="text-slate-600 mt-0.5">{{ $log->description }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </main>
    </div>

    <!-- Detail & Reply Modal -->
    <div id="messageModal" class="fixed inset-0 z-50 bg-slate-900/60 backdrop-blur-sm hidden flex items-center justify-center p-4">
        <div class="bg-white rounded-3xl max-w-2xl w-full p-6 sm:p-8 border border-slate-100 shadow-2xl relative max-h-[90vh] overflow-y-auto">
            <button onclick="closeMessageModal()" class="absolute top-5 right-5 w-8 h-8 rounded-full bg-slate-100 text-slate-500 hover:bg-slate-200 flex items-center justify-center font-bold text-lg transition">&times;</button>

            <div id="modalLoading" class="py-12 text-center">
                <div class="inline-block animate-spin rounded-full h-8 w-8 border-4 border-emerald-600 border-t-transparent"></div>
                <p class="text-xs text-slate-500 mt-2 font-medium">Memuat detail pesan...</p>
            </div>

            <div id="modalBody" class="hidden space-y-6">
                <div class="border-b border-slate-100 pb-4">
                    <span id="modalStatusBadge" class="px-2.5 py-0.5 rounded-full text-xs font-bold inline-block mb-2"></span>
                    <h3 id="modalSubject" class="text-xl font-bold text-slate-900"></h3>
                    <div class="mt-2 text-xs text-slate-500 flex flex-wrap items-center gap-x-4 gap-y-1">
                        <div>Dari: <strong id="modalName" class="text-slate-800"></strong> (<span id="modalEmail" class="text-emerald-700"></span>)</div>
                        <div id="modalPhoneContainer" class="hidden">No. Telp: <span id="modalPhone" class="font-mono text-slate-700"></span></div>
                        <div>Waktu: <span id="modalDate" class="font-mono text-slate-600"></span></div>
                    </div>
                </div>

                <div class="bg-slate-50 rounded-2xl p-4 border border-slate-200">
                    <h4 class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-2">Isi Pesan / Aspirasi:</h4>
                    <p id="modalContent" class="text-sm text-slate-800 leading-relaxed whitespace-pre-line"></p>
                </div>

                <!-- Form Balasan / Catatan Tindak Lanjut -->
                <form id="replyForm" method="POST" action="" class="space-y-3 pt-2 border-t border-slate-100">
                    @csrf
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700">
                        Catatan Balasan / Tindak Lanjut Wali Nagari:
                    </label>
                    <textarea id="modalReplyNotes" name="reply_notes" rows="4" required placeholder="Tuliskan catatan tindak lanjut atau arahan untuk disposisi pesan ini..." class="w-full rounded-2xl border border-slate-300 p-3.5 text-sm focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 outline-none transition"></textarea>

                    <div class="flex items-center justify-end gap-3 pt-2">
                        <button type="button" onclick="closeMessageModal()" class="px-5 py-2.5 rounded-xl border border-slate-200 text-xs font-semibold text-slate-700 hover:bg-slate-100 transition">
                            Tutup
                        </button>
                        <button type="submit" class="px-5 py-2.5 rounded-xl bg-emerald-700 hover:bg-emerald-600 text-white text-xs font-bold shadow-sm transition">
                            Simpan Tindak Lanjut / Balasan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function openMessageModal(id) {
            const modal = document.getElementById('messageModal');
            const loading = document.getElementById('modalLoading');
            const body = document.getElementById('modalBody');

            modal.classList.remove('hidden');
            loading.classList.remove('hidden');
            body.classList.add('hidden');

            fetch("{{ url('/wali-nagari/messages') }}/" + id)
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        const m = data.message;
                        document.getElementById('modalSubject').innerText = m.subject || 'Pesan dari Kontak Kami';
                        document.getElementById('modalName').innerText = m.name;
                        document.getElementById('modalEmail').innerText = m.email;
                        
                        if (m.phone) {
                            document.getElementById('modalPhone').innerText = m.phone;
                            document.getElementById('modalPhoneContainer').classList.remove('hidden');
                        } else {
                            document.getElementById('modalPhoneContainer').classList.add('hidden');
                        }

                        document.getElementById('modalDate').innerText = data.formatted_date;
                        document.getElementById('modalContent').innerText = m.message;
                        document.getElementById('modalReplyNotes').value = m.reply_notes || '';

                        const badge = document.getElementById('modalStatusBadge');
                        if (m.status === 'replied') {
                            badge.className = 'px-2.5 py-0.5 rounded-full text-xs font-bold status-replied';
                            badge.innerText = 'Dibalas / Ditindaklanjuti';
                        } else if (m.status === 'read') {
                            badge.className = 'px-2.5 py-0.5 rounded-full text-xs font-bold status-read';
                            badge.innerText = 'Sudah Dibaca';
                        } else {
                            badge.className = 'px-2.5 py-0.5 rounded-full text-xs font-bold status-unread';
                            badge.innerText = 'Belum Dibaca';
                        }

                        // set form action
                        document.getElementById('replyForm').action = "{{ url('/wali-nagari/messages') }}/" + id + "/reply";

                        loading.classList.add('hidden');
                        body.classList.remove('hidden');
                    }
                })
                .catch(err => {
                    alert('Gagal mengambil data pesan.');
                    closeMessageModal();
                });
        }

        function closeMessageModal() {
            document.getElementById('messageModal').classList.add('hidden');
        }
    </script>
</body>
</html>
