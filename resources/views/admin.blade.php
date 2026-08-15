<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <title>Admin Edit Profil Nagari</title>
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
        <div class="mx-auto max-w-6xl p-6">
            <header class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
                <div>
                    <p class="badge">Admin Panel</p>
                    <h1 class="mt-3 text-3xl font-semibold">Edit Konten Profil Nagari</h1>
                    <p class="mt-2 text-slate-600 max-w-2xl">Gunakan halaman ini untuk mengubah teks, statistik, perangkat, berita, layanan, peraturan, dan kontak. Data akan tersimpan ke file konfig.</p>
                </div>
<div class="flex flex-wrap gap-3">
                    <a href="{{ route('apbn.edit') }}" class="button">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 17v-2m3 2v-4m3 4v-6m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        Input Transparansi APBN
                    </a>
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

            <section class="card mb-8">
                <div class="flex flex-col gap-6 lg:flex-row lg:items-start lg:justify-between">
                    <div class="max-w-3xl">
                        <div class="inline-flex items-center gap-3 rounded-3xl bg-emerald-50 px-4 py-3 text-emerald-700">
                            <span class="text-lg">📝</span>
                            <div>
                                <p class="text-xs uppercase tracking-[0.3em]">Preview Profil</p>
                                <p class="font-semibold text-slate-900">Tampilan halaman profil yang dapat kamu edit langsung.</p>
                            </div>
                        </div>
                        <p class="mt-4 text-slate-600">Klik ikon pensil untuk melompat ke bagian yang ingin diedit.</p>
                    </div>
                    <div class="flex flex-wrap gap-3">
                        <button type="button" class="button secondary preview-action" data-target="#hero">Edit Hero</button>
                        <button type="button" class="button secondary preview-action" data-target="#devices">Edit Perangkat</button>
                        <button type="button" class="button secondary preview-action" data-target="#contact">Edit Kontak</button>
                    </div>
                </div>

                <div class="mt-8 grid gap-6 lg:grid-cols-[2fr_1fr]">
                    <div class="rounded-[2rem] bg-slate-50 p-8 shadow-sm ring-1 ring-slate-200">
                        <div class="flex items-start justify-between gap-4">
                            <div>
                                <p class="text-sm uppercase tracking-[0.3em] text-emerald-700">Hero</p>
                                <h3 class="mt-3 text-3xl font-semibold text-slate-900">{{ $data['hero_title'] }}</h3>
                                <p class="mt-4 text-slate-600">{{ $data['hero_subtitle'] }}</p>
                            </div>
                            <button type="button" class="button secondary preview-action h-12 w-12 flex-none" data-target="#hero">✏️</button>
                        </div>
                    </div>
                    <div class="grid gap-4">
                        @foreach($data['statistics'] as $stat)
                            <div class="rounded-3xl bg-white p-5 shadow-sm ring-1 ring-slate-200">
                                <p class="text-xs uppercase tracking-[0.3em] text-slate-500">{{ $stat['label'] }}</p>
                                <p class="mt-3 text-2xl font-semibold text-slate-900">{{ $stat['value'] }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="mt-8 grid gap-6 lg:grid-cols-3">
                    @foreach(array_slice($data['devices'], 0, 3) as $device)
                        <div class="relative overflow-hidden rounded-[2rem] bg-white shadow-sm ring-1 ring-slate-200">
                            <button type="button" class="absolute right-4 top-4 z-10 inline-flex h-11 w-11 items-center justify-center rounded-full bg-white text-emerald-700 shadow-sm preview-action" data-target="#devices">✏️</button>
                            <div class="h-52 overflow-hidden bg-slate-100">
                                <img src="{{ $device['image'] }}" alt="{{ $device['name'] }}" class="h-full w-full object-cover" />
                            </div>
                            <div class="p-6">
                                <p class="text-lg font-semibold text-slate-900">{{ $device['name'] }}</p>
                                <p class="mt-2 text-sm text-slate-600">{{ $device['position'] }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>

            <div class="mt-10 grid gap-6 lg:grid-cols-3">
                @php
                    $sections = [
['key' => 'banner', 'label' => 'Banner Halaman', 'description' => 'Edit gambar banner, badge, judul, dan subjudul di bagian paling atas.', 'category' => 'Konten Utama'],
                        ['key' => 'hero', 'label' => 'Hero Section', 'description' => 'Edit judul utama dan deskripsi di bagian hero.', 'category' => 'Konten Utama'],
                        ['key' => 'header', 'label' => 'Header & Navigasi', 'description' => 'Edit nama situs, subtitle, dan menu navigasi.', 'category' => 'Konten Utama'],
                        ['key' => 'content', 'label' => 'Judul Section', 'description' => 'Edit judul dan deskripsi setiap section halaman.', 'category' => 'Konten Utama'],
                        ['key' => 'buttons', 'label' => 'Tombol & Link', 'description' => 'Edit teks dan link tombol di seluruh halaman.', 'category' => 'Konten Utama'],
                        ['key' => 'profile', 'label' => 'Profil Nagari', 'description' => 'Edit visi, misi, nilai, sejarah, dan wilayah.', 'category' => 'Informasi Nagari'],
                        ['key' => 'stats', 'label' => 'Statistik', 'description' => 'Perbarui angka statistik dan data ringkasan.', 'category' => 'Informasi Nagari'],
                        ['key' => 'devices', 'label' => 'Perangkat Nagari', 'description' => 'Kelola nama, jabatan, dan foto perangkat.', 'category' => 'Informasi Nagari'],
                        ['key' => 'news', 'label' => 'Berita', 'description' => 'Edit daftar berita yang tampil di homepage.', 'category' => 'Konten Dinamis'],
                        ['key' => 'services', 'label' => 'Layanan Publik', 'description' => 'Atur layanan publik dan deskripsinya.', 'category' => 'Konten Dinamis'],
['key' => 'regulations', 'label' => 'Peraturan', 'description' => 'Ubah daftar peraturan nagari.', 'category' => 'Konten Dinamis'],
                        ['key' => 'contact', 'label' => 'Kontak', 'description' => 'Perbarui alamat, telepon, dan email.', 'category' => 'Kontak & Lokasi'],
                        ['key' => 'apbn', 'label' => 'Transparansi APBN', 'description' => 'Kelola data anggaran & realisasi APBN/Dana Desa.', 'category' => 'Konten Dinamis', 'route' => 'apbn.edit'],
                    ];
                @endphp

                @php
                    $categories = [];
                    foreach($sections as $sectionItem) {
                        $category = $sectionItem['category'] ?? 'Lainnya';
                        if(!isset($categories[$category])) {
                            $categories[$category] = [];
                        }
                        $categories[$category][] = $sectionItem;
                    }
                @endphp

                @foreach($categories as $category => $categorySections)
                    <div class="mb-8">
                        <h3 class="mb-4 text-xl font-semibold text-slate-900">{{ $category }}</h3>
                        <div class="grid gap-6 lg:grid-cols-3">
                            @foreach($categorySections as $sectionItem)
                                <div class="rounded-[2rem] bg-white p-8 shadow-sm ring-1 ring-slate-200">
                                    <p class="text-sm uppercase tracking-[0.3em] text-emerald-700">{{ $sectionItem['label'] }}</p>
                                    <p class="mt-4 text-slate-600">{{ $sectionItem['description'] }}</p>
@php
                                        $sectionLink = !empty($sectionItem['route'])
                                            ? route($sectionItem['route'])
                                            : route('admin.section.edit', ['section' => $sectionItem['key']]);
                                    @endphp
                                    <a href="{{ $sectionLink }}" class="mt-6 inline-flex items-center justify-center rounded-full bg-emerald-600 px-5 py-3 text-sm font-semibold text-white transition hover:bg-emerald-700">Edit {{ $sectionItem['label'] }}</a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const container = document.getElementById('device-forms');
                const addButton = document.getElementById('add-device');
                const template = document.getElementById('device-row-template');
                const previewActions = document.querySelectorAll('.preview-action');

                function updateIndexes() {
                    const rows = container.querySelectorAll('.device-row');
                    rows.forEach((row, index) => {
                        const number = index + 1;
                        const indexLabel = row.querySelector('.device-index');
                        if (indexLabel) {
                            indexLabel.textContent = number;
                        }
                        row.querySelectorAll('input').forEach((input) => {
                            if (!input.name) return;
                            input.name = input.name.replace(/devices\[\d+\]/, `devices[${index}]`);
                            input.name = input.name.replace(/device_images\[\d+\]/, `device_images[${index}]`);
                        });
                    });
                }

                function bindRemove(button) {
                    button.addEventListener('click', function () {
                        const row = button.closest('.device-row');
                        if (row) {
                            row.remove();
                            updateIndexes();
                        }
                    });
                }

                container.querySelectorAll('.remove-device').forEach(bindRemove);

                addButton.addEventListener('click', function () {
                    const clone = template.content.cloneNode(true);
                    const rows = container.querySelectorAll('.device-row');
                    const nextIndex = rows.length;
                    clone.querySelectorAll('input').forEach((input) => {
                        if (input.name) {
                            input.name = input.name.replace(/__INDEX__/g, nextIndex);
                        }
                    });
                    container.appendChild(clone);
                    const newRow = container.querySelectorAll('.device-row')[nextIndex];
                    const removeBtn = newRow.querySelector('.remove-device');
                    if (removeBtn) bindRemove(removeBtn);
                    updateIndexes();
                });

                previewActions.forEach((button) => {
                    button.addEventListener('click', function () {
                        const target = document.querySelector(this.dataset.target);
                        if (target) {
                            target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                        }
                    });
                });
            });
        </script>
    </body>
</html>
