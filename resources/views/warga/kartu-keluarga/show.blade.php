<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Detail Kartu Keluarga — Nagari Koto Kaciak Barat</title>
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
                    <a href="{{ url('/') }}" class="text-slate-600 hover:text-emerald-700 transition">Beranda</a>
                    <a href="{{ route('warga.index') }}" class="text-slate-600 hover:text-emerald-700 transition">Data Warga</a>
                    <a href="{{ route('kartu-keluarga.index') }}" class="text-emerald-700 font-medium">Kartu Keluarga</a>
                    <a href="{{ route('jorong.index') }}" class="text-slate-600 hover:text-emerald-700 transition">Jorong</a>
                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('admin.edit') }}" class="text-slate-600 hover:text-emerald-700 transition">Admin Panel</a>
                    @endif
                </nav>
            </div>
        </header>

        <main>
            <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8 py-8">
                <div class="mb-8">
                    <div class="flex items-center gap-4 mb-4">
                        <a href="{{ route('kartu-keluarga.index') }}" class="text-slate-600 hover:text-emerald-700 transition">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                        </a>
                        <h1 class="text-2xl font-semibold tracking-tight text-slate-900">Detail Kartu Keluarga</h1>
                    </div>
                </div>

                <!-- KK Info Card -->
                <div class="bg-white rounded-2xl border border-slate-200 p-6 mb-6">
                    <div class="flex items-start justify-between mb-6">
                        <div>
                            <h2 class="text-2xl font-bold text-slate-900">{{ $kartuKeluarga->nomor_kk }}</h2>
                            <p class="text-slate-500">Kepala Keluarga: {{ $kartuKeluarga->nama_kepala_keluarga }}</p>
                        </div>
                        <div class="flex gap-2">
                            <a href="{{ route('kartu-keluarga.edit', $kartuKeluarga) }}" class="px-4 py-2 rounded-full bg-emerald-700 text-white text-sm font-medium hover:bg-emerald-600 transition">
                                Edit
                            </a>
                        </div>
                    </div>

                    <div class="grid gap-4 sm:grid-cols-2">
                        <div>
                            <p class="text-sm text-slate-500 mb-1">Jorong</p>
                            <p class="font-medium">{{ $kartuKeluarga->jorong->nama_jorong ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-slate-500 mb-1">Jumlah Anggota</p>
                            <p class="font-medium">{{ $kartuKeluarga->jumlah_anggota }} orang</p>
                        </div>
                        <div class="sm:col-span-2">
                            <p class="text-sm text-slate-500 mb-1">Alamat</p>
                            <p class="font-medium">{{ $kartuKeluarga->alamat_lengkap }}</p>
                        </div>
                        @if($kartuKeluarga->telepon)
                            <div>
                                <p class="text-sm text-slate-500 mb-1">Telepon</p>
                                <p class="font-medium">{{ $kartuKeluarga->telepon }}</p>
                            </div>
                        @endif
                        @if($kartuKeluarga->kelompok_sosial)
                            <div>
                                <p class="text-sm text-slate-500 mb-1">Kelompok Sosial</p>
                                <p class="font-medium">{{ $kartuKeluarga->kelompok_sosial }}</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Family Members -->
                <div class="bg-white rounded-2xl border border-slate-200 p-6 mb-6">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-lg font-semibold text-slate-900">Anggota Keluarga</h3>
                        <div class="flex gap-2">
                            <a href="{{ route('warga.create', ['kk_id' => $kartuKeluarga->id]) }}" class="px-4 py-2 rounded-full bg-emerald-700 text-white text-sm font-medium hover:bg-emerald-600 transition">
                                + Tambah Anggota
                            </a>
                        </div>
                    </div>

                    @if($kartuKeluarga->wargas->count() > 0)
                        <div class="space-y-3">
                            @foreach($kartuKeluarga->wargas as $warga)
                                <div class="flex items-center justify-between p-4 bg-slate-50 rounded-xl">
                                    <div class="flex items-center gap-4">
                                        <div class="h-10 w-10 rounded-full bg-emerald-100 flex items-center justify-center">
                                            <svg class="h-5 w-5 text-emerald-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="font-medium text-slate-900">{{ $warga->nama_lengkap }}</p>
                                            <p class="text-sm text-slate-500">{{ $warga->hubungan_keluarga }} • {{ $warga->nik }}</p>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        @if($warga->is_wafat)
                                            <span class="px-2 py-1 rounded-full bg-red-100 text-red-700 text-xs font-medium">Wafat</span>
                                        @endif
                                        @if(!$warga->is_tetap)
                                            <span class="px-2 py-1 rounded-full bg-amber-100 text-amber-700 text-xs font-medium">Sementara</span>
                                        @endif
                                        <a href="{{ route('warga.show', $warga) }}" class="text-emerald-600 hover:text-emerald-700 text-sm font-medium">Lihat</a>
                                        @if($warga->hubungan_keluarga !== 'Kepala Keluarga')
                                            <button onclick="showTransferModal({{ $warga->id }}, '{{ $warga->nama_lengkap }}')" class="text-blue-600 hover:text-blue-700 text-sm font-medium">Pindah</button>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8 text-slate-500">
                            <p class="text-lg font-medium">Belum ada anggota keluarga</p>
                            <p class="text-sm">Tambahkan anggota keluarga untuk kartu keluarga ini</p>
                        </div>
                    @endif
                </div>

                <!-- Temporary Residents Section -->
                <div class="bg-white rounded-2xl border border-slate-200 p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-lg font-semibold text-slate-900">Warga Sementara</h3>
                        <a href="{{ route('warga.create') }}" class="px-4 py-2 rounded-full bg-amber-600 text-white text-sm font-medium hover:bg-amber-500 transition">
                            + Tambah Warga Sementara
                        </a>
                    </div>

                    <div class="text-center py-8 text-slate-500">
                        <p class="text-lg font-medium">Fitur warga sementara</p>
                        <p class="text-sm">Tambahkan warga sementara yang belum memiliki kartu keluarga</p>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex items-center justify-between">
                    <a href="{{ route('kartu-keluarga.index') }}" class="px-6 py-3 rounded-full border border-slate-300 text-slate-700 font-medium hover:bg-slate-50 transition">
                        Kembali
                    </a>
                    <div class="flex gap-2">
                        <a href="{{ route('kartu-keluarga.edit', $kartuKeluarga) }}" class="px-6 py-3 rounded-full bg-emerald-700 text-white font-medium shadow-glow hover:bg-emerald-600 transition">
                            Edit Data
                        </a>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- Transfer Modal -->
    <div id="transferModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-2xl p-6 max-w-md w-full mx-4">
            <h3 class="text-lg font-semibold text-slate-900 mb-4">Pindah Warga ke KK Lain</h3>
            <p class="text-sm text-slate-600 mb-4">Pindahkan <span id="wargaName" class="font-medium"></span> ke kartu keluarga lain.</p>
            
            <form method="POST" id="transferForm">
                @csrf
                <input type="hidden" name="warga_id" id="wargaIdInput">
                
                <div class="mb-4">
                    <label class="block text-sm font-medium text-slate-700 mb-2">Kartu Keluarga Tujuan <span class="text-red-500">*</span></label>
                    <select name="new_kartu_keluarga_id" required class="w-full rounded-lg border border-slate-300 px-4 py-2 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 outline-none transition">
                        <option value="">Pilih Kartu Keluarga</option>
                        @foreach(\App\Models\KartuKeluarga::active()->where('id', '!=', $kartuKeluarga->id)->get() as $kk)
                            <option value="{{ $kk->id }}">{{ $kk->nomor_kk }} - {{ $kk->nama_kepala_keluarga }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div class="flex justify-end gap-2">
                    <button type="button" onclick="closeTransferModal()" class="px-4 py-2 rounded-full border border-slate-300 text-slate-700 font-medium hover:bg-slate-50 transition">
                        Batal
                    </button>
                    <button type="submit" class="px-4 py-2 rounded-full bg-emerald-700 text-white font-medium hover:bg-emerald-600 transition">
                        Pindahkan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function showTransferModal(wargaId, wargaName) {
            document.getElementById('wargaIdInput').value = wargaId;
            document.getElementById('wargaName').textContent = wargaName;
            document.getElementById('transferModal').classList.remove('hidden');
            document.getElementById('transferModal').classList.add('flex');
            
            // Update form action
            const form = document.getElementById('transferForm');
            form.action = '/data-warga/' + wargaId + '/transfer';
        }

        function closeTransferModal() {
            document.getElementById('transferModal').classList.add('hidden');
            document.getElementById('transferModal').classList.remove('flex');
        }

        // Close modal when clicking outside
        document.getElementById('transferModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeTransferModal();
            }
        });
    </script>
</body>
</html>