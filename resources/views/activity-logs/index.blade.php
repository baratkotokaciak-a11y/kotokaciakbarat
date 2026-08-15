<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Log Aktivitas — Nagari Koto Kaciak Barat</title>
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
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-8">
                <div class="flex items-center justify-between mb-8">
                    <div>
                        <h1 class="text-3xl font-semibold tracking-tight text-slate-900">Log Aktivitas</h1>
                        <p class="mt-2 text-slate-600">Pantau semua aktivitas yang terjadi di sistem</p>
                    </div>
                </div>

                <!-- Filters -->
                <div class="bg-white rounded-2xl border border-slate-200 p-6 mb-6">
                    <form method="GET" action="{{ route('activity-logs.index') }}" class="space-y-4">
                        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-2">Cari</label>
                                <input type="text" name="search" value="{{ request('search') }}" placeholder="Deskripsi aktivitas..." class="w-full rounded-lg border border-slate-300 px-4 py-2 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 outline-none transition" />
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-2">Aksi</label>
                                <select name="action" class="w-full rounded-lg border border-slate-300 px-4 py-2 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 outline-none transition">
                                    <option value="">Semua Aksi</option>
                                    @foreach($actionTypes as $actionType)
                                        <option value="{{ $actionType }}" {{ request('action') == $actionType ? 'selected' : '' }}>{{ ucfirst($actionType) }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-2">User</label>
                                <select name="user_id" class="w-full rounded-lg border border-slate-300 px-4 py-2 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 outline-none transition">
                                    <option value="">Semua User</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="flex items-end gap-2">
                                <button type="submit" class="flex-1 rounded-lg bg-emerald-700 px-4 py-2 text-white font-medium hover:bg-emerald-600 transition">
                                    Filter
                                </button>
                                <a href="{{ route('activity-logs.index') }}" class="px-4 py-2 rounded-lg border border-slate-300 text-slate-700 font-medium hover:bg-slate-50 transition">
                                    Reset
                                </a>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Activity Logs Table -->
                <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-slate-50 border-b border-slate-200">
                                <tr>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-slate-600 uppercase">Waktu</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-slate-600 uppercase">User</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-slate-600 uppercase">Aksi</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-slate-600 uppercase">Deskripsi</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-slate-600 uppercase">IP Address</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-slate-600 uppercase">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-200">
                                @forelse($activityLogs as $log)
                                    <tr class="hover:bg-slate-50 transition">
                                        <td class="px-6 py-4 text-slate-700 text-sm">
                                            {{ $log->created_at->format('d M Y, H:i') }}
                                        </td>
                                        <td class="px-6 py-4">
                                            @if($log->user)
                                                <div class="font-medium text-slate-900">{{ $log->user->name }}</div>
                                                <div class="text-sm text-slate-500">{{ $log->user->email }}</div>
                                            @else
                                                <span class="text-slate-500">-</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4">
                                            @php
                                                $actionColors = [
                                                    'create' => 'bg-emerald-100 text-emerald-700',
                                                    'update' => 'bg-blue-100 text-blue-700',
                                                    'delete' => 'bg-red-100 text-red-700',
                                                    'login' => 'bg-purple-100 text-purple-700',
                                                    'logout' => 'bg-gray-100 text-gray-700',
                                                ];
                                                $color = $actionColors[$log->action] ?? 'bg-gray-100 text-gray-700';
                                            @endphp
                                            <span class="px-2 py-1 rounded-full {{ $color }} text-xs font-medium">
                                                {{ ucfirst($log->action) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-slate-700 text-sm max-w-md truncate" title="{{ $log->description }}">
                                            {{ $log->description }}
                                        </td>
                                        <td class="px-6 py-4 text-slate-500 text-sm font-mono">
                                            {{ $log->ip_address ?? '-' }}
                                        </td>
                                        <td class="px-6 py-4">
                                            <a href="{{ route('activity-logs.show', $log) }}" class="text-emerald-600 hover:text-emerald-700 font-medium text-sm">Detail</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-12 text-center text-slate-500">
                                            <p class="text-lg font-medium">Belum ada log aktivitas</p>
                                            <p class="text-sm">Aktivitas sistem akan muncul di sini</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    @if($activityLogs->hasPages())
                        <div class="px-6 py-4 border-t border-slate-200">
                            {{ $activityLogs->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </main>
    </div>
</body>
</html>