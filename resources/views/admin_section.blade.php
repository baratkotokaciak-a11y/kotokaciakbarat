<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <title>Edit {{ $sectionTitle }} - Admin Nagari</title>
        <link rel="preconnect" href="https://fonts.bunny.net" />
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css'])
        @else
            <style>
                html { scroll-behavior: smooth; }
                body { font-family: 'Instrument Sans', ui-sans-serif, system-ui, sans-serif; background: #f8fafc; color: #0f172a; }
                .input, .textarea { width: 100%; border: 1px solid #cbd5e1; border-radius: 1rem; padding: 1rem; background: white; color: #0f172a; }
                .input:focus, .textarea:focus { outline: none; border-color: #22c55e; box-shadow: 0 0 0 4px rgba(34,197,94,.12); }
                .button { display: inline-flex; align-items: center; justify-content: center; gap: .5rem; padding: .9rem 1.6rem; border-radius: 9999px; background: #047857; color: white; font-weight: 600; border: none; cursor: pointer; }
                .button.secondary { background: white; color: #047857; border: 1px solid #d1d5db; }
                .card { background: white; border-radius: 1.75rem; padding: 2rem; box-shadow: 0 10px 30px rgba(15,23,42,.08); }
                .badge { display: inline-flex; align-items: center; padding: .4rem .75rem; background: #ecfdf5; color: #166534; border-radius: 9999px; font-size: .75rem; text-transform: uppercase; letter-spacing:.12em; }
            </style>
        @endif
    </head>
    <body>
        <div class="mx-auto max-w-5xl p-6">
            <header class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
                <div>
                    <p class="badge">Admin Panel</p>
                    <h1 class="mt-3 text-3xl font-semibold">Edit {{ $sectionTitle }}</h1>
                    <p class="mt-2 text-slate-600 max-w-2xl">Halaman ini khusus untuk memperbarui data {{ strtolower($sectionTitle) }} pada halaman profil nagari.</p>
                </div>
                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('admin.edit') }}" class="button secondary">Kembali ke Dashboard</a>
                    <a href="{{ url('/') }}" class="button secondary">Lihat Halaman Publik</a>
                </div>
            </header>

            @if(session('success'))
                <div class="mb-6 rounded-3xl bg-emerald-50 px-6 py-4 text-emerald-800">{{ session('success') }}</div>
            @endif

            @if($errors->any())
                <div class="mb-6 rounded-3xl bg-rose-50 px-6 py-4 text-rose-800">
                    <ul class="list-disc pl-5">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.section.save', ['section' => $section]) }}" method="POST" enctype="multipart/form-data">
                @csrf
<div class="space-y-6">
                    @if($section === 'banner')
                        <section class="card">
                            <p class="mb-6 text-slate-600">Atur banner yang tampil di bagian paling atas halaman utama. Anda dapat memasukkan URL gambar atau mengunggah file gambar langsung.</p>
                            <div class="grid gap-6 lg:grid-cols-2">
                                <label class="block">
                                    <span class="mb-2 block font-medium text-slate-700">Badge</span>
                                    <input class="input" type="text" name="banner_badge" value="{{ old('banner_badge', $data['banner']['badge'] ?? 'Selamat Datang') }}" placeholder="Contoh: Selamat Datang" />
                                </label>
                                <label class="block">
                                    <span class="mb-2 block font-medium text-slate-700">Judul Banner</span>
                                    <input class="input" type="text" name="banner_title" value="{{ old('banner_title', $data['banner']['title'] ?? ($data['header']['site_name'] ?? 'Nagari Koto Kaciak Barat')) }}" placeholder="Contoh: Nagari Koto Kaciak Barat" />
                                </label>
                                <label class="block lg:col-span-2">
                                    <span class="mb-2 block font-medium text-slate-700">Subjudul Banner</span>
                                    <textarea class="textarea" rows="4" name="banner_subtitle">{{ old('banner_subtitle', $data['banner']['subtitle'] ?? ($data['hero_subtitle'] ?? '')) }}</textarea>
                                </label>
                                <label class="block lg:col-span-2">
                                    <span class="mb-2 block font-medium text-slate-700">URL Gambar Banner</span>
                                    <input class="input" type="text" name="banner_image" value="{{ old('banner_image', $data['banner']['image'] ?? '') }}" placeholder="https://.../banner.jpg" />
                                </label>
                                <label class="block lg:col-span-2">
                                    <span class="mb-2 block font-medium text-slate-700">Upload Gambar Banner</span>
                                    <input class="input" type="file" name="banner_image_file" accept="image/*" />
                                </label>
                            </div>
                            @if(!empty($data['banner']['image']))
                                <div class="mt-6">
                                    <p class="mb-3 text-sm font-medium text-slate-700">Pratinjau Banner Saat Ini</p>
                                    <div class="relative h-48 overflow-hidden rounded-3xl ring-1 ring-slate-200">
                                        <img src="{{ $data['banner']['image'] }}" alt="Pratinjau Banner" class="h-full w-full object-cover" />
                                    </div>
                                </div>
                            @endif
                        </section>
                    @elseif($section === 'hero')
                        <section class="card">
                            <div class="grid gap-6 lg:grid-cols-2">
                                <label class="block">
                                    <span class="mb-2 block font-medium text-slate-700">Judul Hero</span>
                                    <input class="input" type="text" name="hero_title" value="{{ old('hero_title', $data['hero_title'] ?? '') }}" />
                                </label>
                                <label class="block">
                                    <span class="mb-2 block font-medium text-slate-700">Subjudul Hero</span>
                                    <textarea class="textarea" rows="5" name="hero_subtitle">{{ old('hero_subtitle', $data['hero_subtitle'] ?? '') }}</textarea>
                                </label>
                            </div>
                        </section>
                    @elseif($section === 'stats')
                        <section class="card">
                            <p class="mb-4 text-slate-600">Masukkan setiap baris dalam format <strong>Label|Nilai</strong>.</p>
                            <textarea class="textarea" rows="8" name="stats_text">{{ old('stats_text', $data['stats_text'] ?? '') }}</textarea>
                        </section>
                    @elseif($section === 'devices')
                        <section class="card">
                            <div class="flex items-center justify-between gap-4">
                                <div>
                                    <p class="text-sm text-slate-500">Kelola nama, jabatan, dan foto setiap perangkat nagari.</p>
                                </div>
                                <button type="button" id="add-device" class="button secondary">Tambah Perangkat</button>
                            </div>

                            <div class="mt-6 space-y-4" id="device-forms">
                                @php
                                    $deviceRows = old('devices', $data['devices'] ?? []);
                                    if (empty($deviceRows)) {
                                        $deviceRows = [[
                                            'name' => '',
                                            'position' => '',
                                            'image' => '',
                                        ]];
                                    }
                                @endphp

                                @foreach($deviceRows as $index => $device)
                                    <div class="rounded-3xl border border-slate-200 bg-slate-50 p-6 shadow-sm device-row">
                                        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                                            <div>
                                                <p class="text-sm font-semibold text-slate-900">Perangkat {{ $index + 1 }}</p>
                                            </div>
                                            <button type="button" class="button secondary remove-device">Hapus</button>
                                        </div>
                                        <div class="mt-6 grid gap-4 lg:grid-cols-3">
                                            <label class="block">
                                                <span class="mb-2 block text-sm font-medium text-slate-700">Nama</span>
                                                <input class="input" type="text" name="devices[{{ $index }}][name]" value="{{ $device['name'] ?? '' }}" placeholder="Contoh: Reza Fahlevi, S.H., M.H." />
                                            </label>
                                            <label class="block">
                                                <span class="mb-2 block text-sm font-medium text-slate-700">Jabatan</span>
                                                <input class="input" type="text" name="devices[{{ $index }}][position]" value="{{ $device['position'] ?? '' }}" placeholder="Contoh: Wali Nagari" />
                                            </label>
                                            <label class="block">
                                                <span class="mb-2 block text-sm font-medium text-slate-700">URL Foto</span>
                                                <input class="input" type="text" name="devices[{{ $index }}][image]" value="{{ $device['image'] ?? '' }}" placeholder="https://.../foto.jpg" />
                                            </label>
                                            <label class="block">
                                                <span class="mb-2 block text-sm font-medium text-slate-700">Upload Foto</span>
                                                <input class="input" type="file" name="device_images[{{ $index }}]" accept="image/*" />
                                            </label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <template id="device-row-template">
                                <div class="rounded-3xl border border-slate-200 bg-slate-50 p-6 shadow-sm device-row">
                                    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                                        <div>
                                            <p class="text-sm font-semibold text-slate-900">Perangkat <span class="device-index"></span></p>
                                        </div>
                                        <button type="button" class="button secondary remove-device">Hapus</button>
                                    </div>
                                    <div class="mt-6 grid gap-4 lg:grid-cols-3">
                                        <label class="block">
                                            <span class="mb-2 block text-sm font-medium text-slate-700">Nama</span>
                                            <input class="input" type="text" name="devices[__INDEX__][name]" placeholder="Contoh: Reza Fahlevi, S.H., M.H." />
                                        </label>
                                        <label class="block">
                                            <span class="mb-2 block text-sm font-medium text-slate-700">Jabatan</span>
                                            <input class="input" type="text" name="devices[__INDEX__][position]" placeholder="Contoh: Wali Nagari" />
                                        </label>
                                        <label class="block">
                                            <span class="mb-2 block text-sm font-medium text-slate-700">URL Foto</span>
                                            <input class="input" type="text" name="devices[__INDEX__][image]" placeholder="https://.../foto.jpg" />
                                        </label>
                                        <label class="block">
                                            <span class="mb-2 block text-sm font-medium text-slate-700">Upload Foto</span>
                                            <input class="input" type="file" name="device_images[__INDEX__]" accept="image/*" />
                                        </label>
                                    </div>
                                </div>
                            </template>
                        </section>
                    @elseif($section === 'news')
                        <section class="card">
                            <div class="flex items-center justify-between gap-4">
                                <div>
                                    <h2 class="text-xl font-semibold">Berita</h2>
                                    <p class="mt-2 text-sm text-slate-500">Tambahkan berita dan unggah gambar untuk setiap item yang tampil di profil.</p>
                                </div>
                                <button type="button" id="add-news" class="button secondary">Tambah Berita</button>
                            </div>

                            <div class="mt-6 space-y-4" id="news-forms">
                                @php
                                    $newsRows = old('news', $data['news'] ?? []);
                                    if (empty($newsRows)) {
                                        $newsRows = [[
                                            'date' => '',
                                            'type' => '',
                                            'title' => '',
                                            'summary' => '',
                                            'image' => '',
                                        ]];
                                    }
                                @endphp

                                @foreach($newsRows as $index => $newsItem)
                                    <div class="rounded-3xl border border-slate-200 bg-slate-50 p-6 shadow-sm news-row">
                                        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                                            <div>
                                                <p class="text-sm font-semibold text-slate-900">Berita {{ $index + 1 }}</p>
                                                <p class="text-sm text-slate-500">Isi detail berita lalu pilih gambar jika ingin ditampilkan.</p>
                                            </div>
                                            <button type="button" class="button secondary remove-news">Hapus</button>
                                        </div>
                                        <div class="mt-6 grid gap-4 lg:grid-cols-2">
                                            <label class="block">
                                                <span class="mb-2 block text-sm font-medium text-slate-700">Tanggal</span>
                                                <input class="input" type="text" name="news[{{ $index }}][date]" value="{{ $newsItem['date'] ?? '' }}" placeholder="Contoh: 24 Juli 2026" />
                                            </label>
                                            <label class="block">
                                                <span class="mb-2 block text-sm font-medium text-slate-700">Tipe</span>
                                                <input class="input" type="text" name="news[{{ $index }}][type]" value="{{ $newsItem['type'] ?? '' }}" placeholder="Contoh: Berita" />
                                            </label>
                                            <label class="block lg:col-span-2">
                                                <span class="mb-2 block text-sm font-medium text-slate-700">Judul</span>
                                                <input class="input" type="text" name="news[{{ $index }}][title]" value="{{ $newsItem['title'] ?? '' }}" placeholder="Judul berita" />
                                            </label>
                                            <label class="block lg:col-span-2">
                                                <span class="mb-2 block text-sm font-medium text-slate-700">Ringkasan</span>
                                                <textarea class="textarea" rows="4" name="news[{{ $index }}][summary]">{{ $newsItem['summary'] ?? '' }}</textarea>
                                            </label>
                                                <label class="block lg:col-span-2">
                                                    <span class="mb-2 block text-sm font-medium text-slate-700">Konten Lengkap</span>
                                                    <textarea id="news-body-{{ $index }}" class="textarea wysiwyg" rows="6" name="news[{{ $index }}][body]">{{ $newsItem['body'] ?? '' }}</textarea>
                                                </label>
                                            <label class="block">
                                                <span class="mb-2 block text-sm font-medium text-slate-700">URL Gambar</span>
                                                <input class="input" type="text" name="news[{{ $index }}][image]" value="{{ $newsItem['image'] ?? '' }}" placeholder="https://.../gambar.jpg" />
                                            </label>
                                            <label class="block">
                                                <span class="mb-2 block text-sm font-medium text-slate-700">Upload Gambar</span>
                                                <input class="input" type="file" name="news_images[{{ $index }}]" accept="image/*" />
                                            </label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <template id="news-row-template">
                                <div class="rounded-3xl border border-slate-200 bg-slate-50 p-6 shadow-sm news-row">
                                    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                                        <div>
                                            <p class="text-sm font-semibold text-slate-900">Berita <span class="news-index"></span></p>
                                            <p class="text-sm text-slate-500">Isi detail berita lalu pilih gambar jika ingin ditampilkan.</p>
                                        </div>
                                        <button type="button" class="button secondary remove-news">Hapus</button>
                                    </div>
                                    <div class="mt-6 grid gap-4 lg:grid-cols-2">
                                        <label class="block">
                                            <span class="mb-2 block text-sm font-medium text-slate-700">Tanggal</span>
                                            <input class="input" type="text" name="news[__INDEX__][date]" placeholder="Contoh: 24 Juli 2026" />
                                        </label>
                                        <label class="block">
                                            <span class="mb-2 block text-sm font-medium text-slate-700">Tipe</span>
                                            <input class="input" type="text" name="news[__INDEX__][type]" placeholder="Contoh: Berita" />
                                        </label>
                                        <label class="block lg:col-span-2">
                                            <span class="mb-2 block text-sm font-medium text-slate-700">Judul</span>
                                            <input class="input" type="text" name="news[__INDEX__][title]" placeholder="Judul berita" />
                                        </label>
                                        <label class="block lg:col-span-2">
                                            <span class="mb-2 block text-sm font-medium text-slate-700">Ringkasan</span>
                                            <textarea class="textarea" rows="4" name="news[__INDEX__][summary]"></textarea>
                                        </label>
                                        <label class="block lg:col-span-2">
                                            <span class="mb-2 block text-sm font-medium text-slate-700">Konten Lengkap</span>
                                            <textarea id="news-body-__INDEX__" class="textarea wysiwyg" rows="6" name="news[__INDEX__][body]"></textarea>
                                        </label>
                                        <label class="block">
                                            <span class="mb-2 block text-sm font-medium text-slate-700">URL Gambar</span>
                                            <input class="input" type="text" name="news[__INDEX__][image]" placeholder="https://.../gambar.jpg" />
                                        </label>
                                        <label class="block">
                                            <span class="mb-2 block text-sm font-medium text-slate-700">Upload Gambar</span>
                                            <input class="input" type="file" name="news_images[__INDEX__]" accept="image/*" />
                                        </label>
                                    </div>
                                </div>
                            </template>
                        </section>
                    @elseif($section === 'services')
                        <section class="card">
                            <p class="mb-4 text-slate-600">Masukkan setiap baris dalam format <strong>Emoji|Judul|Deskripsi</strong>.</p>
                            <textarea class="textarea" rows="8" name="services_text">{{ old('services_text', $data['services_text'] ?? '') }}</textarea>
                        </section>
                    @elseif($section === 'regulations')
                        <section class="card">
                            <p class="mb-4 text-slate-600">Masukkan setiap baris dalam format <strong>Judul|Deskripsi</strong>.</p>
                            <textarea class="textarea" rows="8" name="regulations_text">{{ old('regulations_text', $data['regulations_text'] ?? '') }}</textarea>
                        </section>
                    @elseif($section === 'contact')
                        <section class="card">
                            <div class="grid gap-6 lg:grid-cols-3">
                                <label class="block">
                                    <span class="mb-2 block font-medium text-slate-700">Alamat</span>
                                    <input class="input" type="text" name="contact_address" value="{{ old('contact_address', $data['contact']['address'] ?? '') }}" />
                                </label>
                                <label class="block">
                                    <span class="mb-2 block font-medium text-slate-700">Telepon</span>
                                    <input class="input" type="text" name="contact_phone" value="{{ old('contact_phone', $data['contact']['phone'] ?? '') }}" />
                                </label>
                                <label class="block">
                                    <span class="mb-2 block font-medium text-slate-700">Email</span>
                                    <input class="input" type="email" name="contact_email" value="{{ old('contact_email', $data['contact']['email'] ?? '') }}" />
                                </label>
                            </div>
                        </section>
                    @elseif($section === 'profile')
                        <section class="card">
                            <div class="grid gap-6 lg:grid-cols-2">
                                <label class="block">
                                    <span class="mb-2 block font-medium text-slate-700">Visi</span>
                                    <input class="input" type="text" name="profile_visi" value="{{ old('profile_visi', $data['profile']['visi'] ?? '') }}" placeholder="Contoh: Nagari Sejahtera dan Inovatif" />
                                </label>
                                <label class="block">
                                    <span class="mb-2 block font-medium text-slate-700">Nilai</span>
                                    <input class="input" type="text" name="profile_nilai" value="{{ old('profile_nilai', $data['profile']['nilai'] ?? '') }}" placeholder="Contoh: Gotong Royong & Kebersamaan" />
                                </label>
                            </div>
                            <div class="mt-6">
                                <label class="block">
                                    <span class="mb-2 block font-medium text-slate-700">Misi</span>
                                    <textarea class="textarea" rows="4" name="profile_misi" placeholder="Contoh: Menyediakan layanan publik prima, membangun infrastruktur unggul, serta mendukung UMKM dan budaya lokal.">{{ old('profile_misi', $data['profile']['misi'] ?? '') }}</textarea>
                                </label>
                            </div>
                            <div class="mt-6">
                                <label class="block">
                                    <span class="mb-2 block font-medium text-slate-700">Sejarah Nagari</span>
                                    <textarea class="textarea" rows="6" name="profile_sejarah" placeholder="Masukkan sejarah singkat nagari...">{{ old('profile_sejarah', $data['profile']['sejarah'] ?? '') }}</textarea>
                                </label>
                            </div>
                            <div class="mt-6">
                                <label class="block">
                                    <span class="mb-2 block font-medium text-slate-700">Deskripsi Wilayah</span>
                                    <input class="input" type="text" name="profile_wilayah" value="{{ old('profile_wilayah', $data['profile']['wilayah'] ?? '') }}" placeholder="Contoh: Nagari Koto Kaciak Barat terdiri dari 4 jorong" />
                                </label>
                            </div>
                        </section>
                    @elseif($section === 'header')
                        <section class="card">
                            <div class="grid gap-6 lg:grid-cols-2">
                                <label class="block">
                                    <span class="mb-2 block font-medium text-slate-700">Nama Situs</span>
                                    <input class="input" type="text" name="site_name" value="{{ old('site_name', $data['header']['site_name'] ?? 'Nagari Koto Kaciak Barat') }}" placeholder="Contoh: Nagari Koto Kaciak Barat" />
                                </label>
                                <label class="block">
                                    <span class="mb-2 block font-medium text-slate-700">Subtitle Situs</span>
                                    <input class="input" type="text" name="site_subtitle" value="{{ old('site_subtitle', $data['header']['site_subtitle'] ?? 'Kec. Bonjol, Kab. Pasaman') }}" placeholder="Contoh: Kec. Bonjol, Kab. Pasaman" />
                                </label>
                            </div>
                            <div class="mt-6">
                                <label class="block">
                                    <span class="mb-2 block font-medium text-slate-700">Menu Navigasi</span>
                                    <p class="mb-2 text-sm text-slate-500">Masukkan setiap baris dalam format <strong>Nama|Link</strong></p>
                                    <textarea class="textarea" rows="6" name="nav_items" placeholder="Profil|#profil&#10;Berita|#berita&#10;Layanan|#layanan">{{ old('nav_items', $data['header']['nav_items'] ?? "Profil|#profil\nBerita|#berita\nLayanan|#layanan\nPeraturan|#peraturan\nKontak|#kontak") }}</textarea>
                                </label>
                            </div>
                        </section>
                    @elseif($section === 'content')
                        <section class="card">
                            <p class="mb-6 text-slate-600">Edit judul dan deskripsi untuk setiap section di halaman utama.</p>
                            
                            <div class="space-y-8">
                                <div class="rounded-2xl border border-slate-200 bg-slate-50 p-6">
                                    <h4 class="mb-4 text-lg font-semibold text-slate-900">Section Profil</h4>
                                    <div class="grid gap-4">
                                        <label class="block">
                                            <span class="mb-2 block text-sm font-medium text-slate-700">Judul</span>
                                            <input class="input" type="text" name="section_profile_title" value="{{ old('section_profile_title', $data['content_sections']['profile']['title'] ?? 'Profil Nagari Koto Kaciak Barat') }}" />
                                        </label>
                                        <label class="block">
                                            <span class="mb-2 block text-sm font-medium text-slate-700">Deskripsi</span>
                                            <textarea class="textarea" rows="3" name="section_profile_desc">{{ old('section_profile_desc', $data['content_sections']['profile']['description'] ?? 'Nagari Koto Kaciak Barat berkomitmen menjadi nagari digital yang transparan.') }}</textarea>
                                        </label>
                                    </div>
                                </div>

                                <div class="rounded-2xl border border-slate-200 bg-slate-50 p-6">
                                    <h4 class="mb-4 text-lg font-semibold text-slate-900">Section Perangkat Nagari</h4>
                                    <div class="grid gap-4">
                                        <label class="block">
                                            <span class="mb-2 block text-sm font-medium text-slate-700">Judul</span>
                                            <input class="input" type="text" name="section_devices_title" value="{{ old('section_devices_title', $data['content_sections']['devices']['title'] ?? 'Pejabat Utama dan Perangkat Nagari') }}" />
                                        </label>
                                        <label class="block">
                                            <span class="mb-2 block text-sm font-medium text-slate-700">Deskripsi</span>
                                            <textarea class="textarea" rows="3" name="section_devices_desc">{{ old('section_devices_desc', $data['content_sections']['devices']['description'] ?? 'Daftar pejabat utama dan perangkat nagari.') }}</textarea>
                                        </label>
                                    </div>
                                </div>

                                <div class="rounded-2xl border border-slate-200 bg-slate-50 p-6">
                                    <h4 class="mb-4 text-lg font-semibold text-slate-900">Section Berita</h4>
                                    <div class="grid gap-4">
                                        <label class="block">
                                            <span class="mb-2 block text-sm font-medium text-slate-700">Judul</span>
                                            <input class="input" type="text" name="section_news_title" value="{{ old('section_news_title', $data['content_sections']['news']['title'] ?? 'Berita Terbaru') }}" />
                                        </label>
                                        <label class="block">
                                            <span class="mb-2 block text-sm font-medium text-slate-700">Deskripsi</span>
                                            <textarea class="textarea" rows="3" name="section_news_desc">{{ old('section_news_desc', $data['content_sections']['news']['description'] ?? 'Informasi terkini seputar kegiatan nagari.') }}</textarea>
                                        </label>
                                    </div>
                                </div>

                                <div class="rounded-2xl border border-slate-200 bg-slate-50 p-6">
                                    <h4 class="mb-4 text-lg font-semibold text-slate-900">Section Layanan</h4>
                                    <div class="grid gap-4">
                                        <label class="block">
                                            <span class="mb-2 block text-sm font-medium text-slate-700">Judul</span>
                                            <input class="input" type="text" name="section_services_title" value="{{ old('section_services_title', $data['content_sections']['services']['title'] ?? 'Layanan Publik') }}" />
                                        </label>
                                        <label class="block">
                                            <span class="mb-2 block text-sm font-medium text-slate-700">Deskripsi</span>
                                            <textarea class="textarea" rows="3" name="section_services_desc">{{ old('section_services_desc', $data['content_sections']['services']['description'] ?? 'Berbagai layanan publik yang tersedia.') }}</textarea>
                                        </label>
                                    </div>
                                </div>

                                <div class="rounded-2xl border border-slate-200 bg-slate-50 p-6">
                                    <h4 class="mb-4 text-lg font-semibold text-slate-900">Section Peraturan</h4>
                                    <div class="grid gap-4">
                                        <label class="block">
                                            <span class="mb-2 block text-sm font-medium text-slate-700">Judul</span>
                                            <input class="input" type="text" name="section_regulations_title" value="{{ old('section_regulations_title', $data['content_sections']['regulations']['title'] ?? 'Peraturan Daerah') }}" />
                                        </label>
                                        <label class="block">
                                            <span class="mb-2 block text-sm font-medium text-slate-700">Deskripsi</span>
                                            <textarea class="textarea" rows="3" name="section_regulations_desc">{{ old('section_regulations_desc', $data['content_sections']['regulations']['description'] ?? 'Kumpulan peraturan dan kebijakan nagari.') }}</textarea>
                                        </label>
                                    </div>
                                </div>

                                <div class="rounded-2xl border border-slate-200 bg-slate-50 p-6">
                                    <h4 class="mb-4 text-lg font-semibold text-slate-900">Section Kontak</h4>
                                    <div class="grid gap-4">
                                        <label class="block">
                                            <span class="mb-2 block text-sm font-medium text-slate-700">Judul</span>
                                            <input class="input" type="text" name="section_contact_title" value="{{ old('section_contact_title', $data['content_sections']['contact']['title'] ?? 'Hubungi Kami') }}" />
                                        </label>
                                        <label class="block">
                                            <span class="mb-2 block text-sm font-medium text-slate-700">Deskripsi</span>
                                            <textarea class="textarea" rows="3" name="section_contact_desc">{{ old('section_contact_desc', $data['content_sections']['contact']['description'] ?? 'Sampaikan pertanyaan, saran, atau keluhan Anda.') }}</textarea>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </section>
                    @elseif($section === 'buttons')
                        <section class="card">
                            <p class="mb-6 text-slate-600">Edit teks dan link untuk tombol-tombol di seluruh halaman.</p>
                            
                            <div class="space-y-8">
                                <div class="rounded-2xl border border-slate-200 bg-slate-50 p-6">
                                    <h4 class="mb-4 text-lg font-semibold text-slate-900">Tombol Hero Utama</h4>
                                    <div class="grid gap-4 lg:grid-cols-2">
                                        <label class="block">
                                            <span class="mb-2 block text-sm font-medium text-slate-700">Teks Tombol</span>
                                            <input class="input" type="text" name="hero_button_primary_text" value="{{ old('hero_button_primary_text', $data['buttons']['hero_primary']['text'] ?? 'Baca Berita Terbaru') }}" />
                                        </label>
                                        <label class="block">
                                            <span class="mb-2 block text-sm font-medium text-slate-700">Link Tombol</span>
                                            <input class="input" type="text" name="hero_button_primary_link" value="{{ old('hero_button_primary_link', $data['buttons']['hero_primary']['link'] ?? '#berita') }}" />
                                        </label>
                                    </div>
                                </div>

                                <div class="rounded-2xl border border-slate-200 bg-slate-50 p-6">
                                    <h4 class="mb-4 text-lg font-semibold text-slate-900">Tombol Hero Sekunder</h4>
                                    <div class="grid gap-4 lg:grid-cols-2">
                                        <label class="block">
                                            <span class="mb-2 block text-sm font-medium text-slate-700">Teks Tombol</span>
                                            <input class="input" type="text" name="hero_button_secondary_text" value="{{ old('hero_button_secondary_text', $data['buttons']['hero_secondary']['text'] ?? 'Lihat Layanan Publik') }}" />
                                        </label>
                                        <label class="block">
                                            <span class="mb-2 block text-sm font-medium text-slate-700">Link Tombol</span>
                                            <input class="input" type="text" name="hero_button_secondary_link" value="{{ old('hero_button_secondary_link', $data['buttons']['hero_secondary']['link'] ?? '#layanan') }}" />
                                        </label>
                                    </div>
                                </div>

                                <div class="rounded-2xl border border-slate-200 bg-slate-50 p-6">
                                    <h4 class="mb-4 text-lg font-semibold text-slate-900">Tombol Kontak</h4>
                                    <label class="block">
                                        <span class="mb-2 block text-sm font-medium text-slate-700">Teks Tombol</span>
                                        <input class="input" type="text" name="contact_button_text" value="{{ old('contact_button_text', $data['buttons']['contact']['text'] ?? 'Hubungi') }}" />
                                    </label>
                                </div>

                                <div class="rounded-2xl border border-slate-200 bg-slate-50 p-6">
                                    <h4 class="mb-4 text-lg font-semibold text-slate-900">Tombol Edit Profil</h4>
                                    <label class="block">
                                        <span class="mb-2 block text-sm font-medium text-slate-700">Teks Tombol</span>
                                        <input class="input" type="text" name="edit_profile_button_text" value="{{ old('edit_profile_button_text', $data['buttons']['edit_profile']['text'] ?? 'Edit Profil') }}" />
                                    </label>
                                </div>
                            </div>
                        </section>
                    @endif
                </div>

                <div class="mt-8 flex flex-col gap-3 sm:flex-row sm:justify-end">
                    <button type="submit" class="button">Simpan {{ $sectionTitle }}</button>
                </div>
            </form>
        </div>

        @if($section === 'devices' || $section === 'news')
            <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    const deviceContainer = document.getElementById('device-forms');
                    const addDeviceButton = document.getElementById('add-device');
                    const deviceTemplate = document.getElementById('device-row-template');

                    if (deviceContainer && addDeviceButton && deviceTemplate) {
                        function updateDeviceIndexes() {
                            const rows = deviceContainer.querySelectorAll('.device-row');
                            rows.forEach((row, index) => {
                                const number = index + 1;
                                const indexLabel = row.querySelector('.device-index');
                                if (indexLabel) {
                                    indexLabel.textContent = number;
                                }
                                row.querySelectorAll('input,textarea').forEach((input) => {
                                    if (!input.name) return;
                                    input.name = input.name.replace(/devices\[\d+\]/, `devices[${index}]`);
                                    input.name = input.name.replace(/device_images\[\d+\]/, `device_images[${index}]`);
                                });
                            });
                        }

                        function bindDeviceRemove(button) {
                            button.addEventListener('click', function () {
                                const row = button.closest('.device-row');
                                if (row) {
                                    row.remove();
                                    updateDeviceIndexes();
                                }
                            });
                        }

                        deviceContainer.querySelectorAll('.remove-device').forEach(bindDeviceRemove);

                        addDeviceButton.addEventListener('click', function () {
                            const clone = deviceTemplate.content.cloneNode(true);
                            const rows = deviceContainer.querySelectorAll('.device-row');
                            const nextIndex = rows.length;
                            clone.querySelectorAll('input').forEach((input) => {
                                if (input.name) {
                                    input.name = input.name.replace(/__INDEX__/g, nextIndex);
                                }
                            });
                            deviceContainer.appendChild(clone);
                            const newRow = deviceContainer.querySelectorAll('.device-row')[nextIndex];
                            const removeBtn = newRow.querySelector('.remove-device');
                            if (removeBtn) bindDeviceRemove(removeBtn);
                            updateDeviceIndexes();
                        });
                    }

                    const newsContainer = document.getElementById('news-forms');
                    const addNewsButton = document.getElementById('add-news');
                    const newsTemplate = document.getElementById('news-row-template');

                    if (newsContainer && addNewsButton && newsTemplate) {
                        function updateNewsIndexes() {
                            const rows = newsContainer.querySelectorAll('.news-row');
                            rows.forEach((row, index) => {
                                const number = index + 1;
                                const indexLabel = row.querySelector('.news-index');
                                if (indexLabel) {
                                    indexLabel.textContent = number;
                                }
                                row.querySelectorAll('input,textarea').forEach((input) => {
                                    if (!input.name) return;
                                    input.name = input.name.replace(/news\[\d+\]/, `news[${index}]`);
                                    input.name = input.name.replace(/news_images\[\d+\]/, `news_images[${index}]`);
                                });
                            });
                        }

                        function bindNewsRemove(button) {
                            button.addEventListener('click', function () {
                                const row = button.closest('.news-row');
                                if (row) {
                                    // remove any TinyMCE instance inside this row
                                    const textarea = row.querySelector('.wysiwyg');
                                    if (textarea && textarea.id && window.tinymce && tinymce.get(textarea.id)) {
                                        tinymce.get(textarea.id).remove();
                                    }
                                    row.remove();
                                    updateNewsIndexes();
                                }
                            });
                        }

                        newsContainer.querySelectorAll('.remove-news').forEach(bindNewsRemove);

                        addNewsButton.addEventListener('click', function () {
                            const clone = newsTemplate.content.cloneNode(true);
                            const rows = newsContainer.querySelectorAll('.news-row');
                            const nextIndex = rows.length;
                            clone.querySelectorAll('input,textarea').forEach((input) => {
                                if (input.name) {
                                    input.name = input.name.replace(/__INDEX__/g, nextIndex);
                                }
                            });
                            newsContainer.appendChild(clone);
                            const newRow = newsContainer.querySelectorAll('.news-row')[nextIndex];
                            const removeBtn = newRow.querySelector('.remove-news');
                            if (removeBtn) bindNewsRemove(removeBtn);
                            updateNewsIndexes();
                            // initialize TinyMCE for the new textarea if available
                            const newBody = newRow.querySelector('.wysiwyg');
                            if (newBody && window.tinymce) {
                                const id = newBody.id || ('news-body-' + nextIndex);
                                newBody.id = id;
                                tinymce.init({ selector: '#' + id, menubar: false, height: 220, plugins: 'link lists', toolbar: 'undo redo | bold italic | alignleft aligncenter alignright | bullist numlist | link' });
                            }
                        });
                    }

                    // initialize existing wysiwyg editors
                    if (window.tinymce) {
                        document.querySelectorAll('.wysiwyg').forEach(function (el) {
                            if (!el.id) {
                                el.id = 'news-body-' + Math.floor(Math.random() * 1000000);
                            }
                            if (!tinymce.get(el.id)) {
                                tinymce.init({ selector: '#' + el.id, menubar: false, height: 220, plugins: 'link lists', toolbar: 'undo redo | bold italic | alignleft aligncenter alignright | bullist numlist | link' });
                            }
                        });
                    }
                });
            </script>
        @endif
    </body>
</html>
