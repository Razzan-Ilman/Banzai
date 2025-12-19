@extends('layouts.app')

@section('title', 'Blog & Berita')

@section('content')
<style>
    .blog-hero {
        background: linear-gradient(135deg, var(--indigo-900), var(--indigo-800));
        color: white;
        padding: var(--space-8) 0;
        text-align: center;
    }

    .category-filter {
        display: flex;
        gap: var(--space-2);
        justify-content: center;
        flex-wrap: wrap;
        margin: var(--space-4) 0;
    }

    .category-btn {
        padding: var(--space-2) var(--space-4);
        border-radius: var(--radius-full);
        background: white;
        border: 2px solid var(--ink-300);
        color: var(--ink-700);
        font-weight: var(--fw-semibold);
        cursor: pointer;
        transition: all var(--transition-base);
    }

    .category-btn:hover,
    .category-btn.active {
        background: var(--antique-gold);
        color: white;
        border-color: var(--gold-700);
    }

    .article-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
        gap: var(--space-4);
        margin: var(--space-6) 0;
    }

    .article-card {
        background: white;
        border-radius: var(--radius-lg);
        overflow: hidden;
        box-shadow: var(--shadow-md);
        transition: transform var(--transition-base);
    }

    .article-card:hover {
        transform: translateY(-4px);
        box-shadow: var(--shadow-xl);
    }

    .article-image {
        width: 100%;
        height: 200px;
        object-fit: cover;
        background: var(--ivory-300);
    }

    .article-content {
        padding: var(--space-4);
    }

    .article-category {
        display: inline-block;
        padding: var(--space-1) var(--space-2);
        background: var(--gold-300);
        color: var(--ink-900);
        border-radius: var(--radius-sm);
        font-size: var(--body-small);
        font-weight: var(--fw-semibold);
        margin-bottom: var(--space-2);
    }

    .article-title {
        font-size: var(--h4);
        color: var(--ink-900);
        margin-bottom: var(--space-2);
        line-height: var(--lh-tight);
    }

    .article-excerpt {
        color: var(--ink-600);
        line-height: var(--lh-relaxed);
        margin-bottom: var(--space-3);
    }

    .article-meta {
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: var(--body-small);
        color: var(--ink-500);
    }
</style>

<section class="blog-hero">
    <div class="container">
        <h1 style="font-size: var(--h1); margin-bottom: var(--space-2);">Blog & Berita</h1>
        <p style="font-size: var(--body-large); opacity: 0.9;">
            Cerita, tips, dan update terbaru dari BANZAI
        </p>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="category-filter">
            <button class="category-btn active" data-category="all">Semua</button>
            <button class="category-btn" data-category="bahasa">Bahasa</button>
            <button class="category-btn" data-category="budaya">Budaya</button>
            <button class="category-btn" data-category="medsos">Media Sosial</button>
            <button class="category-btn" data-category="event">Event</button>
        </div>

        <div class="article-grid">
            {{-- Sample Articles - Replace with actual data from database --}}
            <article class="article-card" data-category="bahasa">
                <img src="{{ asset('images/blog/placeholder.jpg') }}" alt="Article" class="article-image">
                <div class="article-content">
                    <span class="article-category">Bahasa</span>
                    <h2 class="article-title">Tips Belajar Hiragana dan Katakana untuk Pemula</h2>
                    <p class="article-excerpt">
                        Memulai belajar bahasa Jepang? Hiragana dan Katakana adalah fondasi yang harus dikuasai. 
                        Berikut tips efektif untuk menghafal kedua aksara ini...
                    </p>
                    <div class="article-meta">
                        <span>📅 15 Des 2024</span>
                        <span>👤 Admin BANZAI</span>
                    </div>
                </div>
            </article>

            <article class="article-card" data-category="budaya">
                <img src="{{ asset('images/blog/placeholder.jpg') }}" alt="Article" class="article-image">
                <div class="article-content">
                    <span class="article-category" style="background: var(--plum-300);">Budaya</span>
                    <h2 class="article-title">Mengenal Tradisi Hanami di Jepang</h2>
                    <p class="article-excerpt">
                        Hanami adalah tradisi menikmati keindahan bunga sakura yang mekar di musim semi. 
                        Mari kita pelajari lebih dalam tentang tradisi ini...
                    </p>
                    <div class="article-meta">
                        <span>📅 10 Des 2024</span>
                        <span>👤 Divisi Budaya</span>
                    </div>
                </div>
            </article>

            <article class="article-card" data-category="event">
                <img src="{{ asset('images/blog/placeholder.jpg') }}" alt="Article" class="article-image">
                <div class="article-content">
                    <span class="article-category" style="background: var(--bahasa-cyan); color: white;">Event</span>
                    <h2 class="article-title">Recap: Festival Budaya Jepang 2024</h2>
                    <p class="article-excerpt">
                        Festival Budaya Jepang tahun ini sukses besar! Dengan berbagai kegiatan menarik 
                        seperti cosplay, origami, dan pertunjukan musik...
                    </p>
                    <div class="article-meta">
                        <span>📅 5 Des 2024</span>
                        <span>👤 Panitia Event</span>
                    </div>
                </div>
            </article>

            <article class="article-card" data-category="medsos">
                <img src="{{ asset('images/blog/placeholder.jpg') }}" alt="Article" class="article-image">
                <div class="article-content">
                    <span class="article-category" style="background: var(--medsos-amber); color: white;">Media Sosial</span>
                    <h2 class="article-title">Behind the Scenes: Konten Kreatif BANZAI</h2>
                    <p class="article-excerpt">
                        Bagaimana tim Media Sosial BANZAI membuat konten yang engaging? 
                        Simak proses kreatif di balik layar...
                    </p>
                    <div class="article-meta">
                        <span>📅 1 Des 2024</span>
                        <span>👤 Divisi Medsos</span>
                    </div>
                </div>
            </article>

            <article class="article-card" data-category="bahasa">
                <img src="{{ asset('images/blog/placeholder.jpg') }}" alt="Article" class="article-image">
                <div class="article-content">
                    <span class="article-category">Bahasa</span>
                    <h2 class="article-title">Perbedaan Keigo: Sonkeigo, Kenjougo, dan Teineigo</h2>
                    <p class="article-excerpt">
                        Bahasa Jepang memiliki tingkat kesopanan yang kompleks. 
                        Mari kita pelajari perbedaan antara Sonkeigo, Kenjougo, dan Teineigo...
                    </p>
                    <div class="article-meta">
                        <span>📅 25 Nov 2024</span>
                        <span>👤 Divisi Bahasa</span>
                    </div>
                </div>
            </article>

            <article class="article-card" data-category="budaya">
                <img src="{{ asset('images/blog/placeholder.jpg') }}" alt="Article" class="article-image">
                <div class="article-content">
                    <span class="article-category" style="background: var(--plum-300);">Budaya</span>
                    <h2 class="article-title">Filosofi Wabi-Sabi dalam Kehidupan Sehari-hari</h2>
                    <p class="article-excerpt">
                        Wabi-sabi adalah filosofi Jepang tentang menemukan keindahan dalam ketidaksempurnaan. 
                        Bagaimana kita bisa menerapkannya?
                    </p>
                    <div class="article-meta">
                        <span>📅 20 Nov 2024</span>
                        <span>👤 Divisi Budaya</span>
                    </div>
                </div>
            </article>
        </div>

        {{-- Pagination --}}
        <div style="text-align: center; margin-top: var(--space-6);">
            <div style="display: inline-flex; gap: var(--space-2);">
                <button class="btn btn-secondary">← Previous</button>
                <button class="btn btn-primary">1</button>
                <button class="btn btn-secondary">2</button>
                <button class="btn btn-secondary">3</button>
                <button class="btn btn-secondary">Next →</button>
            </div>
        </div>
    </div>
</section>

@push('scripts')
<script>
    // Simple category filter
    document.querySelectorAll('.category-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            // Update active state
            document.querySelectorAll('.category-btn').forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            
            const category = this.dataset.category;
            const articles = document.querySelectorAll('.article-card');
            
            articles.forEach(article => {
                if (category === 'all' || article.dataset.category === category) {
                    article.style.display = 'block';
                } else {
                    article.style.display = 'none';
                }
            });
        });
    });
</script>
@endpush
@endsection
