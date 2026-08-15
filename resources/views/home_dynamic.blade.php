    <!DOCTYPE html>
    <html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
        <head>
            <meta charset="utf-8" />
            <meta name="viewport" content="width=device-width, initial-scale=1" />
            <title>{{ config('app.name', 'Nagari Profile') }}</title>
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
                html {
                    scroll-behavior: smooth;
                }
                .hero-gradient {
                    background-image: radial-gradient(circle at top left, rgba(4, 120, 87, 0.18), transparent 35%), radial-gradient(circle at bottom right, rgba(6, 182, 212, 0.2), transparent 30%);
                }
                .text-gradient {
                    background: linear-gradient(90deg, #047857, #0ea5e9);
                    -webkit-background-clip: text;
                    -webkit-text-fill-color: transparent;
                }
                .smooth-transition {
                    transition: transform 0.35s ease, background-color 0.35s ease, color 0.35s ease, opacity 0.35s ease, box-shadow 0.35s ease;
                }
                .nav-link {
                    position: relative;
                    padding-bottom: 0.4rem;
                }
                .nav-link::after {
                    content: '';
                    position: absolute;
                    left: 0;
                    right: 0;
                    bottom: -0.2rem;
                    height: 3px;
                    background: transparent;
                    border-radius: 9999px;
                    transition: background-color 0.35s ease, transform 0.35s ease;
                    transform: scaleX(0);
                    transform-origin: center;
                }
                .nav-link.active::after {
                    background: #047857;
                    transform: scaleX(1);
                }
                .nav-link.active {
                    color: #047857;
                }
                .card-hover:hover {
                    transform: translateY(-4px);
                    box-shadow: 0 18px 45px rgba(15, 64, 35, 0.12);
                }
                .hide-scrollbar::-webkit-scrollbar {
                    display: none;
                }
                .hide-scrollbar {
                    -ms-overflow-style: none;
                    scrollbar-width: none;
                }
            </style>
        </head>
        <body class="bg-slate-50 text-slate-900 font-sans antialiased">
            <div class="min-h-screen bg-white">
                <div class="bg-emerald-700 text-emerald-50">
                    <div class="mx-auto max-w-7xl px-4 py-3 sm:px-6 lg:px-8 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                        <div class="flex flex-wrap items-center gap-4 text-sm">
                            <span class="inline-flex items-center gap-2"><svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12H8m0 0H6m2 0a2 2 0 10-4 0 2 2 0 004 0zm12 0a2 2 0 10-4 0 2 2 0 004 0z"/></svg>{{ $contact['email'] }}</span>
                            <span class="inline-flex items-center gap-2"><svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8a2 2 0 012-2h3.28a1 1 0 01.948.684L10.9 9.569a1 1 0 00.952.631h2.196a1 1 0 01.948.684L16.72 14H19a2 2 0 012 2v2a2 2 0 01-2 2h-1.5"/></svg>{{ $contact['phone'] }}</span>
                        </div>
                        <div class="flex items-center gap-3 text-sm">
                            <span class="rounded-full bg-white/10 px-3 py-1">ID</span>
                            <span class="rounded-full bg-white/10 px-3 py-1">EN</span>
                        </div>
                    </div>
                </div>
                <header class="sticky top-0 z-30 border-b border-slate-200 bg-white/95 backdrop-blur-sm">
                    <div class="mx-auto flex max-w-7xl items-center justify-between px-4 py-5 sm:px-6 lg:px-8">
                        <a href="#home" id="secret-logo" class="flex items-center gap-3 text-emerald-700 font-semibold text-lg" title="Nagari Koto Kaciak Barat">
                            <img src="{{ asset('images/logo.png') }}" alt="Logo Nagari" class="h-8 w-8 sm:h-11 sm:w-11 rounded-2xl object-cover self-center flex-shrink-0" />
                            <div class="leading-tight">
                                <span class="block">{{ $header['site_name'] ?? 'Nagari Koto Kaciak Barat' }}</span>
                                <span class="text-xs font-normal uppercase tracking-[0.24em] text-emerald-600">{{ $header['site_subtitle'] ?? 'Kec. Bonjol, Kab. Pasaman' }}</span>
                            </div>
                        </a>
                        <button id="mobile-menu-toggle" class="lg:hidden flex items-center p-2 rounded-md text-emerald-700 hover:bg-emerald-100 focus:outline-none">
    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
    </svg>
    </button>
    <div id="mobile-menu" class="hidden lg:flex flex-1 mx-4 max-w-full overflow-hidden relative">
    <div class="absolute left-0 top-0 bottom-0 w-8 bg-gradient-to-r from-white/95 to-transparent z-10 pointer-events-none"></div>
    <nav class="flex items-center gap-8 text-slate-700 overflow-x-auto hide-scrollbar scroll-smooth whitespace-nowrap px-4 py-2 w-full snap-x snap-mandatory" style="-webkit-overflow-scrolling: touch;">
                            @php
                                $navItems = [];
                                if(!empty($header['nav_items'])) {
                                    $lines = explode("\n", $header['nav_items']);
                                    foreach($lines as $line) {
                                        $parts = explode('|', $line);
                                        if(count($parts) >= 2) {
                                            $navItems[] = ['name' => trim($parts[0]), 'link' => trim($parts[1])];
                                        }
                                    }
                                }
    if(empty($navItems)) {
                                    $navItems = [
                                        ['name' => 'Profil', 'link' => '#profil'],
                                        ['name' => 'Perangkat', 'link' => '#perangkat'],
                                        ['name' => 'Pelayanan', 'link' => '#pelayanan'],
                                        ['name' => 'Berita', 'link' => '#berita'],
                                        ['name' => 'Layanan', 'link' => '#layanan'],
                                        ['name' => 'Peraturan', 'link' => '#peraturan'],
                                        ['name' => 'APBN', 'link' => '#apbn'],
                                        ['name' => 'Data Warga', 'link' => '#data-warga'],
                                        ['name' => 'Kontak', 'link' => '#kontak'],
                                        ['name' => 'Peta', 'link' => '#peta'],
                                    ];
                                }
                            @endphp
                            @foreach($navItems as $navItem)
                                <a href="{{ $navItem['link'] }}" class="nav-link transition hover:text-emerald-700 snap-center shrink-0">{{ $navItem['name'] }}</a>
                            @endforeach
                        </nav>
    <div class="absolute right-0 top-0 bottom-0 w-8 bg-gradient-to-l from-white/95 to-transparent z-10 pointer-events-none"></div>
    </div>
                        <div class="flex items-center gap-3">
                            <a href="#kontak" class="inline-flex items-center justify-center rounded-full bg-emerald-700 px-5 py-2 text-sm font-semibold text-white shadow-glow transition hover:bg-emerald-600">{{ $buttons['contact']['text'] ?? 'Hubungi' }}</a>
                        </div>
                    </div>
    </header>

    <!-- ===== BANNER HERO ===== -->
                @php
                    $bannerImage = $banner['image'] ?? asset('images/walinagari.jpeg');
                    $bannerBadge = $banner['badge'] ?? 'Selamat Datang';
                    $bannerTitle = $banner['title'] ?? ($header['site_name'] ?? 'Nagari Koto Kaciak Barat');
                    $bannerSubtitle = $banner['subtitle'] ?? '';
                @endphp
                <section id="banner" class="relative overflow-hidden">
                    <div class="absolute inset-0">
                        <img src="{{ $bannerImage }}" alt="Banner Nagari Koto Kaciak Barat" class="h-full w-full object-cover" />
                        <div class="absolute inset-0 bg-gradient-to-r from-emerald-950/90 via-emerald-900/75 to-emerald-800/40"></div>
                    </div>
                    <div class="relative mx-auto flex max-w-7xl flex-col items-start gap-6 px-4 py-24 sm:px-6 lg:px-8 lg:py-32">
    <span class="inline-flex items-center gap-2 rounded-full bg-white/10 px-4 py-2 text-sm font-medium text-white ring-1 ring-white/20 backdrop-blur-sm">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            {{ $bannerBadge }}
                        </span>
                        <h1 class="max-w-3xl text-4xl font-semibold tracking-tight text-white sm:text-5xl lg:text-6xl">{{ $bannerTitle }}</h1>
                        <p class="max-w-2xl text-base leading-8 text-white/90 sm:text-lg">{{ $bannerSubtitle }}</p>
                        <div class="flex flex-col gap-4 sm:flex-row">
                            <a href="{{ $buttons['hero_primary']['link'] ?? '#berita' }}" class="inline-flex items-center justify-center rounded-full bg-emerald-500 px-7 py-3 text-sm font-semibold text-white shadow-lg shadow-emerald-500/30 transition hover:bg-emerald-400">
                                {{ $buttons['hero_primary']['text'] ?? 'Baca Berita Terbaru' }}
                            </a>
                            <a href="{{ $buttons['hero_secondary']['link'] ?? '#layanan' }}" class="inline-flex items-center justify-center rounded-full border border-white/40 bg-white/10 px-7 py-3 text-sm font-semibold text-white backdrop-blur-sm transition hover:bg-white/20">
                                {{ $buttons['hero_secondary']['text'] ?? 'Lihat Layanan Publik' }}
                            </a>
                        </div>
                    </div>
                </section>

                <main id="home">
                    <section class="hero-gradient overflow-hidden bg-slate-50">
                        <div class="mx-auto grid max-w-7xl gap-10 px-4 py-16 sm:px-6 lg:grid-cols-[1.2fr_0.8fr] lg:items-center lg:px-8 lg:py-24">
                            <div class="space-y-6">
                                <p class="inline-flex items-center gap-2 rounded-full bg-emerald-50 px-4 py-2 text-sm font-medium text-emerald-700 ring-1 ring-emerald-100">Profil Nagari</p>
                                <div class="space-y-5">
                                    <h1 class="max-w-2xl text-4xl font-semibold tracking-tight text-slate-900 sm:text-5xl">{{ $hero_title }}</h1>
                                    <p class="max-w-xl text-base leading-8 text-slate-600">{{ $hero_subtitle }}</p>
                                </div>
                                <div class="flex flex-col gap-4 sm:flex-row">
                                    <a href="{{ $buttons['hero_primary']['link'] ?? '#berita' }}" class="inline-flex justify-center rounded-full bg-emerald-700 px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-emerald-700/10 transition hover:bg-emerald-600">{{ $buttons['hero_primary']['text'] ?? 'Baca Berita Terbaru' }}</a>
                                    <a href="{{ $buttons['hero_secondary']['link'] ?? '#layanan' }}" class="inline-flex justify-center rounded-full border border-slate-200 bg-white px-6 py-3 text-sm font-semibold text-slate-900 transition hover:border-emerald-700 hover:text-emerald-700">{{ $buttons['hero_secondary']['text'] ?? 'Lihat Layanan Publik' }}</a>
                                </div>
                                <div class="grid gap-4 sm:grid-cols-1 max-w-xs">
                                    @php
                                        $wargaStat = collect($statistics)->firstWhere(function($item) {
                                            return strtolower($item['label'] ?? '') === 'warga';
                                        }) ?? ($statistics[0] ?? ['label' => 'Warga', 'value' => '1.200+']);
                                    @endphp
                                    <div class="rounded-3xl bg-white p-5 shadow-sm ring-1 ring-slate-200">
                                        <p class="text-xs uppercase tracking-[0.24em] text-slate-500">{{ $wargaStat['label'] }}</p>
                                        <p class="mt-2 text-2xl font-semibold text-slate-900">{{ $wargaStat['value'] }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="relative">
                                <div class="rounded-[2rem] bg-gradient-to-br from-emerald-700 via-cyan-500 to-sky-500 p-1 shadow-glow">
                                    <div class="overflow-hidden rounded-[1.75rem] bg-white p-6 text-slate-900">
                                        <div class="flex items-center justify-between gap-4">
                                            <div>
                                                <p class="text-xs uppercase tracking-[0.3em] text-emerald-600">Nagari Koto Kaciak Barat</p>
                                                <h2 class="mt-4 text-2xl font-semibold">Sapa Warga & Pelayanan Modern</h2>
                                            </div>
                                            <div class="inline-flex h-12 w-12 items-center justify-center rounded-3xl bg-emerald-50 text-emerald-700">🏛</div>
                                        </div>
                                        <div class="mt-8 grid gap-4 sm:grid-cols-2">
                                            <div class="rounded-3xl bg-slate-50 p-4">
                                                <p class="text-sm text-slate-500">Pelayanan Online</p>
                                                <p class="mt-3 text-xl font-semibold">Sarana Aduan</p>
                                            </div>
                                            <div class="rounded-3xl bg-slate-50 p-4">
                                                <p class="text-sm text-slate-500">Informasi Publik</p>
                                                <p class="mt-3 text-xl font-semibold">Berita & Agenda</p>
                                            </div>
                                            <div class="rounded-3xl bg-slate-50 p-4">
                                                <p class="text-sm text-slate-500">Akses Dokumen</p>
                                                <p class="mt-3 text-xl font-semibold">Peraturan & SK</p>
                                            </div>
                                            <div class="rounded-3xl bg-slate-50 p-4">
                                                <p class="text-sm text-slate-500">Kontak Cepat</p>
                                                <p class="mt-3 text-xl font-semibold">Smart Info</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>

                    <section id="profil" class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8">
                        <div class="mb-12 flex flex-col gap-4 text-center">
                            <p class="text-base font-semibold uppercase tracking-[0.3em] text-emerald-700">Tentang Nagari</p>
                            <h2 class="text-3xl font-semibold text-slate-900 sm:text-4xl">{{ $content_sections['profile']['title'] ?? 'Profil Nagari Koto Kaciak Barat' }}</h2>
                            <p class="mx-auto max-w-2xl text-slate-600">{{ $content_sections['profile']['description'] ?? 'Nagari Koto Kaciak Barat berkomitmen menjadi nagari digital yang transparan, berdaya saing, dan memberikan layanan maksimal untuk semua lapisan masyarakat.' }}</p>
                        </div>
                        <div class="grid gap-6 lg:grid-cols-3">
                            @foreach ($profilCards as $card)
                                <article class="rounded-[2rem] border border-slate-200 bg-white p-8 shadow-sm">
                                    <span class="inline-flex rounded-full bg-emerald-50 px-3 py-1 text-sm font-semibold text-emerald-700">{{ $card['tag'] }}</span>
                                    <h3 class="mt-6 text-xl font-semibold text-slate-900">{{ $card['title'] }}</h3>
                                    <p class="mt-4 text-slate-600">{{ $card['description'] }}</p>
                                </article>
                            @endforeach
                        </div>
                        @if(!empty($profile['sejarah']))
                            <div class="mt-12 rounded-[2rem] border border-slate-200 bg-white p-8 shadow-sm">
                                <h3 class="text-xl font-semibold text-slate-900 mb-4">Sejarah Nagari</h3>
                                <p class="text-slate-600">{{ $profile['sejarah'] }}</p>
                            </div>
                        @endif
                    </section>

                    <section id="perangkat" class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8">
                        <div class="mb-12 text-center">
                            <p class="text-base font-semibold uppercase tracking-[0.3em] text-emerald-700">Perangkat Nagari</p>
                            <h2 class="mt-3 text-3xl font-semibold text-slate-900 sm:text-4xl">{{ $content_sections['devices']['title'] ?? 'Pejabat Utama dan Perangkat Nagari' }}</h2>
                            <p class="mx-auto mt-3 max-w-2xl text-slate-600">{{ $content_sections['devices']['description'] ?? 'Daftar pejabat utama dan perangkat nagari yang memimpin pelayanan publik serta pembangunan di Koto Kaciak Barat.' }}</p>
                        </div>
                        <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-3" id="device-list">
                            @foreach ($devices as $device)
                                <article class="overflow-hidden rounded-[2rem] border border-slate-200 bg-white shadow-sm card-hover smooth-transition @if($loop->iteration > 3) hidden extra-device @endif">
                                    <div class="aspect-[3/4] overflow-hidden bg-slate-100">
                                        <img src="{{ $device['image'] }}" alt="Foto {{ $device['name'] }}" class="h-full w-full object-cover smooth-transition" />
                                    </div>
                                    <div class="p-6 text-center">
                                        <h3 class="text-xl font-semibold text-slate-900">{{ $device['name'] }}</h3>
                                        <p class="mt-2 text-slate-600">{{ $device['position'] }}</p>
                                    </div>
                                </article>
                            @endforeach
                        </div>
                        @if(count($devices) > 3)
                            <div class="mt-8 text-center">
                                <button id="show-more-devices" type="button" class="inline-flex items-center justify-center rounded-full bg-emerald-700 px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-emerald-700/10 transition hover:bg-emerald-600">Lihat Selengkapnya</button>
                            </div>
                        @endif
                    </section>

                    <section id="pelayanan" class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8">
                        <div class="mb-12 text-center">
                            <p class="text-base font-semibold uppercase tracking-[0.3em] text-emerald-700">Layanan Masyarakat</p>
                            <h2 class="mt-3 text-3xl font-semibold text-slate-900 sm:text-4xl">Alur & Standar Pelayanan Administrasi</h2>
                            <p class="mx-auto mt-3 max-w-2xl text-slate-600">Informasi prosedur, persyaratan, dan estimasi waktu penyelesaian berbagai surat keterangan dan rekomendasi di Kantor Wali Nagari Koto Kaciak Barat.</p>
                        </div>

                        <!-- Container for both SOP and Flow -->
                        <div class="grid gap-8 lg:grid-cols-2">
                            <!-- Flowchart Pelayanan -->
                            <div class="rounded-[2rem] border border-slate-200 bg-white p-8 shadow-sm flex flex-col h-full">
                                <div class="mb-6">
                                    <h3 class="text-2xl font-semibold text-slate-900">Alur Pelayanan Administrasi</h3>
                                    <p class="text-slate-500 mt-2">Proses permohonan hingga penyerahan berkas yang efisien.</p>
                                </div>
                                
                                <div class="flex-grow flex items-center justify-center relative py-4">
                                    <div class="relative max-w-sm mx-auto w-full font-sans">
                                        <!-- Step 1 & 2 -->
                                        <div class="relative z-10 flex flex-col items-center">
                                            <div class="w-full bg-emerald-700 text-white text-center py-3 px-4 rounded-xl shadow-md font-semibold hover:-translate-y-1 transition-transform">PEMOHON</div>
                                            <svg class="w-6 h-6 text-emerald-300 my-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path></svg>
                                            
                                            <div class="w-full bg-emerald-600 text-white text-center py-3 px-4 rounded-xl shadow-md font-semibold hover:-translate-y-1 transition-transform text-sm sm:text-base">
                                                PETUGAS MENERIMA BERKAS
                                                <div class="font-normal text-emerald-100 text-xs mt-1">DAN MEMVERIFIKASI / MEVALIDASI</div>
                                            </div>
                                            <div class="w-0.5 h-8 bg-emerald-200 my-1"></div>
                                        </div>
                                        
                                        <!-- Branching -->
                                        <div class="flex justify-between w-full relative z-10 gap-6">
                                            <!-- Connector line top horizontal -->
                                            <div class="absolute top-[-4px] left-1/4 right-1/4 h-0.5 bg-emerald-200"></div>
                                            
                                            <!-- Left branch: Tidak Lengkap -->
                                            <div class="flex-1 flex flex-col items-center relative">
                                                <div class="w-0.5 h-4 bg-red-300"></div>
                                                <div class="w-full bg-red-500 text-white text-center py-2 px-2 rounded-xl shadow-md font-medium text-xs sm:text-sm hover:-translate-y-1 transition-transform">TIDAK LENGKAP</div>
                                                <!-- Line back to pemohon -->
                                                <div class="hidden sm:block absolute right-1/2 top-10 bottom-0 left-[-2rem] border-l-2 border-b-2 border-dashed border-red-300 rounded-bl-xl z-[-1]" style="height: 100px; transform: translateY(-130px);"></div>
                                            </div>
                                            
                                            <!-- Right branch: Lengkap -->
                                            <div class="flex-1 flex flex-col items-center">
                                                <div class="w-0.5 h-4 bg-emerald-300"></div>
                                                <div class="w-full bg-emerald-500 text-white text-center py-2 px-2 rounded-xl shadow-md font-medium text-xs sm:text-sm hover:-translate-y-1 transition-transform mb-4">LENGKAP</div>
                                                
                                                <!-- Steps inside lengkap -->
                                                <div class="flex flex-col items-center w-full gap-2">
                                                    <div class="w-full bg-slate-100 text-slate-800 text-center py-2 px-3 rounded-lg border border-slate-200 text-[11px] sm:text-xs font-semibold shadow-sm">PROSES PENGETIKAN KAUR/KASI</div>
                                                    <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path></svg>
                                                    
                                                    <div class="w-full bg-slate-100 text-slate-800 text-center py-2 px-3 rounded-lg border border-slate-200 text-[11px] sm:text-xs font-semibold shadow-sm">VERIFIKASI OLEH SEKRETARIS</div>
                                                    <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path></svg>
                                                    
                                                    <div class="w-full bg-slate-100 text-slate-800 text-center py-2 px-3 rounded-lg border border-slate-200 text-[11px] sm:text-xs font-semibold shadow-sm">PENANDATANGANAN WALI NAGARI</div>
                                                    <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path></svg>
                                                    
                                                    <div class="w-full bg-emerald-100 text-emerald-800 text-center py-2 px-3 rounded-lg border border-emerald-200 text-[11px] sm:text-xs font-semibold shadow-sm">KAUR/KASI MENYERAHKAN</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="mt-8 bg-slate-50 rounded-xl p-5 border border-slate-100">
                                    <h4 class="font-semibold text-slate-900 flex items-center gap-2">
                                        <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                                        Kewenangan Penandatanganan
                                    </h4>
                                    <ul class="mt-3 space-y-2 text-sm text-slate-600">
                                        <li class="flex items-start gap-3">
                                            <span class="w-6 h-6 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center flex-shrink-0 text-xs font-bold mt-0.5">1</span>
                                            <span><strong>Wali Nagari</strong> (Utama)</span>
                                        </li>
                                        <li class="flex items-start gap-3">
                                            <span class="w-6 h-6 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center flex-shrink-0 text-xs font-bold mt-0.5">2</span>
                                            <span><strong>Sekretaris Nagari</strong> (Bila Wali Nagari tidak berada di tempat dan/atau atas izin Wali Nagari)</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <!-- SOP Table -->
                            <div class="rounded-[2rem] border border-slate-200 bg-white shadow-sm flex flex-col h-full overflow-hidden">
                                <div class="p-8 pb-6 border-b border-slate-100 bg-gradient-to-r from-emerald-50 to-white">
                                    <h3 class="text-2xl font-semibold text-slate-900">SOP Pengurusan Surat Keterangan</h3>
                                    <p class="text-slate-500 mt-2">Standar penyelesaian dokumen rekomendasi.</p>
                                    
                                    <div class="mt-4 flex flex-wrap gap-2">
                                        <span class="inline-flex items-center gap-1.5 rounded-full bg-blue-100 px-3 py-1 text-xs font-semibold text-blue-800">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            Tidak Dipungut Biaya (Gratis)
                                        </span>
                                    </div>
                                </div>
                                
                                <div class="p-0 flex-grow overflow-y-auto max-h-[400px]">
                                    <table class="w-full text-left border-collapse">
                                        <thead class="bg-slate-50 sticky top-0 shadow-sm z-10">
                                            <tr>
                                                <th class="px-6 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">No</th>
                                                <th class="px-6 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Jenis Surat</th>
                                                <th class="px-6 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider text-right">Waktu</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-slate-100">
                                            @php
                                                $sops = [
                                                    ['Surat Keterangan Meninggal Dunia', '± 5 Menit'],
                                                    ['Surat Keterangan Domisili', '± 5 Menit'],
                                                    ['Surat Keterangan Belum Menikah', '± 10 Menit'],
                                                    ['Surat Keterangan Nikah', '± 10 Menit'],
                                                    ['Surat Keterangan Kepemilikan / hak milik', '± 10 Menit'],
                                                    ['Surat Keterangan Alih Waris', '± 10 Menit'],
                                                    ['Surat Keterangan Usaha', '± 5 Menit'],
                                                    ['Surat Keterangan Izin Mendirikan Bangunan', '± 10 Menit'],
                                                    ['Surat Keterangan Izin Keramaian', '± 5 Menit'],
                                                    ['Surat Keterangan Kurang Mampu', '± 10 Menit'],
                                                    ['Surat Keterangan Penghasilan', '± 10 Menit'],
                                                    ['Surat Rekomendasi Proposal', '± 15 Menit'],
                                                    ['Surat keterangan, dll', '± 15 Menit'],
                                                ];
                                            @endphp
                                            @foreach($sops as $index => $sop)
                                            <tr class="hover:bg-slate-50 transition-colors">
                                                <td class="px-6 py-3 text-sm text-slate-500">{{ $index + 1 }}</td>
                                                <td class="px-6 py-3 text-sm font-medium text-slate-700">{{ $sop[0] }}</td>
                                                <td class="px-6 py-3 text-sm font-semibold text-emerald-600 text-right whitespace-nowrap">{{ $sop[1] }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                
                                <div class="p-6 bg-slate-50 border-t border-slate-200">
                                    <h4 class="font-semibold text-slate-900 mb-3 flex items-center gap-2">
                                        <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                                        Persyaratan Umum
                                    </h4>
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 text-sm text-slate-600">
                                        <div class="flex items-center gap-2"><div class="w-1.5 h-1.5 rounded-full bg-emerald-500"></div> Fotokopi KTP</div>
                                        <div class="flex items-center gap-2"><div class="w-1.5 h-1.5 rounded-full bg-emerald-500"></div> Fotokopi KK</div>
                                        <div class="flex items-center gap-2"><div class="w-1.5 h-1.5 rounded-full bg-emerald-500"></div> Fotokopi Buku Nikah</div>
                                        <div class="flex items-center gap-2"><div class="w-1.5 h-1.5 rounded-full bg-emerald-500"></div> Fotokopi Akta Kelahiran</div>
                                        <div class="flex items-center gap-2"><div class="w-1.5 h-1.5 rounded-full bg-emerald-500"></div> Foto berwarna 3x4</div>
                                        <div class="flex items-center gap-2"><div class="w-1.5 h-1.5 rounded-full bg-emerald-500"></div> Dokumen pendukung lain</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>

                    <section id="berita" class="bg-slate-50 py-16">
                        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                            @php
                                $featuredNews = collect($news)->reverse()->take(3)->values()->all();
                                $restNews = collect($news)->reverse()->slice(3)->values()->all();
                            @endphp

                            <div class="mb-10 flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
                                <div>
                                    <p class="text-base font-semibold uppercase tracking-[0.3em] text-emerald-700">Berita Nagari</p>
                                    <h2 class="mt-3 text-3xl font-semibold text-slate-900 sm:text-4xl">{{ $content_sections['news']['title'] ?? 'Berita Terkini dan Pengumuman' }}</h2>
                                </div>
                                @if(count($restNews) > 0)
                                    <a href="{{ route('news.page') }}" class="inline-flex items-center text-sm font-semibold text-emerald-700 hover:text-emerald-600">Lihat Semua Berita →</a>
                                @endif
                            </div>
                            <div class="grid gap-6 lg:grid-cols-3">
                                @foreach ($featuredNews as $item)
                                    <article class="overflow-hidden rounded-[2rem] bg-white shadow-sm ring-1 ring-slate-200 card-hover smooth-transition">
                                        <div class="aspect-[4/3] overflow-hidden bg-slate-100">
                                            <img src="{{ $item['image'] }}" alt="Gambar {{ $item['title'] }}" class="h-full w-full object-cover smooth-transition" />
                                        </div>
                                        <div class="p-6">
                                            <div class="mb-4 flex items-center justify-between rounded-3xl bg-emerald-50 px-4 py-2 text-sm text-emerald-700">
                                                <span>{{ $item['date'] }}</span>
                                                <span class="rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold">{{ $item['type'] }}</span>
                                            </div>
                                            <h3 class="text-xl font-semibold text-slate-900">{{ $item['title'] }}</h3>
                                            <p class="mt-3 text-slate-600">{{ $item['summary'] }}</p>
                                            <a href="{{ route('news.detail', $item['id'] ?? $loop->index) }}" class="mt-6 inline-flex text-sm font-semibold text-emerald-700 hover:text-emerald-600">Baca selengkapnya →</a>
                                        </div>
                                    </article>
                                @endforeach
                            </div>

                            @if(count($restNews) > 0)
                                <div id="semua-berita" class="mt-10 rounded-[2rem] border border-slate-200 bg-white p-8 shadow-sm">
                                    <h3 class="text-2xl font-semibold text-slate-900">Berita Lainnya</h3>
                                    <div class="mt-6 space-y-4">
                                        @foreach($restNews as $item)
                                            <div class="flex flex-col gap-2 rounded-2xl bg-slate-50 p-4 sm:flex-row sm:items-center sm:justify-between">
                                                <div>
                                                    <p class="text-sm font-semibold text-emerald-700">{{ $item['date'] }}</p>
                                                    <a href="{{ route('news.detail', $item['id'] ?? $loop->index) }}" class="group">
                                                        <p class="mt-1 text-lg font-semibold text-slate-900 group-hover:text-emerald-700 transition">{{ $item['title'] }}</p>
                                                    </a>
                                                </div>
                                                <p class="text-sm text-slate-600">{{ $item['summary'] }}</p>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            <div class="mt-10 text-center">
                                <a href="{{ route('news.page') }}" class="inline-flex items-center justify-center rounded-full bg-emerald-700 px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-emerald-700/10 transition hover:bg-emerald-600">
                                    Lihat Berita Lainnya
                                </a>
                            </div>
                        </div>
                    </section>

                    <section id="layanan" class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8">
                        <div class="mb-12 text-center">
                            <p class="text-base font-semibold uppercase tracking-[0.3em] text-emerald-700">Layanan Publik</p>
                            <h2 class="mt-3 text-3xl font-semibold text-slate-900 sm:text-4xl">{{ $content_sections['services']['title'] ?? 'Layanan Nagari yang Mudah dan Terpercaya' }}</h2>
                        </div>
                        <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-4">
                            @foreach ($services as $service)
                                <div class="rounded-[2rem] border border-slate-200 bg-white p-8 shadow-sm">
                                    <div class="inline-flex h-12 w-12 items-center justify-center rounded-3xl bg-emerald-50 text-emerald-700 text-xl">{{ $service['icon'] }}</div>
                                    <h3 class="mt-6 text-xl font-semibold text-slate-900">{{ $service['title'] }}</h3>
                                    <p class="mt-4 text-slate-600">{{ $service['description'] }}</p>
                                </div>
                            @endforeach
                        </div>
                    </section>

                    <section id="peraturan" class="bg-emerald-700 py-16 text-white">
                        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                            <div class="mb-10 text-center">
                                <p class="text-sm font-semibold uppercase tracking-[0.3em] text-emerald-100">Peraturan</p>
                                <h2 class="mt-3 text-3xl font-semibold">{{ $content_sections['regulations']['title'] ?? 'Dokumen Resmi Nagari' }}</h2>
                                <p class="mx-auto mt-3 max-w-2xl text-slate-100/90">{{ $content_sections['regulations']['description'] ?? 'Akses mudah ke peraturan, keputusan, dan pedoman penting bagi warga nagari.' }}</p>
                            </div>
                            <div class="grid gap-6 md:grid-cols-3">
                                @foreach ($regulations as $regulation)
                                    <article class="rounded-[2rem] bg-emerald-600 p-6 shadow-xl shadow-emerald-900/20">
                                        <h3 class="text-xl font-semibold">{{ $regulation['title'] }}</h3>
                                        <p class="mt-4 text-slate-100/90">{{ $regulation['description'] }}</p>
                                        <a href="#" class="mt-6 inline-flex text-sm font-semibold text-white/90 hover:text-white">Download PDF →</a>
                                    </article>
                                @endforeach
                            </div>
                        </div>
                    </section>

                    <section id="apbn" class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8">
                        <div class="mb-12 text-center">
                            <p class="text-base font-semibold uppercase tracking-[0.3em] text-emerald-700">Transparansi Keuangan</p>
                            <h2 class="mt-3 text-3xl font-semibold text-slate-900 sm:text-4xl">{{ $content_sections['apbn']['title'] ?? 'Transparansi APBN & Dana Desa' }}</h2>
                            <p class="mx-auto mt-3 max-w-2xl text-slate-600">{{ $content_sections['apbn']['description'] ?? 'Informasi terbuka perencanaan dan realisasi penggunaan APBN serta Dana Desa Nagari Koto Kaciak Barat.' }}</p>
                        </div>

                        @if(!empty($apbn) && isset($apbn['total_anggaran']))
        @php
            $apbnTotal = (float) $apbn['total_anggaran'];
            $apbnRealisasi = (float) ($apbn['total_realisasi'] ?? 0);
            $apbnPersen = $apbnTotal > 0 ? round(($apbnRealisasi / $apbnTotal) * 100, 1) : 0;
            $fmt = fn($n) => 'Rp ' . number_format((float) $n, 0, ',', '.');
        @endphp

        <!-- Ringkasan -->
        <div class="grid gap-6 md:grid-cols-3">
            <div class="rounded-[2rem] border border-slate-200 bg-white p-8 shadow-sm">
                <p class="text-xs uppercase tracking-[0.24em] text-slate-500">Total Anggaran TA {{ $apbn['tahun'] ?? '' }}</p>
                <p class="mt-3 text-2xl font-semibold text-slate-900">{{ $fmt($apbnTotal) }}</p>
            </div>
            <div class="rounded-[2rem] border border-slate-200 bg-white p-8 shadow-sm">
                <p class="text-xs uppercase tracking-[0.24em] text-slate-500">Total Realisasi</p>
                <p class="mt-3 text-2xl font-semibold text-emerald-700">{{ $fmt($apbnRealisasi) }}</p>
            </div>
            <div class="rounded-[2rem] border border-slate-200 bg-white p-8 shadow-sm">
                <p class="text-xs uppercase tracking-[0.24em] text-slate-500">Persentase Realisasi</p>
                <p class="mt-3 text-2xl font-semibold text-slate-900">{{ $apbnPersen }}%</p>
            </div>
        </div>

        <!-- Progress Bar -->
        <div class="mt-8 rounded-[2rem] border border-slate-200 bg-white p-8 shadow-sm">
            <div class="flex items-center justify-between">
                <p class="text-sm font-semibold text-slate-900">Tingkat Realisasi Anggaran</p>
                <p class="text-sm font-semibold text-emerald-700">{{ $apbnPersen }}%</p>
            </div>
            <div class="mt-4 h-4 w-full overflow-hidden rounded-full bg-slate-100">
                <div class="h-full rounded-full bg-gradient-to-r from-emerald-700 to-cyan-500" style="width: {{ $apbnPersen }}%;"></div>
            </div>
        </div>

        @if(!empty($apbn['sumber_dana']))
            <div class="mt-8 rounded-[2rem] border border-slate-200 bg-white p-8 shadow-sm">
                <h3 class="text-xl font-semibold text-slate-900">Sumber Dana & Realisasi</h3>
                <div class="mt-6 space-y-5">
                    @foreach($apbn['sumber_dana'] as $sumber)
                        @php
                            $sTot = (float) ($sumber['anggaran'] ?? 0);
                            $sReal = (float) ($sumber['realisasi'] ?? 0);
                            $sPersen = $sTot > 0 ? round(($sReal / $sTot) * 100, 1) : 0;
                        @endphp
                        <div>
                            <div class="flex flex-wrap items-center justify-between gap-2 text-sm">
                                <span class="font-semibold text-slate-900">{{ $sumber['nama'] }}</span>
                                <span class="text-slate-500">{{ $fmt($sReal) }} dari {{ $fmt($sTot) }} ({{ $sPersen }}%)</span>
                            </div>
                            <div class="mt-2 h-3 w-full overflow-hidden rounded-full bg-slate-100">
                                <div class="h-full rounded-full bg-emerald-600" style="width: {{ $sPersen }}%;"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        @if(!empty($apbn['bidang']))
            <div class="mt-8 rounded-[2rem] border border-slate-200 bg-white p-8 shadow-sm">
                <h3 class="text-xl font-semibold text-slate-900">Rincian Alokasi per Bidang</h3>
                <div class="mt-6 overflow-x-auto">
                    <table class="w-full min-w-[640px] text-left text-sm">
                        <thead>
                            <tr class="border-b border-slate-200 text-slate-500">
                                <th class="py-3 pr-4 font-semibold">Bidang</th>
                                <th class="py-3 pr-4 font-semibold">Anggaran</th>
                                <th class="py-3 pr-4 font-semibold">Realisasi</th>
                                <th class="py-3 font-semibold">Persentase</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($apbn['bidang'] as $bidang)
                                @php
                                    $bTot = (float) ($bidang['anggaran'] ?? 0);
                                    $bReal = (float) ($bidang['realisasi'] ?? 0);
                                    $bPersen = $bTot > 0 ? round(($bReal / $bTot) * 100, 1) : 0;
                                @endphp
                                <tr class="border-b border-slate-100">
                                    <td class="py-4 pr-4 font-medium text-slate-900">{{ $bidang['nama'] }}</td>
                                    <td class="py-4 pr-4 text-slate-600">{{ $fmt($bTot) }}</td>
                                    <td class="py-4 pr-4 text-emerald-700">{{ $fmt($bReal) }}</td>
                                    <td class="py-4">
                                        <span class="inline-flex items-center gap-2">
                                            <span class="w-16 overflow-hidden rounded-full bg-slate-100">
                                                <span class="block h-2 rounded-full bg-emerald-600" style="width: {{ $bPersen }}%;"></span>
                                            </span>
                                            <span class="text-slate-600">{{ $bPersen }}%</span>
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif

        @if(!empty($apbn['program']))
            <div class="mt-8 rounded-[2rem] border border-slate-200 bg-white p-8 shadow-sm">
                <div class="flex items-center justify-between">
                    <h3 class="text-xl font-semibold text-slate-900">Daftar Program & Kegiatan</h3>
                </div>
                <div class="mt-6 space-y-4">
                    @foreach($apbn['program'] as $program)
                        @php
                            $pTot = (float) ($program['anggaran'] ?? 0);
                            $pReal = (float) ($program['realisasi'] ?? 0);
                            $status = $program['status'] ?? '';
                            $statusBadge = match(strtolower($status)) {
                                'selesai' => 'bg-emerald-50 text-emerald-700 ring-emerald-100',
                                'berjalan' => 'bg-sky-50 text-sky-700 ring-sky-100',
                                default => 'bg-slate-50 text-slate-600 ring-slate-100',
                            };
                        @endphp
                        <div class="rounded-2xl bg-slate-50 p-5">
                            <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
                                <div>
                                    <div class="flex flex-wrap items-center gap-2">
                                        <h4 class="text-lg font-semibold text-slate-900">{{ $program['nama'] }}</h4>
                                        <span class="rounded-full px-3 py-1 text-xs font-semibold ring-1 {{ $statusBadge }}">{{ $status }}</span>
                                    </div>
                                    <p class="mt-1 text-xs font-medium uppercase tracking-[0.2em] text-emerald-700">{{ $program['bidang'] ?? '' }}</p>
                                    <p class="mt-2 text-sm text-slate-600">{{ $program['keterangan'] ?? '' }}</p>
                                </div>
                                <div class="shrink-0 text-left sm:text-right">
                                    <p class="text-xs uppercase tracking-[0.2em] text-slate-500">Anggaran</p>
                                    <p class="mt-1 font-semibold text-slate-900">{{ $fmt($pTot) }}</p>
                                    <p class="text-xs uppercase tracking-[0.2em] text-slate-500 mt-2">Realisasi</p>
                                    <p class="mt-1 font-semibold text-emerald-700">{{ $fmt($pReal) }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    @else
        <div class="rounded-[2rem] border border-slate-200 bg-white p-10 text-center shadow-sm">
            <p class="text-slate-500">Data transparansi APBN belum tersedia. Pemerintahan Nagari akan segera mengunggahnya.</p>
        </div>
    @endif




                    </section>

                    <section id="data-warga" class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8">
                        <div class="mb-12 text-center">
                            <p class="text-base font-semibold uppercase tracking-[0.3em] text-emerald-700">Statistik Kependudukan</p>
                            <h2 class="mt-3 text-3xl font-semibold text-slate-900 sm:text-4xl">Data Warga Nagari & Per Jorong</h2>
                            <p class="mx-auto mt-3 max-w-2xl text-slate-600">Informasi terbaru jumlah penduduk Nagari Koto Kaciak Barat, termasuk rincian per jorong, jenis kelamin, dan status kependudukan.</p>
                        </div>

                        @php
                            $totalWarga = (int) ($warga_stats['total_warga'] ?? 0);
                            $totalKK = (int) ($warga_stats['total_kk'] ?? 0);
                            $totalJorong = (int) ($warga_stats['total_jorong'] ?? 0);
                            $lakiLaki = (int) ($warga_stats['laki_laki'] ?? 0);
                            $perempuan = (int) ($warga_stats['perempuan'] ?? 0);
                            $wargaHidup = (int) ($warga_stats['total_warga_hidup'] ?? 0);
                            $wargaWafat = (int) ($warga_stats['total_warga_wafat'] ?? 0);
                            $perJorong = $warga_stats['per_jorong'] ?? [];
                        @endphp

                        <!-- Kartu Ringkasan -->
                        <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-4">
                            <div class="rounded-[2rem] border border-slate-200 bg-white p-8 shadow-sm card-hover smooth-transition">
                                <div class="inline-flex h-12 w-12 items-center justify-center rounded-3xl bg-emerald-50 text-emerald-700">
                                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                                </div>
                                <p class="mt-6 text-xs uppercase tracking-[0.24em] text-slate-500">Total Warga</p>
                                <p class="mt-2 text-3xl font-semibold text-slate-900">{{ number_format($totalWarga, 0, ',', '.') }}</p>
                            </div>
                            <div class="rounded-[2rem] border border-slate-200 bg-white p-8 shadow-sm card-hover smooth-transition">
                                <div class="inline-flex h-12 w-12 items-center justify-center rounded-3xl bg-sky-50 text-sky-700">
                                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                                </div>
                                <p class="mt-6 text-xs uppercase tracking-[0.24em] text-slate-500">Total Kartu Keluarga</p>
                                <p class="mt-2 text-3xl font-semibold text-slate-900">{{ number_format($totalKK, 0, ',', '.') }}</p>
                            </div>
                            <div class="rounded-[2rem] border border-slate-200 bg-white p-8 shadow-sm card-hover smooth-transition">
                                <div class="inline-flex h-12 w-12 items-center justify-center rounded-3xl bg-amber-50 text-amber-700">
                                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                </div>
                                <p class="mt-6 text-xs uppercase tracking-[0.24em] text-slate-500">Jumlah Jorong</p>
                                <p class="mt-2 text-3xl font-semibold text-slate-900">{{ number_format($totalJorong, 0, ',', '.') }}</p>
                            </div>
                            <div class="rounded-[2rem] border border-slate-200 bg-white p-8 shadow-sm card-hover smooth-transition">
                                <div class="inline-flex h-12 w-12 items-center justify-center rounded-3xl bg-purple-50 text-purple-700">
                                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                </div>
                                <p class="mt-6 text-xs uppercase tracking-[0.24em] text-slate-500">Warga Hidup</p>
                                <p class="mt-2 text-3xl font-semibold text-slate-900">{{ number_format($wargaHidup, 0, ',', '.') }}</p>
                                <p class="mt-1 text-sm text-slate-500">Wafat: {{ number_format($wargaWafat, 0, ',', '.') }}</p>
                            </div>
                        </div>

                        <!-- Jenis Kelamin & Per Jorong -->
                        <div class="mt-8 grid gap-6 lg:grid-cols-2">
                            <!-- Jenis Kelamin -->
                            <div class="rounded-[2rem] border border-slate-200 bg-white p-8 shadow-sm">
                                <h3 class="text-xl font-semibold text-slate-900">Komposisi Jenis Kelamin</h3>
                                <div class="mt-6 space-y-5">
                                    @php
                                        $jkTotal = ($lakiLaki + $perempuan) > 0 ? ($lakiLaki + $perempuan) : 1;
                                        $lakiPersen = round(($lakiLaki / $jkTotal) * 100, 1);
                                        $perempuanPersen = round(($perempuan / $jkTotal) * 100, 1);
                                    @endphp
                                    <div>
                                        <div class="flex flex-wrap items-center justify-between gap-2 text-sm">
                                            <span class="font-semibold text-sky-700">Laki-laki</span>
                                            <span class="text-slate-500">{{ number_format($lakiLaki, 0, ',', '.') }} ({{ $lakiPersen }}%)</span>
                                        </div>
                                        <div class="mt-2 h-3 w-full overflow-hidden rounded-full bg-slate-100">
                                            <div class="h-full rounded-full bg-sky-500" style="width: {{ $lakiPersen }}%;"></div>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="flex flex-wrap items-center justify-between gap-2 text-sm">
                                            <span class="font-semibold text-pink-700">Perempuan</span>
                                            <span class="text-slate-500">{{ number_format($perempuan, 0, ',', '.') }} ({{ $perempuanPersen }}%)</span>
                                        </div>
                                        <div class="mt-2 h-3 w-full overflow-hidden rounded-full bg-slate-100">
                                            <div class="h-full rounded-full bg-pink-500" style="width: {{ $perempuanPersen }}%;"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Per Jorong -->
                            <div class="rounded-[2rem] border border-slate-200 bg-white p-8 shadow-sm">
                                <h3 class="text-xl font-semibold text-slate-900">Data Warga per Jorong</h3>
                                @if(count($perJorong) > 0)
                                    <div class="mt-6 overflow-x-auto">
                                        <table class="w-full min-w-[420px] text-left text-sm">
                                            <thead>
                                                <tr class="border-b border-slate-200 text-slate-500">
                                                    <th class="py-3 pr-4 font-semibold">Jorong</th>
                                                    <th class="py-3 pr-4 font-semibold">Warga</th>
                                                    <th class="py-3 font-semibold">Kartu Keluarga</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($perJorong as $jr)
                                                    <tr class="border-b border-slate-100">
                                                        <td class="py-4 pr-4 font-medium text-slate-900">{{ $jr['nama'] }}</td>
                                                        <td class="py-4 pr-4 text-slate-600">{{ number_format((int)$jr['jumlah_warga'], 0, ',', '.') }}</td>
                                                        <td class="py-4 text-slate-600">{{ number_format((int)$jr['jumlah_kk'], 0, ',', '.') }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    <p class="mt-6 text-slate-500">Belum ada data per jorong.</p>
                                @endif
                            </div>
                        </div>
                    </section>

                    <section id="kontak" class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8">
                        <div class="grid gap-12 lg:grid-cols-2">
                            <div>
                                <p class="text-base font-semibold uppercase tracking-[0.3em] text-emerald-700">Kontak Kami</p>
                                <h2 class="mt-3 text-3xl font-semibold text-slate-900 sm:text-4xl">{{ $content_sections['contact']['title'] ?? 'Temui Tim Nagari dan Dapatkan Bantuan' }}</h2>
                                <p class="mt-4 text-slate-600">{{ $content_sections['contact']['description'] ?? 'Kantor Nagari Koto Kaciak Barat siap melayani aspirasi, permohonan dokumen, dan informasi publik setiap hari kerja.' }}</p>
                                <div class="mt-10 space-y-6 rounded-[2rem] border border-slate-200 bg-white p-8 shadow-sm">
                                    <div class="flex items-start gap-4">
                                        <div class="mt-1 inline-flex h-12 w-12 items-center justify-center rounded-3xl bg-emerald-50 text-emerald-700">📍</div>
                                        <div>
                                            <p class="font-semibold text-slate-900">Alamat</p>
                                            <p class="mt-1 text-slate-600">{{ $contact['address'] }}</p>
                                        </div>
                                    </div>
                                    <div class="flex items-start gap-4">
                                        <div class="mt-1 inline-flex h-12 w-12 items-center justify-center rounded-3xl bg-emerald-50 text-emerald-700">📞</div>
                                        <div>
                                            <p class="font-semibold text-slate-900">Telepon</p>
                                            <p class="mt-1 text-slate-600">{{ $contact['phone'] }}</p>
                                        </div>
                                    </div>
                                    <div class="flex items-start gap-4">
                                        <div class="mt-1 inline-flex h-12 w-12 items-center justify-center rounded-3xl bg-emerald-50 text-emerald-700">✉️</div>
                                        <div>
                                            <p class="font-semibold text-slate-900">Email</p>
                                            <p class="mt-1 text-slate-600">{{ $contact['email'] }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="rounded-[2rem] bg-slate-900 p-8 text-white shadow-xl shadow-slate-900/20">
                                <p class="text-sm uppercase tracking-[0.3em] text-emerald-300">Kirim Pesan</p>
                                <h3 class="mt-4 text-2xl font-semibold">Ajukan Pertanyaan atau Sampaikan Usulan</h3>
                                @if (session('success'))
                                    <div class="mt-6 rounded-3xl bg-emerald-50/20 p-4 text-sm text-emerald-200 ring-1 ring-emerald-200/30">{{ session('success') }}</div>
                                @endif
                                <form action="{{ route('contact.submit') }}" method="POST" class="mt-8 space-y-6">
                                    @csrf
                                    <div>
                                        <label class="block text-sm font-medium text-slate-200">Nama</label>
                                        <input name="name" type="text" value="{{ old('name') }}" placeholder="Nama lengkap" class="mt-3 w-full rounded-3xl border border-slate-700 bg-slate-950/70 px-4 py-3 text-sm text-white placeholder:text-slate-500 focus:border-emerald-400 focus:outline-none focus:ring-4 focus:ring-emerald-500/10" />
                                        @error('name')<p class="mt-2 text-sm text-rose-300">{{ $message }}</p>@enderror
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-slate-200">Email</label>
                                        <input name="email" type="email" value="{{ old('email') }}" placeholder="email@domain.com" class="mt-3 w-full rounded-3xl border border-slate-700 bg-slate-950/70 px-4 py-3 text-sm text-white placeholder:text-slate-500 focus:border-emerald-400 focus:outline-none focus:ring-4 focus:ring-emerald-500/10" />
                                        @error('email')<p class="mt-2 text-sm text-rose-300">{{ $message }}</p>@enderror
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-slate-200">Pesan</label>
                                        <textarea name="message" rows="4" placeholder="Tuliskan pesan Anda" class="mt-3 w-full rounded-3xl border border-slate-700 bg-slate-950/70 px-4 py-3 text-sm text-white placeholder:text-slate-500 focus:border-emerald-400 focus:outline-none focus:ring-4 focus:ring-emerald-500/10">{{ old('message') }}</textarea>
                                        @error('message')<p class="mt-2 text-sm text-rose-300">{{ $message }}</p>@enderror
                                    </div>
                                    <button type="submit" class="inline-flex w-full items-center justify-center rounded-full bg-emerald-500 px-5 py-3 text-sm font-semibold text-white transition hover:bg-emerald-400">Kirim Pesan</button>
                                </form>
                            </div>
                        </div>
                    </section>
                </main>
                    <section id="peta" class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8">
                        <div class="rounded-[2rem] bg-slate-900 p-8 text-white shadow-xl shadow-slate-900/20">
                            <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                                <div>
                                    <h2 class="mt-3 text-3xl font-semibold">Peta Nagari Koto Koto Kaciak Barat</h2>
                                    <p class="mt-2 max-w-2xl text-slate-300">Kecamatan Bonjol, Kabupaten Pasaman. Lihat posisi nagari secara langsung di peta untuk mempermudah warga dan tamu yang berkunjung.</p>
                                </div>
                            </div>
                            <div class="overflow-hidden rounded-[1.5rem] border border-slate-800">
                                <iframe
                                    class="h-[420px] w-full border-0"
                                    src="https://maps.google.com/maps?q=-0.0562986,100.1978429&hl=id&z=16&output=embed"
                                    allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"
                                ></iframe>
                            </div>
                        </div>
                    </section>

                    <section class="mx-auto max-w-7xl px-4 pb-24 sm:px-6 lg:px-8">
                        <div class="text-center">
                            <p class="text-sm font-semibold uppercase tracking-[0.3em] text-emerald-700">Perangkat Lainnya</p>
                            <p class="mx-auto mt-4 max-w-2xl text-slate-600">Klik tombol untuk melihat perangkat nagari lainnya yang belum tampil di awal.</p>
                        </div>
                    </section>
                </main>
                <footer class="border-t border-slate-200 bg-white py-8">
                    <div class="mx-auto flex max-w-7xl flex-col gap-6 px-4 sm:px-6 lg:px-8 lg:flex-row lg:items-center lg:justify-between">
                        <p class="text-sm text-slate-600">© 2026 Nagari Koto Kaciak Barat. Semua hak dilindungi.</p>
                        <div class="flex flex-wrap items-center gap-4 text-sm text-slate-500">
    <a href="#profil" class="hover:text-emerald-700">Profil</a>
                            <a href="#berita" class="hover:text-emerald-700">Berita</a>
                            <a href="#layanan" class="hover:text-emerald-700">Layanan</a>
                            <a href="#data-warga" class="hover:text-emerald-700">Data Warga</a>
                            <a href="#apbn" class="hover:text-emerald-700">APBN</a>
                            <a href="#kontak" class="hover:text-emerald-700">Kontak</a>
                            <a href="#peta" class="hover:text-emerald-700">Peta</a>
                        </div>
                <script>
    document.addEventListener('DOMContentLoaded', function () {
        // Show more devices button (existing)
        const button = document.getElementById('show-more-devices');
        const extraCards = document.querySelectorAll('.extra-device');
        if (button && extraCards.length) {
            button.addEventListener('click', function () {
                const isExpanded = button.dataset.expanded === 'true';
                extraCards.forEach(function (card) {
                    card.classList.toggle('hidden', isExpanded);
                });
                button.textContent = isExpanded ? 'Lihat Selengkapnya' : 'Kembali ke Awal';
                button.dataset.expanded = isExpanded ? 'false' : 'true';
            });
        }

        // Mobile menu toggle
        const menuToggle = document.getElementById('mobile-menu-toggle');
        const mobileMenu = document.getElementById('mobile-menu');
        if (menuToggle && mobileMenu) {
            menuToggle.addEventListener('click', function () {
                const isHidden = mobileMenu.classList.contains('hidden');
                mobileMenu.classList.toggle('hidden', !isHidden);
            });
        }

        // Accordion functionality
        const accordionHeaders = document.querySelectorAll('.accordion-header');
        accordionHeaders.forEach(function (header) {
            header.addEventListener('click', function () {
                const content = header.nextElementSibling;
                if (content) {
                    content.classList.toggle('hidden');
                }
            });
        });

        // Navigation active state (existing)
        const navLinks = document.querySelectorAll('.nav-link');
        const sections = Array.from(navLinks).map((link) => (document.querySelector(link.getAttribute('href'))));

        function setActiveNav() {
            const offset = window.innerHeight * 0.25;
            let activeIndex = 0;
            sections.forEach((section, index) => {
                if (!section) return;
                const top = section.getBoundingClientRect().top;
                if (top <= offset) {
                    activeIndex = index;
                }
            });
            navLinks.forEach((link, index) => {
                link.classList.toggle('active', index === activeIndex);
            });
        }

        window.addEventListener('scroll', setActiveNav, { passive: true });
        setActiveNav();

        navLinks.forEach((link) => {
            link.addEventListener('click', function () {
                navLinks.forEach((item) => item.classList.remove('active'));
                this.classList.add('active');
            });
        });
    });
    // ===== SECRET ADMIN SHORTCUT =====
    // Klik logo 5x dalam 3 detik untuk masuk ke halaman login
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
    </script>
                </footer>
            </div>
        </body>
    </html>
