<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <title>Edit Transparansi APBN - Admin Nagari</title>
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
                .row-box { background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 1.25rem; padding: 1.25rem; }
            </style>
        @endif
    </head>
    <body>
        <div class="mx-auto max-w-6xl p-6">
            <header class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
                <div>
                    <p class="badge">Admin Panel</p>
                    <h1 class="mt-3 text-3xl font-semibold">Edit Transparansi APBN</h1>
                    <p class="mt-2 text-slate-600 max-w-2xl">Kelola data anggaran dan realisasi yang tampil pada bagian Transparansi APBN di halaman publik. Data akan tersimpan ke <code class="rounded bg-slate-100 px-1">public/data/apbn.json</code>.</p>
                </div>
                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('admin.edit') }}" class="button secondary">Kembali ke Dashboard</a>
                    <a href="{{ url('/') }}#apbn" class="button secondary">Lihat Halaman Publik</a>
                </div>
            </header>

<!-- Quick Navigation -->
            <nav class="mb-6 flex flex-wrap items-center gap-3 rounded-3xl border border-slate-200 bg-white p-4 shadow-sm">
                <span class="text-sm font-semibold text-slate-700">Navigasi Cepat:</span>
                <a href="#data-dasar" class="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 px-4 py-2 text-sm font-semibold text-emerald-700 transition hover:bg-emerald-100">📋 Data Dasar</a>
                <a href="#sumber-dana" class="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 px-4 py-2 text-sm font-semibold text-emerald-700 transition hover:bg-emerald-100">🏦 Sumber Dana</a>
                <a href="#bidang" class="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 px-4 py-2 text-sm font-semibold text-emerald-700 transition hover:bg-emerald-100">📊 Rincian Bidang</a>
                <a href="#program" class="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 px-4 py-2 text-sm font-semibold text-emerald-700 transition hover:bg-emerald-100">📄 Program & Kegiatan</a>
                <a href="#jorong" class="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 px-4 py-2 text-sm font-semibold text-emerald-700 transition hover:bg-emerald-100">📍 Alokasi Jorong</a>
            </nav>

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

            <form action="{{ route('apbn.store') }}" method="POST" class="space-y-6">
                @csrf

<!-- Data Dasar -->
                <section id="data-dasar" class="card scroll-mt-24">
                    <h2 class="text-xl font-semibold text-slate-900 mb-6">Data Dasar</h2>
                    <div class="grid gap-6 lg:grid-cols-2">
                        <label class="block">
                            <span class="mb-2 block font-medium text-slate-700">Tahun Anggaran</span>
                            <input class="input" type="text" name="tahun" value="{{ old('tahun', $apbn['tahun'] ?? '2026') }}" placeholder="Contoh: 2026" />
                        </label>
                        <label class="block">
                            <span class="mb-2 block font-medium text-slate-700">Judul</span>
                            <input class="input" type="text" name="judul" value="{{ old('judul', $apbn['judul'] ?? 'Transparansi APBN & Dana Desa') }}" />
                        </label>
                        <label class="block lg:col-span-2">
                            <span class="mb-2 block font-medium text-slate-700">Deskripsi</span>
                            <textarea class="textarea" rows="3" name="deskripsi" placeholder="Deskripsi umum transparansi anggaran">{{ old('deskripsi', $apbn['deskripsi'] ?? '') }}</textarea>
                        </label>
                        <label class="block">
                            <span class="mb-2 block font-medium text-slate-700">Total Anggaran (Rp)</span>
                            <input class="input" type="number" name="total_anggaran" value="{{ old('total_anggaran', $apbn['total_anggaran'] ?? '') }}" placeholder="Contoh: 1250000000" />
                        </label>
                        <label class="block">
                            <span class="mb-2 block font-medium text-slate-700">Total Realisasi (Rp)</span>
                            <input class="input" type="number" name="total_realisasi" value="{{ old('total_realisasi', $apbn['total_realisasi'] ?? '') }}" placeholder="Contoh: 986000000" />
                        </label>
                    </div>
                </section>

<!-- Sumber Dana -->
                <section id="sumber-dana" class="card scroll-mt-24">
                    <div class="flex items-center justify-between gap-4">
                        <div>
                            <h2 class="text-xl font-semibold text-slate-900">Sumber Dana</h2>
                            <p class="mt-1 text-sm text-slate-500">Rincian sumber dana dan realisasinya.</p>
                        </div>
                        <button type="button" class="button secondary add-row" data-container="sumber-dana-container" data-template="sumber-dana-template">Tambah Sumber Dana</button>
                    </div>
                    <div class="mt-6 space-y-4" id="sumber-dana-container">
                        @php $sdRows = old('sumber_dana', $apbn['sumber_dana'] ?? []); @endphp
                        @if(empty($sdRows)) @php $sdRows = [['nama' => '', 'anggaran' => '', 'realisasi' => '']]; @endphp @endif
                        @foreach($sdRows as $i => $sd)
                            <div class="row-box row-item">
                                <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                                    <p class="text-sm font-semibold text-slate-900">Sumber Dana</p>
                                    <button type="button" class="button secondary remove-row">Hapus</button>
                                </div>
                                <div class="mt-4 grid gap-4 lg:grid-cols-3">
                                    <label class="block">
                                        <span class="mb-2 block text-sm font-medium text-slate-700">Nama</span>
                                        <input class="input" type="text" name="sumber_dana[{{ $i }}][nama]" value="{{ $sd['nama'] ?? '' }}" placeholder="Contoh: Dana Desa (DD)" />
                                    </label>
                                    <label class="block">
                                        <span class="mb-2 block text-sm font-medium text-slate-700">Anggaran (Rp)</span>
                                        <input class="input" type="number" name="sumber_dana[{{ $i }}][anggaran]" value="{{ $sd['anggaran'] ?? '' }}" />
                                    </label>
                                    <label class="block">
                                        <span class="mb-2 block text-sm font-medium text-slate-700">Realisasi (Rp)</span>
                                        <input class="input" type="number" name="sumber_dana[{{ $i }}][realisasi]" value="{{ $sd['realisasi'] ?? '' }}" />
                                    </label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <template id="sumber-dana-template">
                        <div class="row-box row-item">
                            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                                <p class="text-sm font-semibold text-slate-900">Sumber Dana</p>
                                <button type="button" class="button secondary remove-row">Hapus</button>
                            </div>
                            <div class="mt-4 grid gap-4 lg:grid-cols-3">
                                <label class="block">
                                    <span class="mb-2 block text-sm font-medium text-slate-700">Nama</span>
                                    <input class="input" type="text" name="sumber_dana[__INDEX__][nama]" placeholder="Contoh: Dana Desa (DD)" />
                                </label>
                                <label class="block">
                                    <span class="mb-2 block text-sm font-medium text-slate-700">Anggaran (Rp)</span>
                                    <input class="input" type="number" name="sumber_dana[__INDEX__][anggaran]" />
                                </label>
                                <label class="block">
                                    <span class="mb-2 block text-sm font-medium text-slate-700">Realisasi (Rp)</span>
                                    <input class="input" type="number" name="sumber_dana[__INDEX__][realisasi]" />
                                </label>
                            </div>
                        </div>
                    </template>
                </section>

<!-- Bidang -->
                <section id="bidang" class="card scroll-mt-24">
                    <div class="flex items-center justify-between gap-4">
                        <div>
                            <h2 class="text-xl font-semibold text-slate-900">Rincian per Bidang</h2>
                            <p class="mt-1 text-sm text-slate-500">Alokasi anggaran dan realisasi per bidang.</p>
                        </div>
                        <button type="button" class="button secondary add-row" data-container="bidang-container" data-template="bidang-template">Tambah Bidang</button>
                    </div>
                    <div class="mt-6 space-y-4" id="bidang-container">
                        @php $bdRows = old('bidang', $apbn['bidang'] ?? []); @endphp
                        @if(empty($bdRows)) @php $bdRows = [['nama' => '', 'anggaran' => '', 'realisasi' => '']]; @endphp @endif
                        @foreach($bdRows as $i => $bd)
                            <div class="row-box row-item">
                                <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                                    <p class="text-sm font-semibold text-slate-900">Bidang</p>
                                    <button type="button" class="button secondary remove-row">Hapus</button>
                                </div>
                                <div class="mt-4 grid gap-4 lg:grid-cols-3">
                                    <label class="block">
                                        <span class="mb-2 block text-sm font-medium text-slate-700">Nama Bidang</span>
                                        <input class="input" type="text" name="bidang[{{ $i }}][nama]" value="{{ $bd['nama'] ?? '' }}" placeholder="Contoh: Bidang Pelaksanaan Pembangunan" />
                                    </label>
                                    <label class="block">
                                        <span class="mb-2 block text-sm font-medium text-slate-700">Anggaran (Rp)</span>
                                        <input class="input" type="number" name="bidang[{{ $i }}][anggaran]" value="{{ $bd['anggaran'] ?? '' }}" />
                                    </label>
                                    <label class="block">
                                        <span class="mb-2 block text-sm font-medium text-slate-700">Realisasi (Rp)</span>
                                        <input class="input" type="number" name="bidang[{{ $i }}][realisasi]" value="{{ $bd['realisasi'] ?? '' }}" />
                                    </label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <template id="bidang-template">
                        <div class="row-box row-item">
                            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                                <p class="text-sm font-semibold text-slate-900">Bidang</p>
                                <button type="button" class="button secondary remove-row">Hapus</button>
                            </div>
                            <div class="mt-4 grid gap-4 lg:grid-cols-3">
                                <label class="block">
                                    <span class="mb-2 block text-sm font-medium text-slate-700">Nama Bidang</span>
                                    <input class="input" type="text" name="bidang[__INDEX__][nama]" placeholder="Contoh: Bidang Pelaksanaan Pembangunan" />
                                </label>
                                <label class="block">
                                    <span class="mb-2 block text-sm font-medium text-slate-700">Anggaran (Rp)</span>
                                    <input class="input" type="number" name="bidang[__INDEX__][anggaran]" />
                                </label>
                                <label class="block">
                                    <span class="mb-2 block text-sm font-medium text-slate-700">Realisasi (Rp)</span>
                                    <input class="input" type="number" name="bidang[__INDEX__][realisasi]" />
                                </label>
                            </div>
                        </div>
                    </template>
                </section>

<!-- Program -->
                <section id="program" class="card scroll-mt-24">
                    <div class="flex items-center justify-between gap-4">
                        <div>
                            <h2 class="text-xl font-semibold text-slate-900">Daftar Program & Kegiatan</h2>
                            <p class="mt-1 text-sm text-slate-500">Program/kegiatan beserta anggaran, realisasi, dan statusnya.</p>
                        </div>
                        <button type="button" class="button secondary add-row" data-container="program-container" data-template="program-template">Tambah Program</button>
                    </div>
                    <div class="mt-6 space-y-4" id="program-container">
                        @php $prRows = old('program', $apbn['program'] ?? []); @endphp
                        @if(empty($prRows)) @php $prRows = [['nama' => '', 'bidang' => '', 'anggaran' => '', 'realisasi' => '', 'status' => '', 'keterangan' => '']]; @endphp @endif
                        @foreach($prRows as $i => $pr)
                            <div class="row-box row-item">
                                <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                                    <p class="text-sm font-semibold text-slate-900">Program {{ $loop->iteration }}</p>
                                    <button type="button" class="button secondary remove-row">Hapus</button>
                                </div>
                                <div class="mt-4 grid gap-4 lg:grid-cols-2">
                                    <label class="block">
                                        <span class="mb-2 block text-sm font-medium text-slate-700">Nama Program</span>
                                        <input class="input" type="text" name="program[{{ $i }}][nama]" value="{{ $pr['nama'] ?? '' }}" placeholder="Contoh: Pembangunan Jalan Nagari" />
                                    </label>
                                    <label class="block">
                                        <span class="mb-2 block text-sm font-medium text-slate-700">Bidang</span>
                                        <input class="input" type="text" name="program[{{ $i }}][bidang]" value="{{ $pr['bidang'] ?? '' }}" placeholder="Contoh: Pelaksanaan Pembangunan" />
                                    </label>
                                    <label class="block">
                                        <span class="mb-2 block text-sm font-medium text-slate-700">Anggaran (Rp)</span>
                                        <input class="input" type="number" name="program[{{ $i }}][anggaran]" value="{{ $pr['anggaran'] ?? '' }}" />
                                    </label>
                                    <label class="block">
                                        <span class="mb-2 block text-sm font-medium text-slate-700">Realisasi (Rp)</span>
                                        <input class="input" type="number" name="program[{{ $i }}][realisasi]" value="{{ $pr['realisasi'] ?? '' }}" />
                                    </label>
                                    <label class="block">
                                        <span class="mb-2 block text-sm font-medium text-slate-700">Status</span>
                                        <select class="input" name="program[{{ $i }}][status]">
                                            <option value="">-- Pilih Status --</option>
                                            <option value="Selesai" @if(($pr['status'] ?? '') === 'Selesai') selected @endif>Selesai</option>
                                            <option value="Berjalan" @if(($pr['status'] ?? '') === 'Berjalan') selected @endif>Berjalan</option>
                                            <option value="Belum Mulai" @if(($pr['status'] ?? '') === 'Belum Mulai') selected @endif>Belum Mulai</option>
                                        </select>
                                    </label>
                                    <label class="block">
                                        <span class="mb-2 block text-sm font-medium text-slate-700">Keterangan</span>
                                        <input class="input" type="text" name="program[{{ $i }}][keterangan]" value="{{ $pr['keterangan'] ?? '' }}" placeholder="Deskripsi singkat program" />
                                    </label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <template id="program-template">
                        <div class="row-box row-item">
                            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                                <p class="text-sm font-semibold text-slate-900">Program</p>
                                <button type="button" class="button secondary remove-row">Hapus</button>
                            </div>
                            <div class="mt-4 grid gap-4 lg:grid-cols-2">
                                <label class="block">
                                    <span class="mb-2 block text-sm font-medium text-slate-700">Nama Program</span>
                                    <input class="input" type="text" name="program[__INDEX__][nama]" placeholder="Contoh: Pembangunan Jalan Nagari" />
                                </label>
                                <label class="block">
                                    <span class="mb-2 block text-sm font-medium text-slate-700">Bidang</span>
                                    <input class="input" type="text" name="program[__INDEX__][bidang]" placeholder="Contoh: Pelaksanaan Pembangunan" />
                                </label>
                                <label class="block">
                                    <span class="mb-2 block text-sm font-medium text-slate-700">Anggaran (Rp)</span>
                                    <input class="input" type="number" name="program[__INDEX__][anggaran]" />
                                </label>
                                <label class="block">
                                    <span class="mb-2 block text-sm font-medium text-slate-700">Realisasi (Rp)</span>
                                    <input class="input" type="number" name="program[__INDEX__][realisasi]" />
                                </label>
                                <label class="block">
                                    <span class="mb-2 block text-sm font-medium text-slate-700">Status</span>
                                    <select class="input" name="program[__INDEX__][status]">
                                        <option value="">-- Pilih Status --</option>
                                        <option value="Selesai">Selesai</option>
                                        <option value="Berjalan">Berjalan</option>
                                        <option value="Belum Mulai">Belum Mulai</option>
                                    </select>
                                </label>
                                <label class="block">
                                    <span class="mb-2 block text-sm font-medium text-slate-700">Keterangan</span>
                                    <input class="input" type="text" name="program[__INDEX__][keterangan]" placeholder="Deskripsi singkat program" />
                                </label>
                            </div>
                        </div>
                    </template>
                </section>

<!-- Jorong -->
                <section id="jorong" class="card scroll-mt-24">
                    <div class="flex items-center justify-between gap-4">
                        <div>
                            <h2 class="text-xl font-semibold text-slate-900">Alokasi per Jorong</h2>
                            <p class="mt-1 text-sm text-slate-500">Alokasi anggaran dan realisasi per jorong.</p>
                        </div>
                        <button type="button" class="button secondary add-row" data-container="jorong-container" data-template="jorong-template">Tambah Jorong</button>
                    </div>
                    <div class="mt-6 space-y-4" id="jorong-container">
                        @php $jrRows = old('jorong', $apbn['jorong'] ?? []); @endphp
                        @if(empty($jrRows)) @php $jrRows = [['nama' => '', 'anggaran' => '', 'realisasi' => '']]; @endphp @endif
                        @foreach($jrRows as $i => $jr)
                            <div class="row-box row-item">
                                <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                                    <p class="text-sm font-semibold text-slate-900">Jorong</p>
                                    <button type="button" class="button secondary remove-row">Hapus</button>
                                </div>
                                <div class="mt-4 grid gap-4 lg:grid-cols-3">
                                    <label class="block">
                                        <span class="mb-2 block text-sm font-medium text-slate-700">Nama Jorong</span>
                                        <input class="input" type="text" name="jorong[{{ $i }}][nama]" value="{{ $jr['nama'] ?? '' }}" placeholder="Contoh: Jorong Parik Gadang" />
                                    </label>
                                    <label class="block">
                                        <span class="mb-2 block text-sm font-medium text-slate-700">Anggaran (Rp)</span>
                                        <input class="input" type="number" name="jorong[{{ $i }}][anggaran]" value="{{ $jr['anggaran'] ?? '' }}" />
                                    </label>
                                    <label class="block">
                                        <span class="mb-2 block text-sm font-medium text-slate-700">Realisasi (Rp)</span>
                                        <input class="input" type="number" name="jorong[{{ $i }}][realisasi]" value="{{ $jr['realisasi'] ?? '' }}" />
                                    </label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <template id="jorong-template">
                        <div class="row-box row-item">
                            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                                <p class="text-sm font-semibold text-slate-900">Jorong</p>
                                <button type="button" class="button secondary remove-row">Hapus</button>
                            </div>
                            <div class="mt-4 grid gap-4 lg:grid-cols-3">
                                <label class="block">
                                    <span class="mb-2 block text-sm font-medium text-slate-700">Nama Jorong</span>
                                    <input class="input" type="text" name="jorong[__INDEX__][nama]" placeholder="Contoh: Jorong Parik Gadang" />
                                </label>
                                <label class="block">
                                    <span class="mb-2 block text-sm font-medium text-slate-700">Anggaran (Rp)</span>
                                    <input class="input" type="number" name="jorong[__INDEX__][anggaran]" />
                                </label>
                                <label class="block">
                                    <span class="mb-2 block text-sm font-medium text-slate-700">Realisasi (Rp)</span>
                                    <input class="input" type="number" name="jorong[__INDEX__][realisasi]" />
                                </label>
                            </div>
                        </div>
                    </template>
                </section>

                <div class="flex flex-col gap-3 sm:flex-row sm:justify-end">
                    <button type="submit" class="button">Simpan Data APBN</button>
                </div>
            </form>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                function reindex(container) {
                    const rows = container.querySelectorAll('.row-item');
                    rows.forEach((row, index) => {
                        row.querySelectorAll('input, select, textarea').forEach((field) => {
                            if (!field.name) return;
                            // Replace indices for each known group key
                            field.name = field.name.replace(/sumber_dana\[\d+\]/, `sumber_dana[${index}]`);
                            field.name = field.name.replace(/bidang\[\d+\]/, `bidang[${index}]`);
                            field.name = field.name.replace(/program\[\d+\]/, `program[${index}]`);
                            field.name = field.name.replace(/jorong\[\d+\]/, `jorong[${index}]`);
                        });
                    });
                }

                function bindRemove(button) {
                    button.addEventListener('click', function () {
                        const row = button.closest('.row-item');
                        if (row) {
                            const container = row.parentElement;
                            row.remove();
                            if (container) reindex(container);
                        }
                    });
                }

                // Bind existing remove buttons
                document.querySelectorAll('.remove-row').forEach(bindRemove);

                // Bind add buttons
                document.querySelectorAll('.add-row').forEach((button) => {
                    button.addEventListener('click', function () {
                        const container = document.getElementById(this.dataset.container);
                        const template = document.getElementById(this.dataset.template);
                        if (!container || !template) return;

                        const index = container.querySelectorAll('.row-item').length;
                        const clone = template.content.cloneNode(true);
                        clone.querySelectorAll('input, select, textarea').forEach((field) => {
                            if (field.name) {
                                field.name = field.name.replace(/__INDEX__/g, index);
                            }
                        });
                        container.appendChild(clone);

                        const newRow = container.querySelectorAll('.row-item')[index];
                        const removeBtn = newRow.querySelector('.remove-row');
                        if (removeBtn) bindRemove(removeBtn);
                        reindex(container);
                    });
                });
            });
        </script>
    </body>
</html>
</content>
