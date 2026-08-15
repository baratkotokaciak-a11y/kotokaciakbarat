<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Detail Log Aktivitas — Nagari Koto Kaciak Barat</title>
    <link rel="preconnect" href="https://fonts.bunny.net" />
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <style>
            /*! tailwindcss v4.0.7 | MIT License | https://tailwindcss.com */@layer theme{:root,:host{--font-sans:'Instrument Sans',ui-sans-serif,system-ui,sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol","Noto Color Emoji";--font-serif:ui-serif:Georgia,Cambria,"Times New Roman",Times,serif;--font-mono:ui-monospace,SFMono-Regular,Menlo,Monaco,Consolas,"Liberation Mono","Courier New",monospace;}}
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
                    <a href="{{ route('warga.index') }}" class="text-slate-600 hover:text-emerald-700 transition">Data Warga</a>
                    <a href="{{ route('kartu-keluarga.index') }}" class="text-slate-600 hover:text-emerald-700 transition">Kartu Keluarga</a>
                    <a href="{{ route('jorong.index') }}" class="text-slate-600 hover:text-emerald-700 transition">Jorong</a>
                    <a href="{{ route('users.index') }}" class="text-slate-600 hover:text-emerald-700 transition">Manajemen User</a>
                    <a href="{{ route('activity-logs.index') }}" class="text-emerald-700 font-medium">Log Aktivitas</a>
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="text-slate-600 hover:text-emerald-700 transition">Logout</button>
                    </form>
                </nav>
            </div>
        </header>

        <main>
            <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8 py-8">
                <div class="mb-8">
                    <div class="flex items-center gap-4 mb-4">
                        <a href="{{ route('activity-logs.index') }}" class="text-slate-600 hover:text-emerald-700 transition">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                        </a>
                        <h1 class="text-2xl font-semibold tracking-tight text-slate-900">Detail Log Aktivitas</h1>
                    </div>
                </div>

                <!-- Log Info Card -->
                <div class="bg-white rounded-2xl border border-slate-200 p-6 mb-6">
                    <div class="grid gap-6 sm:grid-cols-2">
                        <div>
                            <p class="text-sm text-slate-500 mb-1">Waktu</p>
                            <p class="font-medium">{{ $activityLog->created_at->format('d M Y, H:i:s') }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-slate-500 mb-1">User</p>
                            @if($activityLog->user)
                                <p class="font-medium">{{ $activityLog->user->name }}</p>
                                <p class="text-sm text-slate-500">{{ $activityLog->user->email }}</p>
                            @else
                                <p class="font-medium">-</p>
                            @endif
                        </div>
                        <div>
                            <p class="text-sm text-slate-500 mb-1">Aksi</p>
                            @php
                                $actionColors = [
                                    'create' => 'bg-emerald-100 text-emerald-700',
                                    'update' => 'bg-blue-100 text-blue-700',
                                    'delete' => 'bg-red-100 text-red-700',
                                    'login' => 'bg-purple-100 text-purple-700',
                                    'logout' => 'bg-gray-100 text-gray-700',
                                ];
                                $color = $actionColors[$activityLog->action] ?? 'bg-gray-100 text-gray-700';
                            @endphp
                            <span class="px-2 py-1 rounded-full {{ $color }} text-xs font-medium">
                                {{ ucfirst($activityLog->action) }}
                            </span>
                        </div>
                        <div>
                            <p class="text-sm text-slate-500 mb-1">IP Address</p>
                            <p class="font-medium font-mono">{{ $activityLog->ip_address ?? '-' }}</p>
                        </div>
                        <div class="sm:col-span-2">
                            <p class="text-sm text-slate-500 mb-1">Deskripsi</p>
                            <p class="font-medium">{{ $activityLog->description }}</p>
                        </div>
                        @if($activityLog->model_type)
                        <div class="sm:col-span-2">
                            <p class="text-sm text-slate-500 mb-1">Model</p>
                            <p class="font-medium">{{ class_basename($activityLog->model_type) }} #{{ $activityLog->model_id }}</p>
                        </div>
                        @endif
                        @if($activityLog->user_agent)
                        <div class="sm:col-span-2">
                            <p class="text-sm text-slate-500 mb-1">User Agent</p>
                            <p class="font-medium text-sm text-slate-600">{{ $activityLog->user_agent }}</p>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Old Values -->
                @if($activityLog->old_values)
                <div class="bg-white rounded-2xl border border-slate-200 p-6 mb-6">
                    <h3 class="text-lg font-semibold text-slate-900 mb-4">Nilai Lama</h3>
                    <div class="bg-slate-50 rounded-xl p-4">
                        <pre class="text-sm text-slate-700 overflow-x-auto">{{ json_encode($activityLog->old_values, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                    </div>
                </div>
                @endif

                <!-- New Values -->
                @if($activityLog->new_values)
                <div class="bg-white rounded-2xl border border-slate-200 p-6 mb-6">
                    <h3 class="text-lg font-semibold text-slate-900 mb-4">Nilai Baru</h3>
                    <div class="bg-slate-50 rounded-xl p-4">
                        <pre class="text-sm text-slate-700 overflow-x-auto">{{ json_encode($activityLog->new_values, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                    </div>
                </div>
                @endif

                <!-- Action Buttons -->
                <div class="flex items-center justify-between">
                    <a href="{{ route('activity-logs.index') }}" class="px-6 py-3 rounded-full border border-slate-300 text-slate-700 font-medium hover:bg-slate-50 transition">
                        Kembali
                    </a>
                    <form action="{{ route('activity-logs.destroy', $activityLog) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus log aktivitas ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-6 py-3 rounded-full bg-red-600 text-white font-medium hover:bg-red-700 transition">
                            Hapus Log
                        </button>
                    </form>
                </div>
            </div>
        </main>
    </div>
</body>
</html>