<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Login — Nagari Koto Kaciak Barat</title>
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
    <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-emerald-50 to-slate-100">
        <div class="max-w-md w-full mx-4">
            <div class="bg-white rounded-2xl shadow-xl p-8">
                <div class="text-center mb-8">
                    <div class="inline-flex h-16 w-16 items-center justify-center rounded-2xl bg-emerald-100 text-emerald-700 ring-1 ring-emerald-200 mb-4">
                        <span class="text-3xl font-bold">N</span>
                    </div>
                    <h1 class="text-2xl font-bold text-slate-900">Nagari Koto Kaciak Barat</h1>
                    <p class="text-slate-500 mt-2">Sistem Informasi Kependudukan</p>
                </div>

                @if(session('error'))
                    <div class="bg-red-50 border border-red-200 rounded-xl p-4 mb-6">
                        <p class="text-red-700 text-sm">{{ session('error') }}</p>
                    </div>
                @endif

                @if(session('success'))
                    <div class="bg-emerald-50 border border-emerald-200 rounded-xl p-4 mb-6">
                        <p class="text-emerald-700 text-sm">{{ session('success') }}</p>
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Email</label>
                        <input type="email" name="email" required placeholder="email@example.com" class="w-full rounded-lg border border-slate-300 px-4 py-3 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 outline-none transition" />
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Password</label>
                        <input type="password" name="password" required placeholder="••••••••" class="w-full rounded-lg border border-slate-300 px-4 py-3 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 outline-none transition" />
                        @error('password')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit" class="w-full rounded-lg bg-emerald-700 px-4 py-3 text-white font-medium shadow-glow hover:bg-emerald-600 transition">
                        Login
                    </button>
                </form>

                <div class="mt-6 text-center">
                    <a href="{{ url('/') }}" class="text-sm text-slate-600 hover:text-emerald-700 transition">
                        ← Kembali ke Beranda
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>