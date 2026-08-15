<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Edit User — Nagari Koto Kaciak Barat</title>
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
            <div class="mx-auto max-w-2xl px-4 sm:px-6 lg:px-8 py-8">
                <div class="mb-8">
                    <div class="flex items-center gap-4 mb-4">
                        <a href="{{ route('users.index') }}" class="text-slate-600 hover:text-emerald-700 transition">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                        </a>
                        <h1 class="text-2xl font-semibold tracking-tight text-slate-900">Edit User</h1>
                    </div>
                    <p class="text-slate-600">Edit data user: <strong>{{ $user->name }}</strong></p>
                </div>

                <form method="POST" action="{{ route('users.update', $user) }}" class="bg-white rounded-2xl border border-slate-200 p-6">
                    @csrf
                    @method('PUT')

                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">Nama <span class="text-red-500">*</span></label>
                            <input type="text" name="name" required value="{{ old('name', $user->name) }}" placeholder="Nama lengkap" class="w-full rounded-lg border border-slate-300 px-4 py-2 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 outline-none transition" />
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">Email <span class="text-red-500">*</span></label>
                            <input type="email" name="email" required value="{{ old('email', $user->email) }}" placeholder="email@example.com" class="w-full rounded-lg border border-slate-300 px-4 py-2 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 outline-none transition" />
                            @error('email')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">Password</label>
                            <input type="password" name="password" placeholder="Kosongkan jika tidak ingin mengubah" class="w-full rounded-lg border border-slate-300 px-4 py-2 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 outline-none transition" />
                            @error('password')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">Konfirmasi Password</label>
                            <input type="password" name="password_confirmation" placeholder="Ulangi password baru" class="w-full rounded-lg border border-slate-300 px-4 py-2 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 outline-none transition" />
                            @error('password_confirmation')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">Role <span class="text-red-500">*</span></label>
                            <select name="role" required id="role" class="w-full rounded-lg border border-slate-300 px-4 py-2 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 outline-none transition">
                                <option value="">Pilih Role</option>
                                <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                                <option value="wali_nagari" {{ $user->role === 'wali_nagari' ? 'selected' : '' }}>Wali Nagari</option>
                                <option value="wali_jorong" {{ $user->role === 'wali_jorong' ? 'selected' : '' }}>Wali Jorong</option>
                                <option value="news_editor" {{ $user->role === 'news_editor' ? 'selected' : '' }}>News Editor</option>
                            </select>
                            @error('role')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div id="jorong_container" class="{{ $user->role === 'wali_jorong' ? '' : 'hidden' }}">
                            <label class="block text-sm font-medium text-slate-700 mb-2">Jorong <span class="text-red-500">*</span></label>
                            <select name="jorong_id" class="w-full rounded-lg border border-slate-300 px-4 py-2 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 outline-none transition">
                                <option value="">Pilih Jorong</option>
                                @foreach($jorongs as $jorong)
                                    <option value="{{ $jorong->id }}" {{ $user->jorong_id == $jorong->id ? 'selected' : '' }}>{{ $jorong->nama_jorong }}</option>
                                @endforeach
                            </select>
                            @error('jorong_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">Telepon</label>
                            <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" placeholder="Nomor telepon" class="w-full rounded-lg border border-slate-300 px-4 py-2 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 outline-none transition" />
                            @error('phone')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="flex items-center justify-end gap-4 mt-6">
                        <a href="{{ route('users.index') }}" class="px-6 py-3 rounded-full border border-slate-300 text-slate-700 font-medium hover:bg-slate-50 transition">
                            Batal
                        </a>
                        <button type="submit" class="px-6 py-3 rounded-full bg-emerald-700 text-white font-medium shadow-glow hover:bg-emerald-600 transition">
                            Update User
                        </button>
                    </div>
                </form>
            </div>
        </main>
    </div>

    <script>
        function toggleJorongField() {
            const role = document.getElementById('role').value;
            const jorongContainer = document.getElementById('jorong_container');
            if (role === 'wali_jorong') {
                jorongContainer.classList.remove('hidden');
            } else {
                jorongContainer.classList.add('hidden');
            }
        }

        document.getElementById('role').addEventListener('change', toggleJorongField);
        
        // Initialize on page load
        document.addEventListener('DOMContentLoaded', toggleJorongField);
    </script>
</body>
</html>