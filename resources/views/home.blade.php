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
                /*! tailwindcss v4.0.7 | MIT License | https://tailwindcss.com */@layer theme{:root,:host{--font-sans:'Instrument Sans',ui-sans-serif,system-ui,sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol","Noto Color Emoji";--font-serif:ui-serif,Georgia,Cambria,"Times New Roman",Times,serif;--font-mono:ui-monospace,SFMono-Regular,Menlo,Monaco,Consolas,"Liberation Mono","Courier New",monospace;}
                @layer utilities{.bg-emerald-700{background-color:#047857;}.bg-emerald-600{background-color:#059669;}.bg-emerald-50{background-color:#ecfdf5;}.text-emerald-700{color:#047857;}.text-slate-700{color:#334155;}.text-slate-500{color:#64748b;}.shadow-glow{box-shadow:0 20px 50px rgba(4,120,87,.18);}.ring-emerald-500{box-shadow:0 0 0 3px rgba(16,185,129,.15);}}
            </style>
        @endif
        <style>
            .hero-gradient {
                background-image: radial-gradient(circle at top left, rgba(4, 120, 87, 0.18), transparent 35%), radial-gradient(circle at bottom right, rgba(6, 182, 212, 0.2), transparent 30%);
            }
            .text-gradient {
                background: linear-gradient(90deg, #047857, #0ea5e9);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
            }
        </style>
    </head>
    <body class="bg-slate-50 text-slate-900 font-sans antialiased">
        <div class="min-h-screen bg-white">
            <div class="bg-emerald-700 text-emerald-50">
                <div class="mx-auto max-w-7xl px-4 py-3 sm:px-6 lg:px-8 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                    <div class="flex flex-wrap items-center gap-4 text-sm">
                        <span class="inline-flex items-center gap-2"><svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12H8m0 0H6m2 0a2 2 0 10-4 0 2 2 0 004 0zm12 0a2 2 0 10-4 0 2 2 0 004 0z"/></svg>admin@nagari.go.id</span>
                        <span class="inline-flex items-center gap-2"><svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8a2 2 0 012-2h3.28a1 1 0 01.948.684L10.9 9.569a1 1 0 00.952.631h2.196a1 1 0 01.948.684L16.72 14H19a2 2 0 012 2v2a2 2 0 01-2 2h-1.5"/></svg>(0753) 20202, 20281</span>
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
                        <span class="inline-flex h-11 w-11 items-center justify-center rounded-2xl bg-emerald-100 text-emerald-700 ring-1 ring-emerald-200">N</span>
                        <div class="leading-tight">
                            <span class="block">{{ $header['site_name'] ?? 'Nagari Koto Kaciak Barat' }}</span>
                            <span class="text-xs font-normal uppercase tracking-[0.24em] text-emerald-600">{{ $header['site_subtitle'] ?? 'Kec. Bonjol, Kab. Pasaman' }}</span>
                        </div>
                    </a>
                    <nav class="hidden items-center gap-8 text-slate-700 lg:flex">
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
                                    ['name' => 'Berita', 'link' => '#berita'],
                                    ['name' => 'Layanan', 'link' => '#layanan'],
                                    ['name' => 'Peraturan', 'link' => '#peraturan'],
                                    ['name' => 'Kontak', 'link' => '#kontak'],
                                ];
                            }
                        @endphp
                        @foreach($navItems as $navItem)
                            <a href="{{ $navItem['link'] }}" class="transition hover:text-emerald-700">{{ $navItem['name'] }}</a>
                        @endforeach
                    </nav>
                    <div class="flex items-center gap-3">
                        <a href="#kontak" class="inline-flex items-center justify-center rounded-full bg-emerald-700 px-5 py-2 text-sm font-semibold text-white shadow-glow transition hover:bg-emerald-600">{{ $buttons['contact']['text'] ?? 'Hubungi' }}</a>
                    </div>
                </div>
            </header>

            <main id="home">
                <section class="hero-gradient overflow-hidden bg-slate-50">
                    <div class="mx-auto grid max-w-7xl gap-10 px-4 py-16 sm:px-6 lg:grid-cols-[1.2fr_0.8fr] lg:items-center lg:px-8 lg:py-24">
                        <div class="space-y-6">
                            <p class="inline-flex items-center gap-2 rounded-full bg-emerald-50 px-4 py-2 text-sm font-medium text-emerald-700 ring-1 ring-emerald-100">Profil Nagari</p>
                            <div class="space-y-5">
                                <h1 class="max-w-2xl text-4xl font-semibold tracking-tight text-slate-900 sm:text-5xl">Membangun Nagari yang Ramah, Informasi Terupdate, dan Layanan Cepat.</h1>
                                <p class="max-w-xl text-base leading-8 text-slate-600">Temukan berita nagari, layanan publik, peraturan daerah, dan profil pemerintahan dalam satu tampilan modern yang mudah digunakan oleh semua warga.</p>
                            </div>
                            <div class="flex flex-col gap-4 sm:flex-row">
                                <a href="#berita" class="inline-flex justify-center rounded-full bg-emerald-700 px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-emerald-700/10 transition hover:bg-emerald-600">Baca Berita Terbaru</a>
                                <a href="#layanan" class="inline-flex justify-center rounded-full border border-slate-200 bg-white px-6 py-3 text-sm font-semibold text-slate-900 transition hover:border-emerald-700 hover:text-emerald-700">Lihat Layanan Publik</a>
                            </div>
                            <div class="grid gap-4 sm:grid-cols-1 max-w-xs">
                                <div class="rounded-3xl bg-white p-5 shadow-sm ring-1 ring-slate-200">
                                    <p class="text-xs uppercase tracking-[0.24em] text-slate-500">Warga</p>
                                    <p class="mt-2 text-2xl font-semibold text-slate-900">1.200+</p>
                                </div>
                            </div>
                        </div>
                        <div class="relative">
                            <div class="rounded-[2rem] bg-gradient-to-br from-emerald-700 via-cyan-500 to-sky-500 p-1 shadow-glow">
                                <div class="overflow-hidden rounded-[1.75rem] bg-white p-6 text-slate-900">
                                    <div class="flex items-center justify-between gap-4">
                                        <div>
                                            <p class="text-xs uppercase tracking-[0.3em] text-emerald-600">Nagari Kaciak Barat</p>
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
                        <h2 class="text-3xl font-semibold text-slate-900 sm:text-4xl">Profil Nagari Kaciak Barat</h2>
                        <p class="mx-auto max-w-2xl text-slate-600">Nagari Kaciak Barat berkomitmen menjadi nagari digital yang transparan, berdaya saing, dan memberikan layanan maksimal untuk semua lapisan masyarakat.</p>
                    </div>
                    <div class="grid gap-6 lg:grid-cols-3">
                        <article class="rounded-[2rem] border border-slate-200 bg-white p-8 shadow-sm">
                            <span class="inline-flex rounded-full bg-emerald-50 px-3 py-1 text-sm font-semibold text-emerald-700">Visi</span>
                            <h3 class="mt-6 text-xl font-semibold text-slate-900">Nagari Sejahtera dan Inovatif</h3>
                            <p class="mt-4 text-slate-600">Mewujudkan masyarakat maju, mandiri, dan digital dengan pelayanan cepat serta informasi akurat.</p>
                        </article>
                        <article class="rounded-[2rem] border border-slate-200 bg-white p-8 shadow-sm">
                            <span class="inline-flex rounded-full bg-emerald-50 px-3 py-1 text-sm font-semibold text-emerald-700">Misi</span>
                            <h3 class="mt-6 text-xl font-semibold text-slate-900">Pelayanan dan Kesejahteraan</h3>
                            <p class="mt-4 text-slate-600">Menyediakan layanan publik prima, membangun infrastruktur unggul, serta mendukung UMKM dan budaya lokal.</p>
                        </article>
                        <article class="rounded-[2rem] border border-slate-200 bg-white p-8 shadow-sm">
                            <span class="inline-flex rounded-full bg-emerald-50 px-3 py-1 text-sm font-semibold text-emerald-700">Nilai</span>
                            <h3 class="mt-6 text-xl font-semibold text-slate-900">Gotong Royalitas & Kebersamaan</h3>
                            <p class="mt-4 text-slate-600">Mendorong kolaborasi warga, transparansi, dan pembangunan yang berkelanjutan di nagari.</p>
                        </article>
                    </div>
                </section>

                <section id="berita" class="bg-slate-50 py-16">
                    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                        <div class="mb-10 flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
                            <div>
                                <p class="text-base font-semibold uppercase tracking-[0.3em] text-emerald-700">Berita Nagari</p>
                                <h2 class="mt-3 text-3xl font-semibold text-slate-900 sm:text-4xl">Berita Terkini dan Pengumuman</h2>
                            </div>
                            <a href="{{ route('news.page') }}" class="inline-flex items-center text-sm font-semibold text-emerald-700 hover:text-emerald-600">Lihat Semua Berita →</a>
                        </div>
                        <div class="grid gap-6 lg:grid-cols-3">
                            <article class="rounded-[2rem] bg-white p-6 shadow-sm ring-1 ring-slate-200">
                                <div class="mb-4 flex items-center justify-between rounded-3xl bg-emerald-50 px-4 py-2 text-sm text-emerald-700">
                                    <span>24 Juli 2026</span>
                                    <span class="rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold">Berita</span>
                                </div>
                                <h3 class="text-xl font-semibold text-slate-900">Pelatihan UMKM Nagari Sukses</h3>
                                <p class="mt-3 text-slate-600">Dinas nagari menggelar pelatihan pemasaran digital untuk pelaku usaha kecil dan menengah.</p>
                                <a href="{{ route('news.page') }}" class="mt-6 inline-flex text-sm font-semibold text-emerald-700 hover:text-emerald-600">Baca selengkapnya →</a>
                            </article>
                            <article class="rounded-[2rem] bg-white p-6 shadow-sm ring-1 ring-slate-200">
                                <div class="mb-4 flex items-center justify-between rounded-3xl bg-emerald-50 px-4 py-2 text-sm text-emerald-700">
                                    <span>18 Juli 2026</span>
                                    <span class="rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold">Agenda</span>
                                </div>
                                <h3 class="text-xl font-semibold text-slate-900">Festival Budaya Nagari</h3>
                                <p class="mt-3 text-slate-600">Ajang kebudayaan dan seni lokal hadir untuk mempromosikan tradisi dan kreativitas warga.</p>
                                <a href="{{ route('news.page') }}" class="mt-6 inline-flex text-sm font-semibold text-emerald-700 hover:text-emerald-600">Baca selengkapnya →</a>
                            </article>
                            <article class="rounded-[2rem] bg-white p-6 shadow-sm ring-1 ring-slate-200">
                                <div class="mb-4 flex items-center justify-between rounded-3xl bg-emerald-50 px-4 py-2 text-sm text-emerald-700">
                                    <span>12 Juli 2026</span>
                                    <span class="rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold">Informasi</span>
                                </div>
                                <h3 class="text-xl font-semibold text-slate-900">Perubahan Jadwal Pasar Mingguan</h3>
                                <p class="mt-3 text-slate-600">Pengumuman resmi jam operasional dan protokol kesehatan pasar nagari.</p>
                                <a href="{{ route('news.page') }}" class="mt-6 inline-flex text-sm font-semibold text-emerald-700 hover:text-emerald-600">Baca selengkapnya →</a>
                            </article>
                        </div>

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
                        <h2 class="mt-3 text-3xl font-semibold text-slate-900 sm:text-4xl">Layanan Nagari yang Mudah dan Terpercaya</h2>
                    </div>
                    <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-4">
                        <div class="rounded-[2rem] border border-slate-200 bg-white p-8 shadow-sm">
                            <div class="inline-flex h-12 w-12 items-center justify-center rounded-3xl bg-emerald-50 text-emerald-700">📄</div>
                            <h3 class="mt-6 text-xl font-semibold text-slate-900">Surat Keterangan</h3>
                            <p class="mt-4 text-slate-600">Proses cepat untuk surat keterangan domisili, usaha, dan administrasi lainnya.</p>
                        </div>
                        <div class="rounded-[2rem] border border-slate-200 bg-white p-8 shadow-sm">
                            <div class="inline-flex h-12 w-12 items-center justify-center rounded-3xl bg-emerald-50 text-emerald-700">🗳</div>
                            <h3 class="mt-6 text-xl font-semibold text-slate-900">Pelayanan Desa</h3>
                            <p class="mt-4 text-slate-600">Informasi pendaftaran program pemerintah dan agenda musyawarah nagari.</p>
                        </div>
                        <div class="rounded-[2rem] border border-slate-200 bg-white p-8 shadow-sm">
                            <div class="inline-flex h-12 w-12 items-center justify-center rounded-3xl bg-emerald-50 text-emerald-700">💬</div>
                            <h3 class="mt-6 text-xl font-semibold text-slate-900">Pengaduan Online</h3>
                            <p class="mt-4 text-slate-600">Laporkan keluhan dan saran langsung ke kantor nagari dengan mudah.</p>
                        </div>
                        <div class="rounded-[2rem] border border-slate-200 bg-white p-8 shadow-sm">
                            <div class="inline-flex h-12 w-12 items-center justify-center rounded-3xl bg-emerald-50 text-emerald-700">📣</div>
                            <h3 class="mt-6 text-xl font-semibold text-slate-900">Informasi Publik</h3>
                            <p class="mt-4 text-slate-600">Akses data nagari, pengumuman, dan peraturan dalam satu halaman.</p>
                        </div>
                    </div>
                </section>

                <section id="peraturan" class="bg-emerald-700 py-16 text-white">
                    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                        <div class="mb-10 text-center">
                            <p class="text-sm font-semibold uppercase tracking-[0.3em] text-emerald-100">Peraturan</p>
                            <h2 class="mt-3 text-3xl font-semibold">Dokumen Resmi Nagari</h2>
                            <p class="mx-auto mt-3 max-w-2xl text-slate-100/90">Akses mudah ke peraturan, keputusan, dan pedoman penting bagi warga nagari.</p>
                        </div>
                        <div class="grid gap-6 md:grid-cols-3">
                            <article class="rounded-[2rem] bg-emerald-600 p-6 shadow-xl shadow-emerald-900/20">
                                <h3 class="text-xl font-semibold">Peraturan Nagari 2026</h3>
                                <p class="mt-4 text-slate-100/90">Aturan terbaru tentang tata ruang, lingkungan, dan pelayanan publik nagari.</p>
                                <a href="#" class="mt-6 inline-flex text-sm font-semibold text-white/90 hover:text-white">Download PDF →</a>
                            </article>
                            <article class="rounded-[2rem] bg-emerald-600 p-6 shadow-xl shadow-emerald-900/20">
                                <h3 class="text-xl font-semibold">Panduan Layanan</h3>
                                <p class="mt-4 text-slate-100/90">Alur layanan administrasi dan syarat dokumen untuk warga nagari.</p>
                                <a href="#" class="mt-6 inline-flex text-sm font-semibold text-white/90 hover:text-white">Download PDF →</a>
                            </article>
                            <article class="rounded-[2rem] bg-emerald-600 p-6 shadow-xl shadow-emerald-900/20">
                                <h3 class="text-xl font-semibold">SK Kepala Nagari</h3>
                                <p class="mt-4 text-slate-100/90">Keputusan terbaru kepala nagari tentang program pemberdayaan masyarakat.</p>
                                <a href="#" class="mt-6 inline-flex text-sm font-semibold text-white/90 hover:text-white">Download PDF →</a>
                            </article>
                        </div>
                    </div>
                </section>

                <section id="kontak" class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8">
                    <div class="grid gap-12 lg:grid-cols-2">
                        <div>
                            <p class="text-base font-semibold uppercase tracking-[0.3em] text-emerald-700">Kontak Kami</p>
                            <h2 class="mt-3 text-3xl font-semibold text-slate-900 sm:text-4xl">Temui Tim Nagari dan Dapatkan Bantuan</h2>
                            <p class="mt-4 text-slate-600">Kantor Nagari Kaciak Barat siap melayani aspirasi, permohonan dokumen, dan informasi publik setiap hari kerja.</p>
                            <div class="mt-10 space-y-6 rounded-[2rem] border border-slate-200 bg-white p-8 shadow-sm">
                                <div class="flex items-start gap-4">
                                    <div class="mt-1 inline-flex h-12 w-12 items-center justify-center rounded-3xl bg-emerald-50 text-emerald-700">📍</div>
                                    <div>
                                        <p class="font-semibold text-slate-900">Alamat</p>
                                        <p class="mt-1 text-slate-600">Jalan Raya Nagari No.12, Kaciak Barat, Kabupaten Pasaman, Sumatera Barat.</p>
                                    </div>
                                </div>
                                <div class="flex items-start gap-4">
                                    <div class="mt-1 inline-flex h-12 w-12 items-center justify-center rounded-3xl bg-emerald-50 text-emerald-700">📞</div>
                                    <div>
                                        <p class="font-semibold text-slate-900">Telepon</p>
                                        <p class="mt-1 text-slate-600">(0753) 20202, 20281</p>
                                    </div>
                                </div>
                                <div class="flex items-start gap-4">
                                    <div class="mt-1 inline-flex h-12 w-12 items-center justify-center rounded-3xl bg-emerald-50 text-emerald-700">✉️</div>
                                    <div>
                                        <p class="font-semibold text-slate-900">Email</p>
                                        <p class="mt-1 text-slate-600">admin@nagari.go.id</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="rounded-[2rem] bg-slate-900 p-8 text-white shadow-xl shadow-slate-900/20">
                            <p class="text-sm uppercase tracking-[0.3em] text-emerald-300">Kirim Pesan</p>
                            <h3 class="mt-4 text-2xl font-semibold">Ajukan Pertanyaan atau Sampaikan Usulan</h3>
                            <form action="#" class="mt-8 space-y-6">
                                <div>
                                    <label class="block text-sm font-medium text-slate-200">Nama</label>
                                    <input type="text" placeholder="Nama lengkap" class="mt-3 w-full rounded-3xl border border-slate-700 bg-slate-950/70 px-4 py-3 text-sm text-white placeholder:text-slate-500 focus:border-emerald-400 focus:outline-none focus:ring-4 focus:ring-emerald-500/10" />
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-slate-200">Email</label>
                                    <input type="email" placeholder="email@domain.com" class="mt-3 w-full rounded-3xl border border-slate-700 bg-slate-950/70 px-4 py-3 text-sm text-white placeholder:text-slate-500 focus:border-emerald-400 focus:outline-none focus:ring-4 focus:ring-emerald-500/10" />
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-slate-200">Pesan</label>
                                    <textarea rows="4" placeholder="Tuliskan pesan Anda" class="mt-3 w-full rounded-3xl border border-slate-700 bg-slate-950/70 px-4 py-3 text-sm text-white placeholder:text-slate-500 focus:border-emerald-400 focus:outline-none focus:ring-4 focus:ring-emerald-500/10"></textarea>
                                </div>
                                <button type="submit" class="inline-flex w-full items-center justify-center rounded-full bg-emerald-500 px-5 py-3 text-sm font-semibold text-white transition hover:bg-emerald-400">Kirim Pesan</button>
                            </form>
                        </div>
                    </div>
                </section>
            </main>
            <footer class="border-t border-slate-200 bg-white py-8">
                <div class="mx-auto flex max-w-7xl flex-col gap-6 px-4 sm:px-6 lg:px-8 lg:flex-row lg:items-center lg:justify-between">
                    <p class="text-sm text-slate-600">© 2026 Nagari Kaciak Barat. Semua hak dilindungi.</p>
                    <div class="flex flex-wrap items-center gap-4 text-sm text-slate-500">
                        <a href="#profil" class="hover:text-emerald-700">Profil</a>
                        <a href="#berita" class="hover:text-emerald-700">Berita</a>
                        <a href="#layanan" class="hover:text-emerald-700">Layanan</a>
                        <a href="#kontak" class="hover:text-emerald-700">Kontak</a>
                    </div>
                </div>
            </footer>
        </div>
    </body>
    <script>
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
</html>
