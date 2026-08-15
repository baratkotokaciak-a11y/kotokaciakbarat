<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Berita — Admin Nagari</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #059669;
            --primary-dark: #047857;
            --secondary: #2563eb;
            --accent-red: #dc2626;
            --bg-body: #f8fafc;
            --card-bg: #ffffff;
            --border-color: #e2e8f0;
            --text-dark: #0f172a;
            --text-muted: #64748b;
        }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--bg-body);
            color: var(--text-dark);
            min-height: 100vh;
            padding: 2.5rem 1rem;
        }
        .container {
            max-width: 900px;
            margin: 0 auto;
        }
        .header-card {
            background: linear-gradient(135deg, #047857 0%, #1e40af 100%);
            color: #ffffff;
            border-radius: 1.25rem;
            padding: 2.25rem 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 10px 25px -5px rgba(5, 150, 105, 0.25);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .header-card h1 {
            font-size: 1.85rem;
            font-weight: 800;
            letter-spacing: -0.02em;
        }
        .header-card p {
            color: #cbd5e1;
            font-size: 0.95rem;
            margin-top: 0.35rem;
        }
        .back-btn {
            background: rgba(255, 255, 255, 0.2);
            color: #fff;
            padding: 0.6rem 1.25rem;
            border-radius: 0.75rem;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.9rem;
            backdrop-filter: blur(10px);
            transition: all 0.2s;
        }
        .back-btn:hover {
            background: rgba(255, 255, 255, 0.35);
            transform: translateY(-2px);
        }
        .form-card {
            background: var(--card-bg);
            border-radius: 1.25rem;
            border: 1px solid var(--border-color);
            padding: 2.5rem;
            box-shadow: 0 4px 20px rgba(0,0,0,0.03);
        }
        .section-title {
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 1.25rem;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid #f1f5f9;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        .grid-2 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.25rem;
        }
        .form-group {
            margin-bottom: 1.5rem;
        }
        label {
            display: block;
            font-weight: 600;
            font-size: 0.9rem;
            color: #334155;
            margin-bottom: 0.5rem;
        }
        label span.required {
            color: var(--accent-red);
        }
        input[type="text"],
        input[type="date"],
        select,
        textarea {
            width: 100%;
            padding: 0.8rem 1rem;
            border: 1.5px solid var(--border-color);
            border-radius: 0.75rem;
            background: #fff;
            font-family: inherit;
            font-size: 0.95rem;
            color: var(--text-dark);
            transition: all 0.2s ease-in-out;
        }
        input[type="text"]:focus,
        input[type="date"]:focus,
        select:focus,
        textarea:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(5, 150, 105, 0.12);
        }
        textarea {
            resize: vertical;
        }
        .help-text {
            font-size: 0.8rem;
            color: var(--text-muted);
            margin-top: 0.35rem;
        }
        .btn-submit {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: white;
            border: none;
            padding: 0.95rem 2rem;
            border-radius: 0.75rem;
            font-size: 1rem;
            font-weight: 700;
            cursor: pointer;
            width: 100%;
            transition: all 0.2s ease-in-out;
            box-shadow: 0 4px 12px rgba(5, 150, 105, 0.25);
            margin-top: 1rem;
        }
        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 18px rgba(5, 150, 105, 0.35);
        }
        .alert-success {
            background: #ecfdf5;
            border: 1px solid #a7f3d0;
            color: #065f46;
            padding: 1rem 1.25rem;
            border-radius: 0.75rem;
            margin-bottom: 1.5rem;
            font-weight: 600;
        }
        .img-preview {
            margin-top: 0.75rem;
            border-radius: 0.75rem;
            max-width: 250px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }
        @media (max-width: 768px) {
            .grid-2 { grid-template-columns: 1fr; }
            .form-card { padding: 1.5rem; }
            .header-card { flex-direction: column; align-items: flex-start; gap: 1rem; }
        }
    </style>
</head>
<body>

<div class="container">
    <div class="header-card">
        <div>
            <h1>Edit Berita</h1>
            <p>Perbarui informasi berita nagari secara realtime</p>
        </div>
        <a href="{{ route('news.index') }}" class="back-btn">← Kembali ke Daftar</a>
    </div>

    @if(session('success'))
        <div class="alert-success">
            ✨ {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div style="background: #fef2f2; border: 1px solid #fecaca; color: #991b1b; padding: 1rem 1.25rem; border-radius: 0.75rem; margin-bottom: 1.5rem;">
            <strong style="display:block; margin-bottom: 0.5rem;">Mohon periksa kembali inputan Anda:</strong>
            <ul style="padding-left: 1.25rem;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="form-card">
        <form method="POST" action="{{ route('news.update', $news) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Section 1: Header & Kategori -->
            <div class="section-title">
                🏷️ Identitas & Kategori Berita
            </div>

            <div class="grid-2">
                <div class="form-group">
                    <label for="topic">Topik / Sub-Headline (Merah) <span class="required">*</span></label>
                    <input type="text" id="topic" name="topic" value="{{ old('topic', $news->topic ?? 'Nagari Koto Kaciak Barat') }}" placeholder="Contoh: Piala AFF 2026, Pemerintahan Nagari" required>
                    <div class="help-text">Tampil sebagai teks merah bold di atas judul utama.</div>
                </div>

                <div class="form-group">
                    <label for="type">Kategori / Navigasi Utama</label>
                    <input type="text" id="type" name="type" value="{{ old('type', $news->type ?? 'Berita Nagari') }}" placeholder="Contoh: Super Skor, Berita Nagari, Informasi, Pengumuman">
                    <div class="help-text">Dapat berupa: Berita Nagari, Super Skor, Informasi, Agenda, Pengumuman.</div>
                </div>
            </div>

            <div class="form-group">
                <label for="title">Judul Berita Utama <span class="required">*</span></label>
                <input type="text" id="title" name="title" value="{{ old('title', $news->title) }}" placeholder="Masukkan judul headline berita..." required>
            </div>

            <!-- Section 2: Penulis, Editor & Tanggal -->
            <div class="section-title" style="margin-top: 2rem;">
                ✍️ Metadata Penulis, Editor & Tanggal Tayang
            </div>

            <div class="grid-2">
                <div class="form-group">
                    <label for="author">Nama Penulis</label>
                    <input type="text" id="author" name="author" value="{{ old('author', $news->author ?? 'Hafidh Rizky Pratama') }}" placeholder="Masukkan nama penulis...">
                </div>

                <div class="form-group">
                    <label for="editor">Nama Editor</label>
                    <input type="text" id="editor" name="editor" value="{{ old('editor', $news->editor ?? 'Drajat Sugiri') }}" placeholder="Masukkan nama editor...">
                </div>
            </div>

            <div class="form-group">
                <label for="date">Tanggal & Jam Tayang</label>
                <input type="date" id="date" name="date" value="{{ old('date', $news->date ? $news->date->format('Y-m-d') : date('Y-m-d')) }}">
            </div>

            <!-- Section 3: Gambar & Caption -->
            <div class="section-title" style="margin-top: 2rem;">
                🖼️ Gambar Utama & Keterangan Foto
            </div>

            <div class="form-group">
                <label for="image">File Gambar Utama Baru (Opsional)</label>
                <input type="file" id="image" name="image" accept="image/*">
                @if($news->image)
                    <div style="margin-top:0.75rem;">
                        <p style="font-size:0.85rem; color:var(--text-muted);">Gambar saat ini:</p>
                        <img src="{{ $news->image }}" alt="{{ $news->title }}" class="img-preview" />
                    </div>
                @endif
            </div>

            <div class="form-group">
                <label for="caption">Keterangan Foto (Caption Foto)</label>
                <input type="text" id="caption" name="caption" value="{{ old('caption', $news->caption) }}" placeholder="Contoh: Perangkat Nagari Koto Kaciak Barat saat kegiatan...">
                <div class="help-text">Ditampilkan di bawah gambar utama berita.</div>
            </div>

            <!-- Section 4: Konten Berita -->
            <div class="section-title" style="margin-top: 2rem;">
                📝 Ringkasan & Isi Berita
            </div>

            <div class="form-group">
                <label for="summary">Ringkasan Singkat (Lead / Teaser)</label>
                <textarea id="summary" name="summary" rows="3">{{ old('summary', $news->summary) }}</textarea>
            </div>

            <div class="form-group">
                <label for="body">Isi Berita Lengkap <span class="required">*</span></label>
                <textarea id="body" name="body" rows="12" required>{{ old('body', $news->body) }}</textarea>
            </div>

            <button type="submit" class="btn-submit">💾 Simpan Perubahan Berita</button>
        </form>
    </div>
</div>

</body>
</html>
