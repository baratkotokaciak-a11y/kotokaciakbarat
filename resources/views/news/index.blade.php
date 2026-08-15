<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Kelola Berita — Admin Nagari</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
    <style>
        :root {
            --primary: #059669;
            --primary-dark: #047857;
            --secondary: #2563eb;
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
        .container { max-width: 1100px; margin: 0 auto; }
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
        .header-card h1 { font-size: 1.85rem; font-weight: 800; }
        .header-card p { color: #cbd5e1; font-size: 0.95rem; margin-top: 0.35rem; }
        .btn-add {
            background: #ffffff;
            color: var(--primary-dark);
            padding: 0.75rem 1.5rem;
            border-radius: 0.75rem;
            text-decoration: none;
            font-weight: 700;
            font-size: 0.95rem;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            transition: all 0.2s;
        }
        .btn-add:hover { background: #f0fdf4; transform: translateY(-2px); }
        .alert-success {
            background: #ecfdf5; border: 1px solid #a7f3d0; color: #065f46;
            padding: 1rem 1.25rem; border-radius: 0.75rem; margin-bottom: 1.5rem; font-weight: 600;
        }
        .news-card {
            background: var(--card-bg);
            border-radius: 1.25rem;
            border: 1px solid var(--border-color);
            padding: 1.5rem;
            margin-bottom: 1.25rem;
            display: flex;
            gap: 1.5rem;
            align-items: flex-start;
            box-shadow: 0 4px 15px rgba(0,0,0,0.02);
            transition: all 0.2s;
        }
        .news-card:hover { transform: translateY(-2px); box-shadow: 0 8px 25px rgba(0,0,0,0.05); }
        .news-card img {
            width: 180px; height: 120px; object-fit: cover; border-radius: 0.75rem; flex-shrink: 0;
        }
        .news-info { flex: 1; }
        .topic-badge {
            display: inline-block;
            background: #fef2f2;
            color: #dc2626;
            font-size: 0.75rem;
            font-weight: 700;
            padding: 0.2rem 0.6rem;
            border-radius: 0.5rem;
            text-transform: uppercase;
            letter-spacing: 0.03em;
            margin-bottom: 0.4rem;
        }
        .news-title {
            font-size: 1.2rem;
            font-weight: 700;
            color: var(--text-dark);
            text-decoration: none;
            line-height: 1.35;
        }
        .news-title:hover { color: var(--primary); }
        .meta-line {
            font-size: 0.85rem;
            color: var(--text-muted);
            margin-top: 0.5rem;
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
        }
        .actions {
            display: flex;
            gap: 0.5rem;
            margin-top: 1rem;
        }
        .btn-action {
            padding: 0.45rem 1rem;
            border-radius: 0.5rem;
            font-size: 0.85rem;
            font-weight: 600;
            text-decoration: none;
            border: none;
            cursor: pointer;
            transition: all 0.15s;
        }
        .btn-view { background: #e0f2fe; color: #0369a1; }
        .btn-view:hover { background: #bae6fd; }
        .btn-edit { background: #fef3c7; color: #b45309; }
        .btn-edit:hover { background: #fde68a; }
        .btn-delete { background: #fee2e2; color: #b91c1c; }
        .btn-delete:hover { background: #fca5a5; }
        @media (max-width: 768px) {
            .news-card { flex-direction: column; }
            .news-card img { width: 100%; height: 180px; }
            .header-card { flex-direction: column; align-items: flex-start; gap: 1rem; }
        }
    </style>
</head>
<body>

<div class="container">
    <div class="header-card">
        <div>
            <h1>Manajemen Berita Nagari</h1>
            <p>Kelola semua berita, pengumuman, dan agenda publik Koto Kaciak Barat</p>
        </div>
        <a href="{{ route('news.create') }}" class="btn-add">+ Tambah Berita Baru</a>
    </div>

    @if(session('success'))
        <div class="alert-success">
            ✨ {{ session('success') }}
        </div>
    @endif

    @forelse($news as $item)
        <div class="news-card">
            @if($item->image)
                <img src="{{ $item->image }}" alt="{{ $item->title }}" />
            @else
                <img src="https://images.unsplash.com/photo-1519337265831-281ec6cc8514?auto=format&fit=crop&w=800&q=80" alt="Default Image" />
            @endif

            <div class="news-info">
                @if($item->topic)
                    <span class="topic-badge">{{ $item->topic }}</span>
                @endif
                <h3 style="margin: 0;">
                    <a href="{{ route('news.detail', $item->id) }}" target="_blank" class="news-title">{{ $item->title }}</a>
                </h3>

                <div class="meta-line">
                    <span>📅 {{ $item->formatted_tayang }}</span>
                    <span>✍️ Penulis: {{ $item->author ?? 'Hafidh Rizky Pratama' }}</span>
                    <span>✏️ Editor: {{ $item->editor ?? 'Drajat Sugiri' }}</span>
                    <span>📁 {{ $item->type ?? 'Berita Nagari' }}</span>
                </div>

                @if($item->caption)
                    <p style="font-size: 0.8rem; color: #64748b; font-style: italic; margin-top: 0.35rem;">
                        📷 {{ $item->caption }}
                    </p>
                @endif

                <div class="actions">
                    <a href="{{ route('news.detail', $item->id) }}" target="_blank" class="btn-action btn-view">👁️ Lihat Reader View</a>
                    <a href="{{ route('news.edit', $item->id) }}" class="btn-action btn-edit">✏️ Edit</a>
                    <form action="{{ route('news.destroy', $item->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Hapus berita ini secara permanen?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-action btn-delete">🗑️ Hapus</button>
                    </form>
                </div>
            </div>
        </div>
    @empty
        <div style="background: white; padding: 3rem; text-align: center; border-radius: 1.25rem; border: 1px solid var(--border-color);">
            <p style="color: var(--text-muted); font-size: 1.1rem;">Belum ada berita yang ditambahkan.</p>
            <a href="{{ route('news.create') }}" class="btn-add" style="display: inline-block; margin-top: 1rem; background: var(--primary); color: white;">+ Buat Berita Pertama</a>
        </div>
    @endforelse

    <div style="margin-top: 2rem;">
        {{ $news->links() }}
    </div>
</div>

</body>
</html>
