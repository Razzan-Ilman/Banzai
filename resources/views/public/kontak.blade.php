@extends('layouts.app')

@section('title', 'Kontak & FAQ')

@section('content')
<style>
    .contact-hero {
        background: linear-gradient(135deg, var(--indigo-900), var(--indigo-800));
        color: white;
        padding: var(--space-8) 0;
        text-align: center;
    }

    .contact-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: var(--space-6);
        margin: var(--space-6) 0;
    }

    .contact-card {
        background: white;
        padding: var(--space-6);
        border-radius: var(--radius-xl);
        box-shadow: var(--shadow-lg);
    }

    .social-links {
        display: flex;
        gap: var(--space-3);
        justify-content: center;
        margin-top: var(--space-4);
    }

    .social-link {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background: var(--ivory-200);
        color: var(--ink-800);
        font-size: 1.5rem;
        transition: all var(--transition-base);
    }

    .social-link:hover {
        background: var(--antique-gold);
        color: white;
        transform: translateY(-4px);
    }

    .faq-item {
        background: white;
        padding: var(--space-4);
        border-radius: var(--radius-lg);
        margin-bottom: var(--space-3);
        border-left: 3px solid var(--antique-gold);
    }

    .faq-question {
        font-weight: var(--fw-semibold);
        color: var(--ink-900);
        margin-bottom: var(--space-2);
        font-size: var(--h5);
    }

    .faq-answer {
        color: var(--ink-600);
        line-height: var(--lh-relaxed);
    }
</style>

<section class="contact-hero">
    <div class="container">
        <h1 style="font-size: var(--h1); margin-bottom: var(--space-2);">Hubungi Kami</h1>
        <p style="font-size: var(--body-large); opacity: 0.9;">
            Ada pertanyaan? Kami siap membantu!
        </p>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="contact-grid">
            <div class="contact-card">
                <h2 style="color: var(--antique-gold); margin-bottom: var(--space-4);">Informasi Kontak</h2>
                
                <div style="margin-bottom: var(--space-3);">
                    <p style="font-weight: var(--fw-semibold); color: var(--ink-800); margin-bottom: var(--space-1);">
                        📍 Lokasi
                    </p>
                    <p style="color: var(--ink-600);">
                        SMKN 13 Bandung<br>
                        Jl. Soekarno Hatta, Bandung
                    </p>
                </div>

                <div style="margin-bottom: var(--space-3);">
                    <p style="font-weight: var(--fw-semibold); color: var(--ink-800); margin-bottom: var(--space-1);">
                        📧 Email
                    </p>
                    <p style="color: var(--ink-600);">
                        banzai@smkn13bandung.sch.id
                    </p>
                </div>

                <div style="margin-bottom: var(--space-3);">
                    <p style="font-weight: var(--fw-semibold); color: var(--ink-800); margin-bottom: var(--space-1);">
                        ⏰ Jadwal Kegiatan
                    </p>
                    <p style="color: var(--ink-600);">
                        Setiap Rabu, 15:00 - 17:00 WIB
                    </p>
                </div>

                <div class="social-links">
                    <a href="#" class="social-link" title="Instagram">📷</a>
                    <a href="#" class="social-link" title="YouTube">📺</a>
                    <a href="#" class="social-link" title="WhatsApp">💬</a>
                </div>
            </div>

            <div class="contact-card">
                <h2 style="color: var(--antique-gold); margin-bottom: var(--space-4);">Kirim Pesan</h2>
                
                <form action="#" method="POST">
                    @csrf
                    <div class="input-group">
                        <label class="input-label">Nama</label>
                        <input type="text" name="name" class="input-field" required>
                    </div>

                    <div class="input-group">
                        <label class="input-label">Email</label>
                        <input type="email" name="email" class="input-field" required>
                    </div>

                    <div class="input-group">
                        <label class="input-label">Pesan</label>
                        <textarea name="message" class="input-field" rows="5" required></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary" style="width: 100%;">
                        Kirim Pesan
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>

<section class="section" style="background: var(--ivory-200);">
    <div class="container container-narrow">
        <h2 style="text-align: center; margin-bottom: var(--space-6);">Frequently Asked Questions</h2>

        <div class="faq-item">
            <p class="faq-question">Apakah harus punya dasar bahasa Jepang untuk bergabung?</p>
            <p class="faq-answer">
                Tidak! BANZAI menerima semua level, dari pemula hingga yang sudah mahir. 
                Kami memiliki program pembelajaran yang disesuaikan dengan kemampuan masing-masing anggota.
            </p>
        </div>

        <div class="faq-item">
            <p class="faq-question">Berapa biaya untuk bergabung dengan BANZAI?</p>
            <p class="faq-answer">
                BANZAI adalah ekstrakurikuler gratis untuk siswa SMKN 13 Bandung. 
                Namun, untuk beberapa kegiatan khusus mungkin ada biaya tambahan yang akan diinformasikan sebelumnya.
            </p>
        </div>

        <div class="faq-item">
            <p class="faq-question">Kegiatan apa saja yang dilakukan di BANZAI?</p>
            <p class="faq-answer">
                Kami memiliki berbagai kegiatan seperti pembelajaran bahasa (Divisi Bahasa), 
                pengenalan budaya Jepang (Divisi Budaya), dan pengelolaan media sosial (Divisi Medsos). 
                Selain itu, ada juga event-event khusus seperti festival budaya, kompetisi, dan lainnya.
            </p>
        </div>

        <div class="faq-item">
            <p class="faq-question">Bagaimana cara mendaftar?</p>
            <p class="faq-answer">
                Kamu bisa mendaftar melalui halaman <a href="{{ route('register') }}" style="color: var(--antique-gold); font-weight: var(--fw-semibold);">Pendaftaran</a> 
                di website ini. Isi formulir dengan lengkap, dan tim kami akan menghubungi kamu untuk proses selanjutnya.
            </p>
        </div>

        <div class="faq-item">
            <p class="faq-question">Apakah ada sertifikat setelah mengikuti BANZAI?</p>
            <p class="faq-answer">
                Ya! Anggota aktif akan mendapatkan sertifikat keikutsertaan di akhir tahun ajaran. 
                Selain itu, ada juga sistem medal dan achievement untuk anggota yang mencapai level tertentu.
            </p>
        </div>

        <div class="faq-item">
            <p class="faq-question">Apakah bisa bergabung di tengah semester?</p>
            <p class="faq-answer">
                Tentu saja! Kami menerima anggota baru kapan saja. Namun, untuk mendapatkan pengalaman maksimal, 
                lebih baik bergabung di awal semester agar bisa mengikuti program pembelajaran dari awal.
            </p>
        </div>
    </div>
</section>

<section class="section">
    <div class="container text-center">
        <h2 style="margin-bottom: var(--space-3);">Masih Ada Pertanyaan?</h2>
        <p style="max-width: 600px; margin: 0 auto var(--space-4); color: var(--ink-600);">
            Jangan ragu untuk menghubungi kami melalui form di atas atau media sosial kami
        </p>
        <a href="{{ route('register') }}" class="btn btn-primary btn-lg">
            Daftar Sekarang
        </a>
    </div>
</section>
@endsection
