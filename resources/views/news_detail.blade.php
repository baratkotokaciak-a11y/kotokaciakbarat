<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{{ $item->title ?? 'Berita Nagari Koto Kaciak Barat' }}</title>
    <meta name="description" content="{{ $item->summary ?? '' }}" />

    <!-- Google Fonts: Serif for Headlines, Inter for UI & Body -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Georgia&family=Inter:wght@400;500;600;700&family=Merriweather:wght@400;700;900&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary-blue: #0284c7;
            --ribbon-home: #0271b9;
            --ribbon-type: #4b92db;
            --ribbon-sub: #b2d7fc;
            --topic-red: #b91c1c;
            --text-dark: #1c1917;
            --text-muted: #64748b;
            --border-color: #e2e8f0;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            background-color: #ffffff;
            color: var(--text-dark);
            line-height: 1.6;
        }

        /* RIBBON / BREADCRUMB HEADER */
        .ribbon-header-wrapper {
            background-color: #f1f5f9;
            border-bottom: 1px solid #e2e8f0;
            width: 100%;
        }
        .ribbon-container {
            max-width: 1100px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            height: 42px;
            padding: 0 1rem;
        }
        .ribbon-bar {
            display: flex;
            align-items: center;
            height: 100%;
        }
        .ribbon-tab {
            height: 100%;
            display: inline-flex;
            align-items: center;
            padding: 0 1.5rem 0 1.2rem;
            font-size: 0.85rem;
            font-weight: 600;
            text-decoration: none;
            position: relative;
            clip-path: polygon(0 0, 84% 0, 100% 100%, 0% 100%);
            margin-right: -10px;
            transition: opacity 0.2s;
        }
        .ribbon-tab:hover { opacity: 0.9; }
        .ribbon-home {
            background-color: var(--ribbon-home);
            color: #ffffff;
            z-index: 3;
            padding-left: 1.2rem;
        }
        .ribbon-type {
            background-color: var(--ribbon-type);
            color: #ffffff;
            z-index: 2;
            padding-left: 1.8rem;
        }
        .ribbon-sub {
            background-color: var(--ribbon-sub);
            color: #1e3a8a;
            z-index: 1;
            padding-left: 1.8rem;
            clip-path: polygon(0 0, 84% 0, 100% 100%, 0% 100%);
        }

        /* MAIN CONTENT LAYOUT */
        .main-wrapper {
            max-width: 1100px;
            margin: 2rem auto;
            padding: 0 1rem;
            display: grid;
            grid-template-columns: 1fr 320px;
            gap: 2.5rem;
        }

        /* ARTICLE SECTION */
        .article-topic {
            color: var(--topic-red);
            font-family: 'Merriweather', 'Georgia', serif;
            font-size: 1.25rem;
            font-weight: 700;
            margin-bottom: 0.6rem;
        }
        .article-title {
            font-family: 'Merriweather', 'Georgia', serif;
            font-size: 2.4rem;
            font-weight: 900;
            line-height: 1.22;
            color: #111827;
            letter-spacing: -0.01em;
            margin-bottom: 1.25rem;
        }
        .article-timestamp {
            font-size: 0.88rem;
            color: var(--text-muted);
            margin-bottom: 0.5rem;
        }
        .article-timestamp strong {
            color: #475569;
            font-weight: 600;
        }

        .article-meta-authors {
            font-size: 0.88rem;
            color: #334155;
            padding-bottom: 1rem;
            border-bottom: 1px solid var(--border-color);
            margin-bottom: 1rem;
        }
        .article-meta-authors a {
            color: var(--primary-blue);
            text-decoration: none;
            font-weight: 600;
        }
        .article-meta-authors a:hover {
            text-decoration: underline;
        }

        /* TOOLBAR ACTIONS & SHARE */
        .article-toolbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0.6rem 0;
            border-bottom: 1px solid var(--border-color);
            margin-bottom: 1.75rem;
            flex-wrap: wrap;
            gap: 1rem;
        }
        .toolbar-left, .toolbar-right {
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        .action-btn {
            background: none;
            border: none;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            font-size: 1.1rem;
            color: #475569;
            padding: 0.4rem 0.6rem;
            border-radius: 0.5rem;
            transition: all 0.2s;
            text-decoration: none;
        }
        .action-btn:hover {
            background: #f1f5f9;
            color: #0f172a;
        }
        .action-btn.active {
            color: var(--primary-blue);
            background: #e0f2fe;
        }
        .action-count {
            font-size: 0.85rem;
            font-weight: 600;
        }

        /* FEATURED IMAGE CONTAINER */
        .media-container {
            position: relative;
            width: 100%;
            margin-bottom: 0.75rem;
            border-radius: 0.25rem;
            overflow: hidden;
            background: #000;
        }
        .media-container img {
            width: 100%;
            height: auto;
            max-height: 520px;
            object-fit: cover;
            display: block;
            transition: transform 0.3s;
        }
        .overlay-photo-btn {
            position: absolute;
            top: 12px;
            right: 12px;
            background: rgba(0, 0, 0, 0.75);
            color: #ffffff;
            border: none;
            padding: 0.4rem 0.85rem;
            border-radius: 0.4rem;
            font-size: 0.85rem;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 0.4rem;
            backdrop-filter: blur(4px);
            transition: background 0.2s;
            z-index: 10;
        }
        .overlay-photo-btn:hover {
            background: rgba(0, 0, 0, 0.9);
        }
        .image-caption-text {
            font-size: 0.85rem;
            color: #64748b;
            margin-bottom: 2rem;
            line-height: 1.45;
        }

        /* ARTICLE BODY CONTENT */
        .article-body-text {
            font-size: 1.05rem;
            line-height: 1.8;
            color: #1e293b;
        }
        .article-body-text p {
            margin-bottom: 1.5rem;
        }

        /* SIDEBAR */
        .sidebar-card {
            background: #f8fafc;
            border-radius: 1rem;
            padding: 1.5rem;
            border: 1px solid var(--border-color);
            position: sticky;
            top: 2rem;
        }
        .sidebar-title {
            font-size: 1.15rem;
            font-weight: 800;
            color: #0f172a;
            margin-bottom: 1.25rem;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid var(--primary-blue);
        }
        .sidebar-list {
            list-style: none;
        }
        .sidebar-item {
            margin-bottom: 1.1rem;
            padding-bottom: 1.1rem;
            border-bottom: 1px dashed #cbd5e1;
        }
        .sidebar-item:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }
        .sidebar-link {
            text-decoration: none;
            color: #1e293b;
            font-weight: 600;
            font-size: 0.95rem;
            line-height: 1.4;
            display: block;
            transition: color 0.2s;
        }
        .sidebar-link:hover {
            color: var(--primary-blue);
        }
        .sidebar-date {
            font-size: 0.78rem;
            color: #64748b;
            margin-top: 0.35rem;
        }

        /* NAV PAGINATION */
        .nav-pagination {
            display: flex;
            justify-content: space-between;
            margin-top: 3rem;
            padding-top: 1.5rem;
            border-top: 1px solid var(--border-color);
        }
        .nav-pagination a {
            color: var(--primary-blue);
            text-decoration: none;
            font-weight: 600;
            font-size: 0.95rem;
            display: flex;
            align-items: center;
            gap: 0.4rem;
        }
        .nav-pagination a:hover {
            text-decoration: underline;
        }

        /* MODAL PREVIEW IMAGE */
        .photo-modal {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.92);
            z-index: 9999;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }
        .photo-modal.active {
            display: flex;
        }
        .photo-modal-img {
            max-width: 90vw;
            max-height: 85vh;
            border-radius: 0.5rem;
            box-shadow: 0 10px 30px rgba(0,0,0,0.5);
        }
        .photo-modal-close {
            position: absolute;
            top: 20px;
            right: 25px;
            color: #ffffff;
            font-size: 2.5rem;
            font-weight: 700;
            cursor: pointer;
            background: none;
            border: none;
        }

        /* TOAST NOTIFICATION */
        .toast-notify {
            position: fixed;
            bottom: 2rem;
            right: 2rem;
            background: #0f172a;
            color: #ffffff;
            padding: 0.75rem 1.25rem;
            border-radius: 0.5rem;
            font-size: 0.9rem;
            font-weight: 500;
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
            opacity: 0;
            transform: translateY(20px);
            transition: all 0.3s;
            pointer-events: none;
            z-index: 10000;
        }
        .toast-notify.show {
            opacity: 1;
            transform: translateY(0);
        }

        @media (max-width: 868px) {
            .main-wrapper {
                grid-template-columns: 1fr;
            }
            .article-title {
                font-size: 1.85rem;
            }
        }
    </style>
</head>
<body>

    <!-- RIBBON BREADCRUMB NAVIGATION -->
    <div class="ribbon-header-wrapper">
        <div class="ribbon-container">
            <div class="ribbon-bar">
                <a href="{{ route('news.page') }}" class="ribbon-tab ribbon-home">Home</a>
                <a href="{{ route('news.page') }}" class="ribbon-tab ribbon-type">{{ $item->type ?? 'Berita Nagari' }}</a>
                <span class="ribbon-tab ribbon-sub">{{ $item->topic ?? 'Lainnya' }}</span>
            </div>
        </div>
    </div>

    <!-- MAIN READER WRAPPER -->
    <div class="main-wrapper">
        <main class="article-section">

            <!-- RED TOPIC / SUB-HEADLINE -->
            <div class="article-topic">
                {{ $item->topic ?? 'Nagari Koto Kaciak Barat' }}
            </div>

            <!-- MAIN HEADLINE -->
            <h1 class="article-title">
                {{ $item->title }}
            </h1>

            <!-- TIMESTAMP -->
            <div class="article-timestamp">
                <strong>Tayang:</strong> {{ $item->formatted_tayang }}
            </div>

            <!-- AUTHORS & EDITORS -->
            <div class="article-meta-authors">
                <strong>Penulis:</strong> <a href="#">{{ $item->author ?? 'Hafidh Rizky Pratama' }}</a><br>
                <strong>Editor:</strong> <a href="#">{{ $item->editor ?? 'Drajat Sugiri' }}</a>
            </div>

            <!-- ACTION & SHARE BAR -->
            <div class="article-toolbar">
                <div class="toolbar-left">
                    <!-- LIKE -->
                    <button class="action-btn" id="likeBtn" onclick="toggleReaction('like')">
                        <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M14 9V5a3 3 0 0 0-3-3l-4 9v11h11.28a2 2 0 0 0 2-1.7l1.38-9a2 2 0 0 0-2-2.3zM7 22H4a2 2 0 0 1-2-2v-7a2 2 0 0 1 2-2h3"></path></svg>
                        <span class="action-count" id="likeCount">12</span>
                    </button>

                    <!-- DISLIKE -->
                    <button class="action-btn" id="dislikeBtn" onclick="toggleReaction('dislike')">
                        <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M10 15v4a3 3 0 0 0 3 3l4-9V2H5.72a2 2 0 0 0-2 1.7l-1.38 9a2 2 0 0 0 2 2.3zm7-13h3a2 2 0 0 1 2 2v7a2 2 0 0 1-2 2h-3"></path></svg>
                        <span class="action-count" id="dislikeCount">0</span>
                    </button>
                </div>

                <div class="toolbar-right">
                    <!-- X / TWITTER -->
                    <a href="https://twitter.com/intent/tweet?text={{ urlencode($item->title) }}&url={{ urlencode(url()->current()) }}" target="_blank" class="action-btn" title="Bagikan ke X (Twitter)">
                        <svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                    </a>

                    <!-- FACEBOOK -->
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" target="_blank" class="action-btn" title="Bagikan ke Facebook">
                        <svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                    </a>

                    <!-- WHATSAPP -->
                    <a href="https://api.whatsapp.com/send?text={{ urlencode($item->title . ' ' . url()->current()) }}" target="_blank" class="action-btn" title="Bagikan ke WhatsApp">
                        <svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981z"/></svg>
                    </a>

                    <!-- TELEGRAM -->
                    <a href="https://t.me/share/url?url={{ urlencode(url()->current()) }}&text={{ urlencode($item->title) }}" target="_blank" class="action-btn" title="Bagikan ke Telegram">
                        <svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0C5.37 0 0 5.37 0 12s5.37 12 12 12 12-5.37 12-12S18.63 0 12 0zm5.562 8.161c-.18.717-.962 4.084-1.362 5.407-.168.56-.479.747-.779.765-.653.038-1.15-.433-1.783-.848-.99-.648-1.55-1.05-2.512-1.684-1.112-.733-.391-1.137.243-1.796.166-.172 3.048-2.794 3.104-3.033.007-.03.013-.146-.056-.207s-.174-.041-.249-.024c-.106.024-1.793 1.14-5.061 3.345-.48.33-.913.49-1.302.481-.428-.008-1.252-.241-1.865-.44-.752-.244-1.349-.374-1.297-.789.027-.216.325-.437.893-.663 3.498-1.524 5.831-2.529 6.998-3.014 3.332-1.386 4.025-1.627 4.476-1.635.099-.002.321.023.465.14.121.098.155.23.17.324.015.094.032.309.017.477z"/></svg>
                    </a>

                    <!-- COMMENT -->
                    <a href="#comments" class="action-btn" title="Lihat Komentar">
                        <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path></svg>
                    </a>

                    <!-- COPY LINK -->
                    <button class="action-btn" onclick="copyArticleLink()" title="Salin Tautan">
                        <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"></path><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"></path></svg>
                    </button>
                </div>
            </div>

            <!-- FEATURED MEDIA WITH "LIHAT FOTO" OVERLAY -->
            <div class="media-container">
                <img id="mainArticleImg" src="{{ $item->image }}" alt="{{ $item->title }}" />
                <button class="overlay-photo-btn" onclick="openPhotoModal()">
                    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 3 21 3 21 9"></polyline><polyline points="9 21 3 21 3 15"></polyline><line x1="21" y1="3" x2="14" y2="10"></line><line x1="3" y1="21" x2="10" y2="14"></line></svg>
                    lihat foto
                </button>
            </div>

            @if(!empty($item->caption))
                <div class="image-caption-text">
                    {{ $item->caption }}
                </div>
            @endif

            <!-- ARTICLE CONTENT BODY -->
            <div class="article-body-text">
                @if(!empty($item->summary))
                    <p style="font-weight: 700; color: #334155; font-size: 1.1rem; line-height: 1.6;">
                        {{ $item->summary }}
                    </p>
                @endif

                @if(!empty($item->body))
                    {!! nl2br(e($item->body)) !!}
                @else
                    <p style="color: #64748b; font-style: italic;">Isi konten berita sedang diperbarui.</p>
                @endif
            </div>

            <!-- NEXT / PREV PAGINATION -->
            <div class="nav-pagination">
                @if($prev)
                    <a href="{{ route('news.detail', $prev) }}">← Berita Sebelumnya</a>
                @else
                    <span></span>
                @endif

                @if($next)
                    <a href="{{ route('news.detail', $next) }}">Berita Selanjutnya →</a>
                @endif
            </div>

        </main>

        <!-- SIDEBAR -->
        <aside class="sidebar-section">
            <div class="sidebar-card">
                <div class="sidebar-title">
                    Berita Terkait & Terbaru
                </div>
                <ul class="sidebar-list">
                    @foreach($recent as $r)
                        <li class="sidebar-item">
                            <a href="{{ route('news.detail', $r->id) }}" class="sidebar-link">
                                {{ $r->title }}
                            </a>
                            <div class="sidebar-date">
                                {{ $r->date ? $r->date->format('d M Y') : '' }}
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </aside>
    </div>

    <!-- PHOTO MODAL ZOOM -->
    <div class="photo-modal" id="photoModal" onclick="closePhotoModal()">
        <button class="photo-modal-close" onclick="closePhotoModal()">&times;</button>
        <img src="{{ $item->image }}" alt="{{ $item->title }}" class="photo-modal-img" onclick="event.stopPropagation()" />
    </div>

    <!-- TOAST NOTIFICATION -->
    <div class="toast-notify" id="toastNotify">
        Link berita berhasil disalin ke clipboard!
    </div>

    <script>
        function openPhotoModal() {
            document.getElementById('photoModal').classList.add('active');
        }
        function closePhotoModal() {
            document.getElementById('photoModal').classList.remove('active');
        }
        function copyArticleLink() {
            navigator.clipboard.writeText(window.location.href).then(() => {
                const toast = document.getElementById('toastNotify');
                toast.classList.add('show');
                setTimeout(() => toast.classList.remove('show'), 3000);
            });
        }
        let liked = false;
        let disliked = false;
        function toggleReaction(type) {
            const likeBtn = document.getElementById('likeBtn');
            const dislikeBtn = document.getElementById('dislikeBtn');
            const likeCount = document.getElementById('likeCount');
            const dislikeCount = document.getElementById('dislikeCount');

            let likes = parseInt(likeCount.innerText);
            let dislikes = parseInt(dislikeCount.innerText);

            if (type === 'like') {
                if (!liked) {
                    liked = true;
                    likes++;
                    likeBtn.classList.add('active');
                    if (disliked) {
                        disliked = false;
                        dislikes = Math.max(0, dislikes - 1);
                        dislikeBtn.classList.remove('active');
                    }
                } else {
                    liked = false;
                    likes = Math.max(0, likes - 1);
                    likeBtn.classList.remove('active');
                }
            } else if (type === 'dislike') {
                if (!disliked) {
                    disliked = false; // reset
                    disliked = true;
                    dislikes++;
                    dislikeBtn.classList.add('active');
                    if (liked) {
                        liked = false;
                        likes = Math.max(0, likes - 1);
                        likeBtn.classList.remove('active');
                    }
                } else {
                    disliked = false;
                    dislikes = Math.max(0, dislikes - 1);
                    dislikeBtn.classList.remove('active');
                }
            }

            likeCount.innerText = likes;
            dislikeCount.innerText = dislikes;
        }
    </script>
</body>
</html>
