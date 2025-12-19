@extends('layouts.app')

@section('title', 'Event BANZAI')

@section('content')
<style>
    .events-hero {
        background: linear-gradient(135deg, var(--indigo-900), var(--indigo-800));
        color: white;
        padding: var(--space-8) 0;
        text-align: center;
    }

    .event-tabs {
        display: flex;
        gap: var(--space-2);
        justify-content: center;
        margin: var(--space-4) 0;
        border-bottom: 2px solid var(--ivory-300);
    }

    .event-tab {
        padding: var(--space-3) var(--space-6);
        background: transparent;
        border: none;
        color: var(--ink-600);
        font-weight: var(--fw-semibold);
        cursor: pointer;
        position: relative;
        transition: color var(--transition-base);
    }

    .event-tab.active {
        color: var(--antique-gold);
    }

    .event-tab.active::after {
        content: '';
        position: absolute;
        bottom: -2px;
        left: 0;
        right: 0;
        height: 2px;
        background: var(--antique-gold);
    }

    .event-list {
        display: grid;
        gap: var(--space-4);
        margin: var(--space-6) 0;
    }

    .event-card {
        background: white;
        border-radius: var(--radius-xl);
        overflow: hidden;
        box-shadow: var(--shadow-lg);
        display: grid;
        grid-template-columns: 250px 1fr;
        transition: transform var(--transition-base);
    }

    .event-card:hover {
        transform: translateY(-4px);
    }

    .event-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        background: var(--ivory-300);
    }

    .event-details {
        padding: var(--space-4);
    }

    .event-date {
        display: inline-block;
        padding: var(--space-1) var(--space-3);
        background: var(--antique-gold);
        color: white;
        border-radius: var(--radius-full);
        font-size: var(--body-small);
        font-weight: var(--fw-semibold);
        margin-bottom: var(--space-2);
    }

    .event-title {
        font-size: var(--h3);
        color: var(--ink-900);
        margin-bottom: var(--space-2);
    }

    .event-description {
        color: var(--ink-600);
        line-height: var(--lh-relaxed);
        margin-bottom: var(--space-3);
    }

    .event-meta {
        display: flex;
        gap: var(--space-4);
        font-size: var(--body-small);
        color: var(--ink-500);
        margin-bottom: var(--space-3);
    }

    .event-status {
        display: inline-block;
        padding: var(--space-1) var(--space-2);
        border-radius: var(--radius-sm);
        font-size: var(--caption);
        font-weight: var(--fw-semibold);
    }

    .status-open {
        background: #DCFCE7;
        color: #166534;
    }

    .status-closed {
        background: #FEE2E2;
        color: #991B1B;
    }

    .status-finished {
        background: var(--ivory-300);
        color: var(--ink-600);
    }

    @media (max-width: 768px) {
        .event-card {
            grid-template-columns: 1fr;
        }
        
        .event-image {
            height: 200px;
        }
    }
</style>

<section class="events-hero">
    <div class="container">
        <h1 style="font-size: var(--h1); margin-bottom: var(--space-2);">Event BANZAI</h1>
        <p style="font-size: var(--body-large); opacity: 0.9;">
            Ikuti berbagai kegiatan seru dan edukatif bersama kami
        </p>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="event-tabs">
            <button class="event-tab active" data-tab="upcoming">Upcoming</button>
            <button class="event-tab" data-tab="past">Past Events</button>
        </div>

        {{-- Upcoming Events --}}
        <div class="event-list" id="upcoming-events">
            <div class="event-card">
                <img src="{{ asset('images/events/placeholder.jpg') }}" alt="Event" class="event-image">
                <div class="event-details">
                    <span class="event-date">📅 25 Desember 2024</span>
                    <h2 class="event-title">Festival Budaya Jepang 2024</h2>
                    <p class="event-description">
                        Festival tahunan BANZAI dengan berbagai kegiatan menarik seperti cosplay competition, 
                        origami workshop, Japanese food festival, dan pertunjukan musik tradisional Jepang.
                    </p>
                    <div class="event-meta">
                        <span>📍 Aula SMKN 13 Bandung</span>
                        <span>👥 Max 200 peserta</span>
                        <span>🎌 Semua divisi</span>
                    </div>
                    <div style="display: flex; gap: var(--space-2); align-items: center;">
                        <span class="event-status status-open">Pendaftaran Dibuka</span>
                        <a href="#" class="btn btn-primary">Daftar Sekarang</a>
                    </div>
                </div>
            </div>

            <div class="event-card">
                <img src="{{ asset('images/events/placeholder.jpg') }}" alt="Event" class="event-image">
                <div class="event-details">
                    <span class="event-date">📅 15 Januari 2025</span>
                    <h2 class="event-title">Workshop Kaligrafi Jepang (Shodo)</h2>
                    <p class="event-description">
                        Belajar seni kaligrafi Jepang dari instruktur berpengalaman. 
                        Peserta akan belajar teknik dasar menulis kanji dengan kuas dan tinta tradisional.
                    </p>
                    <div class="event-meta">
                        <span>📍 Ruang Seni SMKN 13</span>
                        <span>👥 Max 30 peserta</span>
                        <span>🎨 Divisi Budaya</span>
                    </div>
                    <div style="display: flex; gap: var(--space-2); align-items: center;">
                        <span class="event-status status-open">Pendaftaran Dibuka</span>
                        <a href="#" class="btn btn-primary">Daftar Sekarang</a>
                    </div>
                </div>
            </div>

            <div class="event-card">
                <img src="{{ asset('images/events/placeholder.jpg') }}" alt="Event" class="event-image">
                <div class="event-details">
                    <span class="event-date">📅 1 Februari 2025</span>
                    <h2 class="event-title">Japanese Speech Contest</h2>
                    <p class="event-description">
                        Kompetisi pidato bahasa Jepang untuk menguji kemampuan berbicara dan pemahaman bahasa. 
                        Terbuka untuk semua level dengan kategori pemula dan mahir.
                    </p>
                    <div class="event-meta">
                        <span>📍 Aula SMKN 13 Bandung</span>
                        <span>👥 Max 50 peserta</span>
                        <span>📚 Divisi Bahasa</span>
                    </div>
                    <div style="display: flex; gap: var(--space-2); align-items: center;">
                        <span class="event-status status-open">Pendaftaran Dibuka</span>
                        <a href="#" class="btn btn-primary">Daftar Sekarang</a>
                    </div>
                </div>
            </div>
        </div>

        {{-- Past Events --}}
        <div class="event-list" id="past-events" style="display: none;">
            <div class="event-card">
                <img src="{{ asset('images/events/placeholder.jpg') }}" alt="Event" class="event-image">
                <div class="event-details">
                    <span class="event-date">📅 10 November 2024</span>
                    <h2 class="event-title">Anime Movie Night</h2>
                    <p class="event-description">
                        Nobar film anime populer dengan subtitle bahasa Jepang. 
                        Kegiatan ini bertujuan untuk meningkatkan kemampuan listening sambil menikmati hiburan.
                    </p>
                    <div class="event-meta">
                        <span>📍 Ruang Multimedia</span>
                        <span>👥 80 peserta</span>
                        <span>🎬 Semua divisi</span>
                    </div>
                    <div>
                        <span class="event-status status-finished">Selesai</span>
                    </div>
                </div>
            </div>

            <div class="event-card">
                <img src="{{ asset('images/events/placeholder.jpg') }}" alt="Event" class="event-image">
                <div class="event-details">
                    <span class="event-date">📅 20 Oktober 2024</span>
                    <h2 class="event-title">Japanese Cooking Class: Onigiri & Takoyaki</h2>
                    <p class="event-description">
                        Workshop memasak makanan Jepang populer. Peserta belajar membuat onigiri dan takoyaki 
                        dari chef berpengalaman sambil mengenal budaya kuliner Jepang.
                    </p>
                    <div class="event-meta">
                        <span>📍 Lab Tata Boga</span>
                        <span>👥 25 peserta</span>
                        <span>🍱 Divisi Budaya</span>
                    </div>
                    <div>
                        <span class="event-status status-finished">Selesai</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section" style="background: var(--ivory-200);">
    <div class="container text-center">
        <h2 style="margin-bottom: var(--space-3);">Ingin Ikut Event Kami?</h2>
        <p style="max-width: 600px; margin: 0 auto var(--space-4); color: var(--ink-600);">
            Daftar sebagai anggota BANZAI untuk mendapatkan akses ke semua event dan kegiatan
        </p>
        <a href="{{ route('register') }}" class="btn btn-primary btn-lg">
            Daftar Sekarang
        </a>
    </div>
</section>

@push('scripts')
<script>
    // Tab switching
    document.querySelectorAll('.event-tab').forEach(tab => {
        tab.addEventListener('click', function() {
            // Update active state
            document.querySelectorAll('.event-tab').forEach(t => t.classList.remove('active'));
            this.classList.add('active');
            
            // Show/hide event lists
            const tabName = this.dataset.tab;
            document.getElementById('upcoming-events').style.display = tabName === 'upcoming' ? 'grid' : 'none';
            document.getElementById('past-events').style.display = tabName === 'past' ? 'grid' : 'none';
        });
    });
</script>
@endpush
@endsection
