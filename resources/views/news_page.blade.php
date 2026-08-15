<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <title>Portal Berita — Nagari Koto Kaciak Barat</title>
        <meta name="description" content="Portal berita resmi Nagari Koto Kaciak Barat. Informasi terbaru, agenda, dan pengumuman nagari." />
        <meta property="og:title" content="Portal Berita Nagari Koto Kaciak Barat" />
        <meta property="og:description" content="Portal berita resmi Nagari Koto Kaciak Barat. Informasi terbaru, agenda, dan pengumuman nagari." />
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
            .hero-gradient {
                background-image: radial-gradient(circle at top left, rgba(4, 120, 87, 0.18), transparent 35%), radial-gradient(circle at bottom right, rgba(6, 182, 212, 0.2), transparent 30%);
            }
            .filter-pill {
                display: inline-flex;
                align-items: center;
                gap: 6px;
                padding: 8px 18px;
                border-radius: 9999px;
                background: #fff;
                border: 1px solid #e2e8f0;
                font-size: 13px;
                font-weight: 600;
                color: #475569;
                cursor: pointer;
                transition: all 0.2s;
            }
            .filter-pill:hover {
                border-color: #047857;
                color: #047857;
                background: #f0fdf4;
                transform: translateY(-1px);
            }
            .filter-pill.active {
                background: #047857;
                border-color: #047857;
                color: #fff;
                box-shadow: 0 4px 12px rgba(4,120,87,.2);
            }
            .filter-pill .count {
                background: rgba(0,0,0,.08);
                border-radius: 9999px;
                padding: 1px 8px;
                font-size: 11px;
            }
            .filter-pill.active .count { background: rgba(255,255,255,.2); }
            .search-box {
                display: flex;
                align-items: center;
                flex: 1 1 280px;
                max-width: 360px;
                background: #fff;
                border: 1px solid #e2e8f0;
                border-radius: 9999px;
                padding: 2px;
                transition: border-color 0.2s, box-shadow 0.2s;
            }
            .search-box:focus-within {
                border-color: #047857;
                box-shadow: 0 0 0 3px rgba(4,120,87,.1);
            }
            .search-box input {
                flex: 1;
                border: none;
                outline: none;
                padding: 10px 18px;
                font-size: 14px;
                background: transparent;
                color: #0f172a;
                min-width: 0;
            }
            .search-box input::placeholder { color: #94a3b8; }
            .search-box button {
                padding: 8px 18px;
                border-radius: 9999px;
                background: #047857;
                color: #fff;
                border: none;
                font-size: 13px;
                font-weight: 600;
                cursor: pointer;
                transition: background 0.2s;
            }
            .search-box button:hover { background: #065f46; }
            .spotlight-card {
                border-radius: 1.5rem;
                overflow: hidden;
                background: #fff;
                box-shadow: 0 4px 16px rgba(15,23,42,.06);
                transition: transform 0.25s ease, box-shadow 0.25s ease;
                display: flex;
                flex-direction: column;
                cursor: pointer;
                border: 1px solid rgba(148,163,184,.08);
            }
            .spotlight-card:hover {
                transform: translateY(-3px);
                box-shadow: 0 10px 30px rgba(15,23,42,.1);
            }
            .spotlight-card .spot-img-wrap img {
                transition: transform 0.4s ease;
            }
            .spotlight-card:hover .spot-img-wrap img { transform: scale(1.06); }
            .breaking-news {
                background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
                color: white;
                padding: 12px 0;
                position: relative;
                overflow: hidden;
            }
            .breaking-news .container {
                max-width: 1200px;
                margin: 0 auto;
                padding: 0 20px;
            }
            .breaking-news-inner {
                display: flex;
                align-items: center;
                gap: 16px;
            }
            .breaking-label {
                display: inline-flex;
                align-items: center;
                gap: 8px;
                background: rgba(255,255,255,0.2);
                padding: 8px 16px;
                border-radius: 8px;
                font-weight: 700;
                font-size: 14px;
                white-space: nowrap;
                text-transform: uppercase;
                letter-spacing: 0.5px;
            }
            .pulse-dot {
                width: 8px;
                height: 8px;
                background: white;
                border-radius: 50%;
                animation: pulse 1.5s ease-in-out infinite;
            }
            @keyframes pulse {
                0%, 100% { opacity: 1; transform: scale(1); }
                50% { opacity: 0.5; transform: scale(1.2); }
            }
            .breaking-ticker {
                flex: 1;
                overflow: hidden;
                position: relative;
            }
            .breaking-ticker-track {
                display: flex;
                animation: ticker 30s linear infinite;
            }
            .breaking-ticker:hover .breaking-ticker-track {
                animation-play-state: paused;
            }
            @keyframes ticker {
                0% { transform: translateX(0); }
                100% { transform: translateX(-50%); }
            }
            .breaking-ticker-item {
                display: inline-flex;
                align-items: center;
                gap: 8px;
                padding: 0 24px;
                color: white;
                text-decoration: none;
                font-size: 14px;
                white-space: nowrap;
                transition: opacity 0.2s;
            }
            .breaking-ticker-item:hover {
                opacity: 0.8;
            }
            .ticker-sep {
                color: rgba(255,255,255,0.5);
                font-size: 10px;
            }
            .card-image-wrap img {
        height: 200px;
        object-fit: cover;
    }
    .spot-img-wrap img {
        height: 200px;
        object-fit: cover;
    }
</style>
    </head>
    <body class="bg-slate-50 text-slate-900 font-sans antialiased">
        <div class="min-h-screen bg-white">
            <div class="bg-emerald-700 text-emerald-50">
                <div class="mx-auto max-w-7xl px-4 py-3 sm:px-6 lg:px-8 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                    <div class="flex flex-wrap items-center gap-4 text-sm">
                        <span class="inline-flex items-center gap-2"><svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12H8m0 0H6m2 0a2 2 0 10-4 0 2 2 0 004 0zm12 0a2 2 0 10-4 0 2 2 0 004 0z"/></svg>{{ $contact['email'] ?? 'admin@nagari.go.id' }}</span>
                        <span class="inline-flex items-center gap-2"><svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8a2 2 0 012-2h3.28a1 1 0 01.948.684L10.9 9.569a1 1 0 00.952.631h2.196a1 1 0 01.948.684L16.72 14H19a2 2 0 012 2v2a2 2 0 01-2 2h-1.5"/></svg>{{ $contact['phone'] ?? '(0753) 20202, 20281' }}</span>
                    </div>
                    <div class="flex items-center gap-3 text-sm">
                        <span class="rounded-full bg-white/10 px-3 py-1">ID</span>
                        <span class="rounded-full bg-white/10 px-3 py-1">EN</span>
                    </div>
                </div>
            </div>
            <header class="sticky top-0 z-30 border-b border-slate-200 bg-white/95 backdrop-blur-sm">
                <div class="mx-auto flex max-w-7xl items-center justify-between px-4 py-5 sm:px-6 lg:px-8">
                    <a href="{{ url('/') }}" id="secret-logo" class="flex items-center gap-3 text-emerald-700 font-semibold text-lg" title="Nagari Koto Kaciak Barat">
                        <span class="inline-flex h-11 w-11 items-center justify-center rounded-2xl bg-emerald-100 text-emerald-700 ring-1 ring-emerald-200">N</span>
                        Nagari Kaciak Barat
                    </a>
                    <nav class="hidden items-center gap-8 text-slate-700 lg:flex">
                        <a href="{{ url('/') }}" class="transition hover:text-emerald-700">Beranda</a>
                        <a href="{{ route('news.page') }}" class="transition hover:text-emerald-700 text-emerald-700 font-medium">Berita</a>
                        <a href="{{ url('/#layanan') }}" class="transition hover:text-emerald-700">Layanan</a>
                        <a href="{{ url('/#peraturan') }}" class="transition hover:text-emerald-700">Peraturan</a>
                        <a href="{{ url('/#kontak') }}" class="transition hover:text-emerald-700">Kontak</a>
                    </nav>
                    <div class="flex items-center gap-3">
                        <a href="{{ url('/#kontak') }}" class="inline-flex items-center justify-center rounded-full bg-emerald-700 px-5 py-2 text-sm font-semibold text-white shadow-glow transition hover:bg-emerald-600">Hubungi</a>
                    </div>
                </div>
            </header>

        <!-- ===== BREAKING NEWS TICKER ===== -->
        @if(count($featured ?? []) > 0)
        <div class="breaking-news">
            <div class="container">
                <div class="breaking-news-inner">
                    <span class="breaking-label">
                        <span class="pulse-dot"></span>
                        Breaking News
                    </span>
                    <div class="breaking-ticker">
                        <div class="breaking-ticker-track">
                            @foreach($featured as $idx => $item)
                                <a href="{{ route('news.detail', $item['id'] ?? $idx) }}" class="breaking-ticker-item">
                                    <span class="ticker-sep">●</span>
                                    {{ $item['title'] }}
                                </a>
                            @endforeach
                            @foreach($featured as $idx => $item)
                                <a href="{{ route('news.detail', $item['id'] ?? $idx) }}" class="breaking-ticker-item">
                                    <span class="ticker-sep">●</span>
                                    {{ $item['title'] }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- ===== MAIN CONTENT ===== -->
        <main>
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <!-- Breadcrumb -->
                <nav class="flex items-center gap-2 text-sm text-slate-500 py-4" aria-label="Breadcrumb">
                    <a href="{{ url('/') }}" class="hover:text-emerald-700 transition">Beranda</a>
                    <span>/</span>
                    <span class="text-slate-900 font-semibold">Berita</span>
                </nav>

                <!-- ===== HERO SECTION ===== -->
                <section class="hero-gradient overflow-hidden bg-slate-50 rounded-3xl p-8 sm:p-12 mb-8">
                    <div class="space-y-6">
                        <p class="inline-flex items-center gap-2 rounded-full bg-emerald-50 px-4 py-2 text-sm font-medium text-emerald-700 ring-1 ring-emerald-100">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                            Portal Berita Resmi
                        </p>
                        <div class="space-y-4">
                            <h1 class="text-3xl font-semibold tracking-tight text-slate-900 sm:text-4xl">{{ $heroTitle }}</h1>
                            <p class="text-base leading-7 text-slate-600 max-w-2xl">{{ $heroSubtitle }}</p>
                        </div>
                        <div class="flex flex-wrap gap-3 items-center">
                            <span class="filter-pill active" data-filter="all">
                                <span class="filter-icon">📰</span>
                                Semua
                                <span class="count">{{ $newsCount }}</span>
                            </span>
                            @foreach($categories as $cat => $count)
                            <span class="filter-pill" data-filter="{{ strtolower($cat) }}">
                                <span class="filter-icon">
                                    @switch(strtolower($cat))
                                        @case('berita') 📰 @break
                                        @case('agenda') 📅 @break
                                        @case('informasi') ℹ️ @break
                                        @case('pengumuman') 📢 @break
                                        @case('kegiatan') 🎯 @break
                                        @default 📋
                                    @endswitch
                                </span>
                                {{ $cat }}
                                <span class="count">{{ $count }}</span>
                            </span>
                            @endforeach
                            <div class="search-box">
                                <input type="text" id="searchInput" placeholder="Cari berita..." />
                                <button type="button" onclick="searchNews()">🔍</button>
                            </div>
                        </div>
                        <p class="text-sm text-slate-500">{{ $paginator->firstItem() }}-{{ $paginator->lastItem() }} dari <strong>{{ $paginator->total() }}</strong> berita</p>
                    </div>
                </section>

                <!-- ===== FEATURED + SIDEBAR ===== -->
                @if(count($featured ?? []) > 0)
                <section class="grid gap-8 lg:grid-cols-[1fr_320px] mb-12">
                    <div class="space-y-8">
                        <!-- Main Story -->
                        @php $main = $featured[0] ?? null; @endphp
                        @if($main)
                        <a href="{{ route('news.detail', $main['id'] ?? 0) }}" class="relative rounded-3xl overflow-hidden group shadow-lg">
                            <img src="{{ $main['image'] }}" alt="{{ $main['title'] }}" class="w-full h-80 object-cover transition-transform duration-300 group-hover:scale-105" loading="lazy" />
                            <div class="absolute inset-0 bg-gradient-to-t from-slate-900/90 via-slate-900/40 to-transparent"></div>
                            <div class="absolute bottom-0 left-0 right-0 p-6 text-white">
                                <span class="inline-flex items-center rounded-full bg-emerald-600 px-3 py-1 text-xs font-medium">{{ $main['type'] ?? 'Berita' }}</span>
                                <h2 class="mt-3 text-xl font-semibold">{{ $main['title'] }}</h2>
                                <p class="mt-2 text-sm text-slate-200 line-clamp-2">{{ $main['summary'] ?? '' }}</p>
                                <div class="mt-4 flex items-center gap-4 text-xs text-slate-300">
                                    <span>📅 {{ $main['date'] ?? '' }}</span>
                                    <span>⏱ 3 menit baca</span>
                                </div>
                            </div>
                        </a>
                        @endif

                        <!-- Spotlight Grid -->
                        @if(count($featured) > 1)
                        <div class="grid gap-6 sm:grid-cols-2">
                            @foreach($featured->slice(1, 4) as $idx => $spot)
                            <a href="{{ route('news.detail', $spot['id'] ?? ($idx + 1)) }}" class="spotlight-card group">
                                <div class="spot-img-wrap relative overflow-hidden rounded-2xl">
                                    <img src="{{ $spot['image'] }}" alt="{{ $spot['title'] }}" class="spot-img w-full h-48 object-cover transition-transform duration-300 group-hover:scale-105" loading="lazy" />
                                    <span class="spot-badge absolute top-3 left-3 rounded-full bg-emerald-600 px-3 py-1 text-xs font-medium text-white">{{ $spot['type'] ?? 'Berita' }}</span>
                                </div>
                                <div class="spot-body p-4">
                                    <h3 class="font-semibold text-slate-900 group-hover:text-emerald-700 transition">{{ $spot['title'] }}</h3>
                                    <div class="spot-meta mt-2 text-xs text-slate-500">
                                        <span>📅 {{ $spot['date'] ?? '' }}</span>
                                    </div>
                                </div>
                            </a>
                            @endforeach
                        </div>
                        @endif
                    </div>

                    <!-- ===== SIDEBAR ===== -->
                    <aside class="space-y-6">
                        <!-- Categories Widget -->
                        <div class="sidebar-card rounded-3xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
                            <h3 class="text-lg font-semibold text-slate-900 mb-4 flex items-center gap-2">
                                📂 Kategori
                            </h3>
                            <ul class="space-y-3">
                                <li class="category-item flex items-center justify-between cursor-pointer hover:pl-2 transition-all" onclick="filterByCategory('all')">
                                    <span class="flex items-center gap-2">
                                        <span class="w-2 h-2 rounded-full bg-emerald-600"></span>
                                        <span class="text-slate-700">Semua Berita</span>
                                    </span>
                                    <span class="cat-count text-xs font-semibold text-slate-500 bg-slate-100 px-2 py-1 rounded-full">{{ $newsCount }}</span>
                                </li>
                                @foreach($categories as $cat => $count)
                                <li class="category-item flex items-center justify-between cursor-pointer hover:pl-2 transition-all" onclick="filterByCategory('{{ strtolower($cat) }}')">
                                    <span class="flex items-center gap-2">
                                        <span class="w-2 h-2 rounded-full" style="background:{{ $categoryColors[$cat] ?? '#64748b' }};"></span>
                                        <span class="text-slate-700">{{ $cat }}</span>
                                    </span>
                                    <span class="cat-count text-xs font-semibold text-slate-500 bg-slate-100 px-2 py-1 rounded-full">{{ $count }}</span>
                                </li>
                                @endforeach
                            </ul>
                        </div>

                        <!-- Popular News -->
                        <div class="sidebar-card rounded-3xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
                            <h3 class="text-lg font-semibold text-slate-900 mb-4 flex items-center gap-2">
                                🔥 Populer
                            </h3>
                            <ul class="space-y-4">
                                @foreach($trending as $idx => $item)
                                <li>
                                    <a href="{{ route('news.detail', $item['id'] ?? $idx) }}" class="popular-item flex gap-3 group">
                                        <img src="{{ $item['image'] }}" alt="{{ $item['title'] }}" class="popular-img w-16 h-16 rounded-xl object-cover flex-shrink-0" loading="lazy" />
                                        <div class="popular-info flex-1">
                                            <h4 class="text-sm font-semibold text-slate-900 group-hover:text-emerald-700 transition line-clamp-2">{{ $item['title'] }}</h4>
                                            <div class="popular-meta mt-1 flex items-center gap-2 text-xs text-slate-500">
                                                <span>{{ $item['date'] ?? '' }}</span>
                                                <span class="popular-badge bg-emerald-50 text-emerald-700 px-2 py-0.5 rounded-full text-xs">{{ $item['type'] ?? 'Berita' }}</span>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </aside>
                </section>
                @endif

                <!-- ===== NEWS GRID ===== -->
                <section class="mb-12">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-2xl font-semibold text-slate-900">Berita Terbaru <span class="text-sm font-normal text-slate-500">(Halaman {{ $paginator->currentPage() }})</span></h2>
                    </div>

                    @if(count($news) > 0)
                    <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3" id="newsGrid">
                        @foreach($news as $index => $item)
                        <article class="article-card group rounded-3xl bg-white shadow-sm ring-1 ring-slate-200 overflow-hidden hover:shadow-lg transition-all duration-300" data-category="{{ strtolower($item['type'] ?? 'umum') }}">
                            <a href="{{ route('news.detail', $item['id'] ?? $index) }}" class="card-image-wrap relative block overflow-hidden">
                                <img src="{{ $item['image'] }}" alt="{{ $item['title'] }}" class="w-full h-48 object-cover transition-transform duration-300 group-hover:scale-105" loading="lazy" />
                                <span class="card-badge absolute top-3 left-3 rounded-full bg-emerald-600 px-3 py-1 text-xs font-medium text-white">{{ $item['type'] ?? 'Berita' }}</span>
                                <span class="card-date-overlay absolute bottom-3 right-3 bg-white/90 backdrop-blur-sm px-2 py-1 rounded-lg text-xs font-medium text-slate-700">📅 {{ $item['date'] ?? '' }}</span>
                            </a>
                            <div class="card-body p-5">
                                <a href="{{ route('news.detail', $item['id'] ?? $index) }}">
                                    <h3 class="font-semibold text-slate-900 group-hover:text-emerald-700 transition line-clamp-2">{{ $item['title'] }}</h3>
                                </a>
                                <p class="mt-2 text-sm text-slate-600 line-clamp-2">{{ $item['summary'] ?? '' }}</p>
                                <div class="card-footer mt-4 flex items-center justify-between">
                                    <div class="card-meta flex items-center gap-2 text-xs text-slate-500">
                                        <span>👤 Admin Nagari</span>
                                        <span class="w-1 h-1 rounded-full bg-slate-300"></span>
                                        <span>⏱ 3 menit</span>
                                    </div>
                                    <a href="{{ route('news.detail', $item['id'] ?? $index) }}" class="read-link inline-block bg-emerald-600 hover:bg-emerald-700 text-white font-medium text-sm py-2 px-3 rounded transition">
                                        Baca Selengkapnya →
                                    </a>
                                </div>
                            </div>
                        </article>
                        @endforeach
                    </div>

                    <!-- ===== PAGINATION ===== -->
                    <div class="flex flex-col sm:flex-row items-center justify-between gap-4 mt-8 pt-6 border-t border-slate-200">
                        <div class="text-sm text-slate-600">
                            Menampilkan <strong>{{ $paginator->firstItem() }}</strong> - <strong>{{ $paginator->lastItem() }}</strong> dari <strong>{{ $paginator->total() }}</strong> berita
                        </div>
                        <div class="flex items-center gap-2">
                            @if($paginator->onFirstPage())
                                <span class="w-10 h-10 flex items-center justify-center rounded-lg bg-slate-100 text-slate-400 cursor-not-allowed">‹</span>
                            @else
                                <a href="{{ $paginator->previousPageUrl() }}" class="w-10 h-10 flex items-center justify-center rounded-lg bg-white border border-slate-200 text-slate-700 hover:bg-emerald-50 hover:text-emerald-700 hover:border-emerald-300 transition">‹</a>
                            @endif

                            @foreach($paginator->getUrlRange(1, $paginator->lastPage()) as $page => $url)
                                @if($page == $paginator->currentPage())
                                    <span class="w-10 h-10 flex items-center justify-center rounded-lg bg-emerald-600 text-white font-semibold">{{ $page }}</span>
                                @else
                                    <a href="{{ $url }}" class="w-10 h-10 flex items-center justify-center rounded-lg bg-white border border-slate-200 text-slate-700 hover:bg-emerald-50 hover:text-emerald-700 hover:border-emerald-300 transition">{{ $page }}</a>
                                @endif
                            @endforeach

                            @if($paginator->hasMorePages())
                                <a href="{{ $paginator->nextPageUrl() }}" class="w-10 h-10 flex items-center justify-center rounded-lg bg-white border border-slate-200 text-slate-700 hover:bg-emerald-50 hover:text-emerald-700 hover:border-emerald-300 transition">›</a>
                            @else
                                <span class="w-10 h-10 flex items-center justify-center rounded-lg bg-slate-100 text-slate-400 cursor-not-allowed">›</span>
                            @endif
                        </div>
                    </div>
                    @else
                    <div class="text-center py-12">
                        <div class="text-6xl mb-4">📭</div>
                        <h3 class="text-xl font-semibold text-slate-900 mb-2">Belum Ada Berita</h3>
                        <p class="text-slate-600">Belum ada berita yang ditambahkan. Silakan periksa kembali nanti.</p>
                    </div>
                    @endif
                </section>
            </div>
        </main>

        <!-- ===== FOOTER ===== -->
        <footer class="bg-slate-900 text-slate-300">
            <div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
                <div class="grid gap-8 sm:grid-cols-2 lg:grid-cols-4">
                    <div class="space-y-4">
                        <div class="flex items-center gap-3 text-white">
                            <span class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-600 text-emerald-50">N</span>
                            <span class="font-semibold">Nagari Kaciak Barat</span>
                        </div>
                        <p class="text-sm leading-relaxed">Portal berita resmi Nagari Koto Kaciak Barat. Menyajikan informasi terbaru, agenda, pengumuman, dan layanan publik nagari secara transparan dan akurat.</p>
                    </div>
                    <div class="space-y-4">
                        <h4 class="font-semibold text-white">Navigasi</h4>
                        <ul class="space-y-2">
                            <li><a href="{{ url('/') }}" class="hover:text-emerald-400 transition">Beranda</a></li>
                            <li><a href="{{ route('news.page') }}" class="hover:text-emerald-400 transition">Berita</a></li>
                            <li><a href="{{ url('/#layanan') }}" class="hover:text-emerald-400 transition">Layanan</a></li>
                            <li><a href="{{ url('/#peraturan') }}" class="hover:text-emerald-400 transition">Peraturan</a></li>
                            <li><a href="{{ url('/#kontak') }}" class="hover:text-emerald-400 transition">Kontak</a></li>
                        </ul>
                    </div>
                    <div class="space-y-4">
                        <h4 class="font-semibold text-white">Kategori</h4>
                        <ul class="space-y-2">
                            @foreach($categories as $cat => $count)
                            <li><a href="{{ route('news.page') }}" class="hover:text-emerald-400 transition">{{ $cat }} ({{ $count }})</a></li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="space-y-4">
                        <h4 class="font-semibold text-white">Kontak</h4>
                        <ul class="space-y-2">
                            <li><a href="mailto:{{ $contact['email'] ?? 'admin@nagari.go.id' }}" class="hover:text-emerald-400 transition">📧 {{ $contact['email'] ?? 'admin@nagari.go.id' }}</a></li>
                            <li><a href="tel:{{ $contact['phone'] ?? '(0753)20202' }}" class="hover:text-emerald-400 transition">📞 {{ $contact['phone'] ?? '(0753) 20202' }}</a></li>
                            <li class="text-slate-400">📍 {{ $contact['address'] ?? 'Koto Kaciak Barat, Kab. Pasaman' }}</li>
                        </ul>
                    </div>
                </div>
                <div class="mt-8 pt-8 border-t border-slate-800 flex flex-col sm:flex-row items-center justify-between gap-4">
                    <span class="text-sm">© {{ date('Y') }} Nagari Koto Kaciak Barat. All rights reserved.</span>
                    <div class="flex items-center gap-4">
                        <a href="#" title="Facebook" class="hover:text-emerald-400 transition">📘</a>
                        <a href="#" title="Instagram" class="hover:text-emerald-400 transition">📸</a>
                        <a href="#" title="YouTube" class="hover:text-emerald-400 transition">▶️</a>
                        <a href="#" title="Twitter" class="hover:text-emerald-400 transition">🐦</a>
                    </div>
                </div>
            </div>
        </footer>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                // Category Filter Pills
                const filterPills = document.querySelectorAll('.filter-pill');
                filterPills.forEach(function (pill) {
                    pill.addEventListener('click', function () {
                        filterPills.forEach(function (p) { p.classList.remove('active'); });
                        this.classList.add('active');
                        const filter = this.dataset.filter;
                        filterNewsByCategory(filter);
                    });
                });

                // Listen for category clicks from sidebar
                window.filterByCategory = function (category) {
                    filterPills.forEach(function (p) {
                        p.classList.toggle('active', p.dataset.filter === category);
                    });
                    filterNewsByCategory(category);
                };

                function filterNewsByCategory(category) {
                    const cards = document.querySelectorAll('.article-card');
                    cards.forEach(function (card) {
                        if (category === 'all') {
                            card.style.display = '';
                        } else {
                            const cardCat = card.dataset.category;
                            card.style.display = cardCat === category ? '' : 'none';
                        }
                    });
                }

                // Search functionality
                window.searchNews = function () {
                    const query = document.getElementById('searchInput').value.toLowerCase().trim();
                    const cards = document.querySelectorAll('.article-card');
                    cards.forEach(function (card) {
                        const title = card.querySelector('h3')?.textContent?.toLowerCase() || '';
                        const desc = card.querySelector('p')?.textContent?.toLowerCase() || '';
                        const match = query === '' || title.includes(query) || desc.includes(query);
                        card.style.display = match ? '' : 'none';
                    });
                };

                document.getElementById('searchInput')?.addEventListener('keyup', function (e) {
                    if (e.key === 'Enter') searchNews();
                });

                // Intersection Observer for entrance animations
                const animElements = document.querySelectorAll('.animate-in');
                const observer = new IntersectionObserver(function (entries) {
                    entries.forEach(function (entry) {
                        if (entry.isIntersecting) {
                            entry.target.style.animationPlayState = 'running';
                            observer.unobserve(entry.target);
                        }
                    });
                }, { threshold: 0.1 });

                animElements.forEach(function (el) {
                    el.style.animationPlayState = 'paused';
                    observer.observe(el);
                });

                // Auto-play all visible animations
                setTimeout(function () {
                    animElements.forEach(function (el) {
                        el.style.animationPlayState = 'running';
                    });
                }, 100);
                // ===== SECRET ADMIN SHORTCUT =====
                (function () {
                    var logoEl = document.getElementById('secret-logo');
                    if (!logoEl) return;
                    var clickCount = 0;
                    var resetTimer = null;
                    logoEl.addEventListener('click', function (e) {
                        e.preventDefault();
                        clickCount++;
                        clearTimeout(resetTimer);
                        resetTimer = setTimeout(function () { clickCount = 0; }, 3000);
                        if (clickCount >= 5) {
                            clickCount = 0;
                            window.location.href = '/login';
                        }
                    });
                })();
            });
        </script>
    </body>
</html>

