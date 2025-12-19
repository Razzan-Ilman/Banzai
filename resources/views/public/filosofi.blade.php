@extends('layouts.app')

@section('title', 'Filosofi BANZAI')

@section('content')
<style>
    .filosofi-hero {
        min-height: 60vh;
        background: linear-gradient(160deg, var(--indigo-900), var(--indigo-800));
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        position: relative;
        overflow: hidden;
    }

    .kanji-large {
        font-family: 'Noto Sans JP', serif;
        font-size: clamp(4rem, 10vw, 8rem);
        font-weight: 700;
        margin-bottom: var(--space-4);
        opacity: 0.95;
    }

    .philosophy-card {
        background: white;
        border-radius: var(--radius-xl);
        padding: var(--space-6);
        box-shadow: var(--shadow-lg);
        margin-bottom: var(--space-4);
        border-left: 4px solid var(--antique-gold);
    }

    .quote-section {
        background: var(--ivory-200);
        padding: var(--space-6);
        border-radius: var(--radius-lg);
        font-style: italic;
        text-align: center;
        margin: var(--space-6) 0;
    }

    .value-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: var(--space-4);
        margin: var(--space-6) 0;
    }

    .value-card {
        background: white;
        padding: var(--space-4);
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-md);
        text-align: center;
        transition: transform var(--transition-base);
    }

    .value-card:hover {
        transform: translateY(-4px);
    }

    .value-icon {
        font-size: 3rem;
        margin-bottom: var(--space-2);
    }
</style>

<section class="filosofi-hero living-gradient light-play">
    <div class="container text-center">
        <p class="kanji-large">万歳</p>
        <h1 style="font-size: var(--h1); margin-bottom: var(--space-3);">Filosofi BANZAI</h1>
        <p style="font-size: var(--body-large); max-width: 600px; margin: 0 auto; opacity: 0.9;">
            Controlled Expression - Tenang tapi hidup, minimal tapi berlapis, elegan tapi berani
        </p>
    </div>
</section>

<section class="section">
    <div class="container container-narrow">
        <div class="philosophy-card">
            <h2 style="color: var(--antique-gold); margin-bottom: var(--space-3);">Apa itu BANZAI?</h2>
            <p style="line-height: var(--lh-relaxed); margin-bottom: var(--space-3);">
                BANZAI (万歳) adalah ekstrakurikuler Bahasa Jepang di SMKN 13 Bandung yang lebih dari sekadar tempat belajar bahasa. 
                Kami adalah ruang digital budaya - tempat di mana bahasa, budaya, dan ekspresi bertemu dalam harmoni yang terkontrol.
            </p>
            <p style="line-height: var(--lh-relaxed);">
                Nama "万歳" (Banzai) sendiri berarti "sepuluh ribu tahun" atau "hidup selamanya" - simbol harapan kami bahwa 
                pembelajaran bahasa dan budaya Jepang akan terus hidup dan berkembang di setiap generasi.
            </p>
        </div>

        <div class="quote-section">
            <p style="font-size: var(--h4); color: var(--ink-800); margin-bottom: var(--space-2);">
                "Jika satu elemen dihapus dan rasa BANZAI tidak berubah, berarti elemen itu tidak layak ada."
            </p>
            <p style="font-size: var(--body-small); color: var(--ink-500);">
                — Prinsip Controlled Expression
            </p>
        </div>

        <div class="philosophy-card">
            <h2 style="color: var(--antique-gold); margin-bottom: var(--space-3);">Controlled Expression</h2>
            <p style="line-height: var(--lh-relaxed); margin-bottom: var(--space-2);">
                Filosofi kami adalah <strong>"Controlled Expression"</strong> - ekspresi yang terkontrol. 
                Seperti seni kaligrafi Jepang yang setiap goresan memiliki makna, setiap elemen di BANZAI memiliki tujuan.
            </p>
            <ul style="line-height: var(--lh-relaxed); margin-left: var(--space-4);">
                <li><strong>Calm but Alive</strong> - Tenang tapi hidup, seperti taman Zen yang bernapas</li>
                <li><strong>Minimal but Layered</strong> - Sederhana di permukaan, kaya di kedalaman</li>
                <li><strong>Elegant but Bold</strong> - Elegan dalam eksekusi, berani dalam visi</li>
            </ul>
        </div>

        <h2 style="text-align: center; margin: var(--space-8) 0 var(--space-4); color: var(--ink-900);">
            Nilai-Nilai BANZAI
        </h2>

        <div class="value-grid">
            <div class="value-card">
                <div class="value-icon">🎌</div>
                <h3 style="color: var(--antique-gold); margin-bottom: var(--space-2);">Budaya</h3>
                <p style="color: var(--ink-600);">
                    Menghormati dan mempelajari budaya Jepang dengan mendalam dan autentik
                </p>
            </div>

            <div class="value-card">
                <div class="value-icon">📚</div>
                <h3 style="color: var(--antique-gold); margin-bottom: var(--space-2);">Pembelajaran</h3>
                <p style="color: var(--ink-600);">
                    Belajar bahasa bukan hanya kata, tapi konteks, nuansa, dan filosofi
                </p>
            </div>

            <div class="value-card">
                <div class="value-icon">🤝</div>
                <h3 style="color: var(--antique-gold); margin-bottom: var(--space-2);">Komunitas</h3>
                <p style="color: var(--ink-600);">
                    Membangun keluarga yang saling mendukung dalam perjalanan belajar
                </p>
            </div>

            <div class="value-card">
                <div class="value-icon">✨</div>
                <h3 style="color: var(--antique-gold); margin-bottom: var(--space-2);">Ekspresi</h3>
                <p style="color: var(--ink-600);">
                    Mengekspresikan diri melalui bahasa, seni, dan kreativitas
                </p>
            </div>
        </div>

        <div class="philosophy-card">
            <h2 style="color: var(--antique-gold); margin-bottom: var(--space-3);">Mengapa Bahasa Jepang?</h2>
            <p style="line-height: var(--lh-relaxed); margin-bottom: var(--space-2);">
                Bahasa Jepang bukan sekadar alat komunikasi - ia adalah jendela ke cara berpikir yang berbeda. 
                Melalui bahasa Jepang, kita belajar:
            </p>
            <ul style="line-height: var(--lh-relaxed); margin-left: var(--space-4);">
                <li><strong>Kesopanan dan Konteks</strong> - Memahami tingkat formalitas dan situasi</li>
                <li><strong>Ketelitian</strong> - Setiap karakter, setiap partikel memiliki makna</li>
                <li><strong>Estetika</strong> - Keindahan dalam kesederhanaan (wabi-sabi)</li>
                <li><strong>Harmoni</strong> - Keseimbangan antara individu dan kelompok (wa)</li>
            </ul>
        </div>

        <div style="text-align: center; margin: var(--space-8) 0;">
            <p style="font-family: 'Noto Sans JP', serif; font-size: var(--h3); color: var(--antique-gold); margin-bottom: var(--space-2);">
                学び続ける
            </p>
            <p style="color: var(--ink-600);">
                Manabi Tsuzukeru - Terus Belajar
            </p>
        </div>
    </div>
</section>

<section class="section" style="background: var(--ivory-200);">
    <div class="container text-center">
        <h2 style="margin-bottom: var(--space-4);">Bergabung dengan BANZAI</h2>
        <p style="max-width: 600px; margin: 0 auto var(--space-4); color: var(--ink-600);">
            Mulai perjalanan Anda dalam mempelajari bahasa dan budaya Jepang bersama kami
        </p>
        <a href="{{ route('register') }}" class="btn btn-primary btn-lg">
            Daftar Sekarang
        </a>
    </div>
</section>
@endsection
