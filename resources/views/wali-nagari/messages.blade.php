<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Pesan Kontak Publik — Wali Nagari Koto Kaciak Barat</title>
    <link rel="preconnect" href="https://fonts.bunny.net" />
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <style>
            /*! tailwindcss v4.0.7 | MIT License | https://tailwindcss.com */
            @layer theme{:root,:host{--font-sans:'Instrument Sans',ui-sans-serif,system-ui,sans-serif;}}
        </style>
    @endif
    <style>
        html { scroll-behavior: smooth; }
        .status-unread { background: #fee2e2; color: #991b1b; border: 1px solid #fca5a5; }
        .status-read { background: #e0f2fe; color: #0369a1; border: 1px solid #7dd3fc; }
        .status-replied { background: #dcfce7; color: #166534; border: 1px solid #86efac; }
    </style>
</head>
<body class="bg-slate-50 text-slate-900 font-sans antialiased min-h-screen">
    <div class="min-h-screen flex flex-col">
        <!-- Executive Header -->
        <header class="sticky top-0 z-30 border-b border-slate-200 bg-white/95 backdrop-blur-md shadow-sm">
            <div class="mx-auto flex max-w-7xl items-center justify-between px-4 py-3 sm:px-6 lg:px-8">
                <div class="flex items-center gap-4">
                    <a href="{{ url('/') }}" class="flex items-center gap-3">
                        <span class="inline-flex h-11 w-11 items-center justify-center rounded-2xl bg-gradient-to-br from-emerald-600 to-teal-800 text-white font-bold text-xl shadow-md">
                            WN
                        </span>
                        <div>
                            <span class="block text-xs font-semibold uppercase tracking-wider text-emerald-700">Pemerintahan Nagari</span>
                            <span class="block text-base font-bold text-slate-900 leading-tight">Pesan Kontak Publik</span>
                        </div>
                    </a>
                </div>

                <!-- Navigation Links -->
                <nav class="hidden lg:flex items-center gap-2 text-sm font-medium">
                    <a href="{{ route('wali-nagari.dashboard') }}" class="px-3 py-2 rounded-xl text-slate-600 hover:text-emerald-700 hover:bg-slate-100 transition">
                        📊 Ringkasan Eksekutif
                    </a>
                    <a href="{{ route('wali-nagari.messages.index') }}" class="px-3 py-2 rounded-xl bg-emerald-50 text-emerald-700 font-semibold border border-emerald-200/60">
                        ✉️ Pesan Kontak
                        @if($unreadCount > 0)
                            <span class="inline-flex items-center justify-center px-2 py-0.5 ml-1 text-xs font-bold text-white bg-red-600 rounded-full">
                                {{ $unreadCount }}
                            </span>
                        @endif
                    </a>
                    <a href="{{ route('warga.index') }}" class="px-3 py-2 rounded-xl text-slate-600 hover:text-emerald-700 hover:bg-slate-100 transition">
                        👥 Data Warga
                    </a>
                    <a href="{{ route('kartu-keluarga.index') }}" class="px-3 py-2 rounded-xl text-slate-600 hover:text-emerald-700 hover:bg-slate-100 transition">
                        🏠 Kartu Keluarga
                    </a>
                    <a href="{{ route('jorong.index') }}" class="px-3 py-2 rounded-xl text-slate-600 hover:text-emerald-700 hover:bg-slate-100 transition">
                        🗺️ Jorong
                    </a>
                </nav>

                <!-- User Profile & Actions -->
                <div class="flex items-center gap-3">
                    <span class="text-sm font-semibold text-slate-900 hidden sm:inline">{{ auth()->user()->name }}</span>
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="px-3.5 py-2 rounded-xl border border-slate-200 text-xs font-semibold text-slate-700 hover:bg-red-50 hover:text-red-600 transition">
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </header>

        <main class="flex-1 py-8 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto w-full">
            @if(session('success'))
                <div class="mb-6 rounded-2xl bg-emerald-50 border border-emerald-200 p-4 flex items-center justify-between text-emerald-800">
                    <div class="flex items-center gap-3">
                        <svg class="h-5 w-5 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span class="text-sm font-medium">{{ session('success') }}</span>
                    </div>
                    <button onclick="this.parentElement.remove()" class="text-emerald-600 hover:text-emerald-800">&times;</button>
                </div>
            @endif

            <!-- Header Title -->
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">
                <div>
                    <h1 class="text-2xl font-extrabold text-slate-900">Kotak Pesan & Aspirasi Kontak Kami</h1>
                    <p class="text-xs sm:text-sm text-slate-500 mt-1">Kelola, baca, dan tindak lanjuti pesan yang masuk dari pengunjung halaman publik Nagari Koto Kaciak Barat</p>
                </div>

                <div class="flex items-center gap-2">
                    <a href="{{ route('wali-nagari.dashboard') }}" class="px-4 py-2.5 rounded-xl border border-slate-300 text-slate-700 text-xs font-bold hover:bg-slate-100 transition">
                        &larr; Kembali ke Dashboard
                    </a>
                </div>
            </div>

            <!-- Stats Bar -->
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-8">
                <a href="{{ route('wali-nagari.messages.index') }}" class="p-4 rounded-2xl border bg-white {{ empty($status) ? 'border-emerald-500 ring-2 ring-emerald-200' : 'border-slate-200' }} hover:border-emerald-400 transition">
                    <span class="block text-xs font-bold uppercase text-slate-400">Total Pesan</span>
                    <span class="text-2xl font-extrabold text-slate-900">{{ number_format($totalCount) }}</span>
                </a>
                <a href="{{ route('wali-nagari.messages.index', ['status' => 'unread']) }}" class="p-4 rounded-2xl border bg-white {{ $status === 'unread' ? 'border-red-500 ring-2 ring-red-200' : 'border-slate-200' }} hover:border-red-400 transition">
                    <span class="block text-xs font-bold uppercase text-red-500">Belum Dibaca</span>
                    <span class="text-2xl font-extrabold text-red-600">{{ number_format($unreadCount) }}</span>
                </a>
                <a href="{{ route('wali-nagari.messages.index', ['status' => 'read']) }}" class="p-4 rounded-2xl border bg-white {{ $status === 'read' ? 'border-blue-500 ring-2 ring-blue-200' : 'border-slate-200' }} hover:border-blue-400 transition">
                    <span class="block text-xs font-bold uppercase text-blue-500">Sudah Dibaca</span>
                    <span class="text-2xl font-extrabold text-blue-700">{{ number_format($readCount) }}</span>
                </a>
                <a href="{{ route('wali-nagari.messages.index', ['status' => 'replied']) }}" class="p-4 rounded-2xl border bg-white {{ $status === 'replied' ? 'border-emerald-500 ring-2 ring-emerald-200' : 'border-slate-200' }} hover:border-emerald-400 transition">
                    <span class="block text-xs font-bold uppercase text-emerald-600">Dibalas / Ditindak</span>
                    <span class="text-2xl font-extrabold text-emerald-700">{{ number_format($repliedCount) }}</span>
                </a>
            </div>

            <!-- Search & Filter Form -->
            <div class="bg-white rounded-2xl border border-slate-200 p-4 sm:p-6 mb-6">
                <form method="GET" action="{{ route('wali-nagari.messages.index') }}" class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-xs font-bold uppercase text-slate-500 mb-1">Cari Pesan</label>
                        <input type="text" name="search" value="{{ $search }}" placeholder="Nama, email, atau katakunci..." class="w-full rounded-xl border border-slate-300 px-3.5 py-2 text-sm focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 outline-none transition" />
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase text-slate-500 mb-1">Status Pesan</label>
                        <select name="status" class="w-full rounded-xl border border-slate-300 px-3.5 py-2 text-sm focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 outline-none transition">
                            <option value="">Semua Status</option>
                            <option value="unread" {{ $status === 'unread' ? 'selected' : '' }}>Belum Dibaca</option>
                            <option value="read" {{ $status === 'read' ? 'selected' : '' }}>Sudah Dibaca</option>
                            <option value="replied" {{ $status === 'replied' ? 'selected' : '' }}>Dibalas / Ditindak</option>
                        </select>
                    </div>

                    <div class="flex items-end gap-2">
                        <button type="submit" class="flex-1 rounded-xl bg-emerald-700 px-4 py-2.5 text-white font-bold text-xs hover:bg-emerald-600 transition shadow-sm">
                            Filter Pesan
                        </button>
                        @if($search || $status)
                            <a href="{{ route('wali-nagari.messages.index') }}" class="px-4 py-2.5 rounded-xl border border-slate-300 text-xs font-semibold text-slate-600 hover:bg-slate-100 transition">
                                Reset
                            </a>
                        @endif
                    </div>
                </form>
            </div>

            <!-- Messages Table -->
            <div class="bg-white rounded-3xl border border-slate-200 overflow-hidden shadow-sm">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50 text-slate-500 text-xs font-bold uppercase tracking-wider border-b border-slate-200">
                                <th class="py-4 px-6">Pengirim</th>
                                <th class="py-4 px-6">Subjek & Pesan</th>
                                <th class="py-4 px-6">Waktu Masuk</th>
                                <th class="py-4 px-6">Status</th>
                                <th class="py-4 px-6 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-sm">
                            @forelse($messages as $msg)
                                <tr class="hover:bg-slate-50/80 transition {{ $msg->isUnread() ? 'bg-amber-50/20 font-medium' : '' }}">
                                    <td class="py-4 px-6 whitespace-nowrap">
                                        <div class="font-bold text-slate-900">{{ $msg->name }}</div>
                                        <div class="text-xs text-slate-500">{{ $msg->email }}</div>
                                        @if($msg->phone)
                                            <div class="text-xs font-mono text-emerald-700">{{ $msg->phone }}</div>
                                        @endif
                                    </td>
                                    <td class="py-4 px-6 max-w-lg">
                                        <div class="font-semibold text-slate-800 line-clamp-1">{{ $msg->subject ?? 'Pesan Publik' }}</div>
                                        <div class="text-xs text-slate-500 line-clamp-2 mt-0.5">{{ $msg->message }}</div>
                                        @if($msg->reply_notes)
                                            <div class="mt-2 p-2 rounded-xl bg-emerald-50 border border-emerald-200 text-xs text-emerald-900">
                                                <strong>Catatan Tindak Lanjut:</strong> {{ Str::limit($msg->reply_notes, 100) }}
                                            </div>
                                        @endif
                                    </td>
                                    <td class="py-4 px-6 whitespace-nowrap text-xs text-slate-500 font-mono">
                                        {{ $msg->created_at->format('d M Y H:i') }}
                                    </td>
                                    <td class="py-4 px-6 whitespace-nowrap">
                                        @if($msg->status === 'unread')
                                            <span class="px-2.5 py-1 rounded-full text-xs font-bold status-unread">Belum Dibaca</span>
                                        @elseif($msg->status === 'replied')
                                            <span class="px-2.5 py-1 rounded-full text-xs font-bold status-replied">Dibalas</span>
                                        @else
                                            <span class="px-2.5 py-1 rounded-full text-xs font-semibold status-read">Sudah Dibaca</span>
                                        @endif
                                    </td>
                                    <td class="py-4 px-6 whitespace-nowrap text-right">
                                        <div class="flex items-center justify-end gap-2">
                                            <button onclick="openMessageModal({{ $msg->id }})" class="px-3 py-1.5 rounded-lg bg-emerald-50 hover:bg-emerald-100 text-emerald-800 text-xs font-bold transition">
                                                Detail
                                            </button>
                                            
                                            <form action="{{ route('wali-nagari.messages.toggle-read', $msg) }}" method="POST" class="inline">
                                                @csrf
                                                <button type="submit" class="px-2.5 py-1.5 rounded-lg border border-slate-200 text-xs font-medium hover:bg-slate-100 text-slate-600 transition">
                                                    {{ $msg->isUnread() ? 'Dibaca' : 'Belum Dibaca' }}
                                                </button>
                                            </form>

                                            <form action="{{ route('wali-nagari.messages.destroy', $msg) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pesan ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="px-2.5 py-1.5 rounded-lg text-xs font-medium text-red-600 hover:bg-red-50 transition">
                                                    Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="py-12 text-center text-slate-400">
                                        <p class="text-base font-semibold text-slate-600">Tidak ada pesan kontak ditemukan</p>
                                        <p class="text-xs text-slate-500 mt-1">Gunakan kata kunci atau filter status lain.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($messages->hasPages())
                    <div class="p-4 border-t border-slate-200">
                        {{ $messages->links() }}
                    </div>
                @endif
            </div>
        </main>
    </div>

    <!-- Detail & Reply Modal -->
    <div id="messageModal" class="fixed inset-0 z-50 bg-slate-900/60 backdrop-blur-sm hidden flex items-center justify-center p-4">
        <div class="bg-white rounded-3xl max-w-2xl w-full p-6 sm:p-8 border border-slate-100 shadow-2xl relative max-h-[90vh] overflow-y-auto">
            <button onclick="closeMessageModal()" class="absolute top-5 right-5 w-8 h-8 rounded-full bg-slate-100 text-slate-500 hover:bg-slate-200 flex items-center justify-center font-bold text-lg transition">&times;</button>

            <div id="modalLoading" class="py-12 text-center">
                <div class="inline-block animate-spin rounded-full h-8 w-8 border-4 border-emerald-600 border-t-transparent"></div>
                <p class="text-xs text-slate-500 mt-2 font-medium">Memuat detail pesan...</p>
            </div>

            <div id="modalBody" class="hidden space-y-6">
                <div class="border-b border-slate-100 pb-4">
                    <span id="modalStatusBadge" class="px-2.5 py-0.5 rounded-full text-xs font-bold inline-block mb-2"></span>
                    <h3 id="modalSubject" class="text-xl font-bold text-slate-900"></h3>
                    <div class="mt-2 text-xs text-slate-500 flex flex-wrap items-center gap-x-4 gap-y-1">
                        <div>Dari: <strong id="modalName" class="text-slate-800"></strong> (<span id="modalEmail" class="text-emerald-700"></span>)</div>
                        <div id="modalPhoneContainer" class="hidden">No. Telp: <span id="modalPhone" class="font-mono text-slate-700"></span></div>
                        <div>Waktu: <span id="modalDate" class="font-mono text-slate-600"></span></div>
                    </div>
                </div>

                <div class="bg-slate-50 rounded-2xl p-4 border border-slate-200">
                    <h4 class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-2">Isi Pesan / Aspirasi:</h4>
                    <p id="modalContent" class="text-sm text-slate-800 leading-relaxed whitespace-pre-line"></p>
                </div>

                <!-- Form Balasan / Catatan Tindak Lanjut -->
                <form id="replyForm" method="POST" action="" class="space-y-3 pt-2 border-t border-slate-100">
                    @csrf
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700">
                        Catatan Balasan / Tindak Lanjut Wali Nagari:
                    </label>
                    <textarea id="modalReplyNotes" name="reply_notes" rows="4" required placeholder="Tuliskan catatan tindak lanjut atau arahan untuk disposisi pesan ini..." class="w-full rounded-2xl border border-slate-300 p-3.5 text-sm focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 outline-none transition"></textarea>

                    <div class="flex items-center justify-end gap-3 pt-2">
                        <button type="button" onclick="closeMessageModal()" class="px-5 py-2.5 rounded-xl border border-slate-200 text-xs font-semibold text-slate-700 hover:bg-slate-100 transition">
                            Tutup
                        </button>
                        <button type="submit" class="px-5 py-2.5 rounded-xl bg-emerald-700 hover:bg-emerald-600 text-white text-xs font-bold shadow-sm transition">
                            Simpan Tindak Lanjut / Balasan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function openMessageModal(id) {
            const modal = document.getElementById('messageModal');
            const loading = document.getElementById('modalLoading');
            const body = document.getElementById('modalBody');

            modal.classList.remove('hidden');
            loading.classList.remove('hidden');
            body.classList.add('hidden');

            fetch("{{ url('/wali-nagari/messages') }}/" + id)
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        const m = data.message;
                        document.getElementById('modalSubject').innerText = m.subject || 'Pesan dari Kontak Kami';
                        document.getElementById('modalName').innerText = m.name;
                        document.getElementById('modalEmail').innerText = m.email;
                        
                        if (m.phone) {
                            document.getElementById('modalPhone').innerText = m.phone;
                            document.getElementById('modalPhoneContainer').classList.remove('hidden');
                        } else {
                            document.getElementById('modalPhoneContainer').classList.add('hidden');
                        }

                        document.getElementById('modalDate').innerText = data.formatted_date;
                        document.getElementById('modalContent').innerText = m.message;
                        document.getElementById('modalReplyNotes').value = m.reply_notes || '';

                        const badge = document.getElementById('modalStatusBadge');
                        if (m.status === 'replied') {
                            badge.className = 'px-2.5 py-0.5 rounded-full text-xs font-bold status-replied';
                            badge.innerText = 'Dibalas / Ditindaklanjuti';
                        } else if (m.status === 'read') {
                            badge.className = 'px-2.5 py-0.5 rounded-full text-xs font-bold status-read';
                            badge.innerText = 'Sudah Dibaca';
                        } else {
                            badge.className = 'px-2.5 py-0.5 rounded-full text-xs font-bold status-unread';
                            badge.innerText = 'Belum Dibaca';
                        }

                        // set form action
                        document.getElementById('replyForm').action = "{{ url('/wali-nagari/messages') }}/" + id + "/reply";

                        loading.classList.add('hidden');
                        body.classList.remove('hidden');
                    }
                })
                .catch(err => {
                    alert('Gagal mengambil data pesan.');
                    closeMessageModal();
                });
        }

        function closeMessageModal() {
            document.getElementById('messageModal').classList.add('hidden');
        }
    </script>
</body>
</html>
