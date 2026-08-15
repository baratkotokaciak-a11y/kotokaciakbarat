<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Data Nagari Dashboard</title>
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css'])
    @else
        <style>
            html { scroll-behavior: smooth; }
            body { font-family: 'Inter', ui-sans-serif, system-ui, sans-serif; background: linear-gradient(135deg, #f0f4f8, #d9e2ec); color: #1e293b; }
            .card { background: white; border-radius: 1.5rem; padding: 2rem; box-shadow: 0 10px 30px rgba(15,23,42,.08); margin-bottom: 1.5rem; }
            .badge { display: inline-flex; align-items: center; padding: .4rem .75rem; background: #e0f2fe; color: #0284c7; border-radius: 9999px; font-size: .75rem; text-transform: uppercase; letter-spacing:.12em; }
            .stat-number { font-size: 2.5rem; font-weight: 600; color: #0f172a; }
            .stat-label { font-size: .875rem; color: #64748b; }
            .button { display: inline-flex; align-items: center; justify-content: center; gap: .5rem; padding: .8rem 1.5rem; border-radius: 9999px; background: #0284c7; color: white; font-weight: 600; border: none; cursor: pointer; text-decoration: none; }
        </style>
    @endif
</head>
<body>
    <div class="max-w-7xl mx-auto p-6">
        <header class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="badge">Admin Panel</p>
                <h1 class="mt-3 text-3xl font-semibold">Dashboard Data Nagari</h1>
                <p class="mt-2 text-slate-600 max-w-2xl">Ringkasan statistik utama dan pesan masuk dari pengunjung.</p>
            </div>
            <a href="{{ url('/') }}" class="button" style="background:#64748b;">Lihat Halaman Publik</a>
        </header>

        <section class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="card text-center">
                <p class="stat-number">{{ $totalWarga }}</p>
                <p class="stat-label">Total Warga</p>
            </div>
            <div class="card text-center">
                <p class="stat-number">{{ $totalKK }}</p>
                <p class="stat-label">Total Kartu Keluarga</p>
            </div>
            <div class="card text-center">
                <p class="stat-number">{{ $totalJorong }}</p>
                <p class="stat-label">Total Jorong</p>
            </div>
        </section>

        <section class="card">
            <h2 class="text-2xl font-semibold mb-4">Pesan Kontak</h2>
            @if(isset($messages) && $messages->count())
                <ul class="space-y-4">
                    @foreach($messages as $msg)
                        <li class="border-b pb-2">
                            <div class="flex justify-between items-center">
                                <span class="font-medium">{{ $msg->name }} &lt;{{ $msg->email }}&gt;</span>
                                <span class="text-sm text-slate-500">{{ $msg->created_at->format('d M Y, H:i') }}</span>
                            </div>
                            <p class="mt-1 text-slate-700">{{ $msg->message }}</p>
                        </li>
                    @endforeach
                </ul>
            @else
                <p class="text-slate-600">Tidak ada pesan terbaru.</p>
            @endif
        </section>
    </div>
</body>
</html>
