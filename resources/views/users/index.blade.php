<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Manajemen User — Nagari Koto Kaciak Barat</title>
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
                    <a href="{{ route('warga.index') }}" class="text-slate-600 hover:text-emerald-700 transition">Data Warga</a>
                    <a href="{{ route('users.index') }}" class="text-emerald-700 font-medium">Manajemen User</a>
                    <a href="{{ route('activity-logs.index') }}" class="text-slate-600 hover:text-emerald-700 transition">Log Aktivitas</a>
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
                        <h1 class="text-3xl font-semibold tracking-tight text-slate-900">Manajemen User</h1>
                        <p class="mt-2 text-slate-600">Kelola akses pengguna sistem</p>
                    </div>
                    <a href="{{ route('users.create') }}" class="inline-flex items-center justify-center rounded-full bg-emerald-700 px-6 py-3 text-sm font-semibold text-white shadow-glow transition hover:bg-emerald-600">
                        + Tambah User
                    </a>
                </div>

                <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-slate-50 border-b border-slate-200">
                                <tr>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-slate-600 uppercase">Nama</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-slate-600 uppercase">Email</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-slate-600 uppercase">Role</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-slate-600 uppercase">Jorong</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-slate-600 uppercase">Telepon</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-slate-600 uppercase">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-200">
                                @forelse($users as $user)
                                    <tr class="hover:bg-slate-50 transition">
                                        <td class="px-6 py-4 font-medium text-slate-900">{{ $user->name }}</td>
                                        <td class="px-6 py-4 text-slate-700">{{ $user->email }}</td>
                                        <td class="px-6 py-4">
                                            @if($user->role === 'admin')
                                                <span class="px-2 py-1 rounded-full bg-purple-100 text-purple-700 text-xs font-medium">Admin</span>
                                            @elseif($user->role === 'wali_nagari')
                                                <span class="px-2 py-1 rounded-full bg-emerald-100 text-emerald-800 text-xs font-semibold border border-emerald-300">Wali Nagari</span>
                                            @elseif($user->role === 'news_editor')
                                                <span class="px-2 py-1 rounded-full bg-orange-100 text-orange-800 text-xs font-medium">News Editor</span>
                                            @else
                                                <span class="px-2 py-1 rounded-full bg-blue-100 text-blue-700 text-xs font-medium">Wali Jorong</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-slate-700">{{ $user->jorong->nama_jorong ?? '-' }}</td>
                                        <td class="px-6 py-4 text-slate-700">{{ $user->phone ?? '-' }}</td>
                                        <td class="px-6 py-4">
                                            <div class="flex items-center gap-2">
                                                <a href="{{ route('users.edit', $user) }}" class="text-emerald-600 hover:text-emerald-700 font-medium">Edit</a>
                                                @if(auth()->id() !== $user->id)
                                                    <form action="{{ route('users.destroy', $user) }}" method="POST" class="inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-red-600 hover:text-red-700 font-medium ml-2" onclick="return confirm('Yakin ingin menghapus user ini?')">Hapus</button>
                                                    </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-12 text-center text-slate-500">
                                            <p class="text-lg font-medium">Belum ada user</p>
                                            <p class="text-sm">Mulai dengan menambahkan user baru</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    @if($users->hasPages())
                        <div class="px-6 py-4 border-t border-slate-200">
                            {{ $users->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </main>
    </div>
</body>
</html>