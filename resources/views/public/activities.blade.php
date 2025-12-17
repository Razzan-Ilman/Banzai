@extends('layouts.app')

@section('title', 'Kegiatan')

@section('content')
    <!-- Page Header -->
    <header class="page-header">
        <div class="container">
            <h1 class="page-title brush-underline">Kegiatan BANZAI</h1>
            <p class="page-subtitle">Aktivitas dan program pembelajaran kami</p>
        </div>
    </header>

    <!-- Activities Grid -->
    <section class="section">
        <div class="section-container">
            @if($activities->count() > 0)
                <div class="activities-grid">
                    @foreach($activities as $activity)
                        <article class="activity-card">
                            <div class="activity-image">
                                @if($activity->image)
                                    <img src="{{ asset('storage/' . $activity->image) }}" alt="{{ $activity->title }}" style="width: 100%; height: 100%; object-fit: cover;">
                                @else
                                    🌸
                                @endif
                            </div>
                            <div class="activity-content">
                                <p class="activity-date">{{ $activity->formatted_date }}</p>
                                <h3 class="activity-title">{{ $activity->title }}</h3>
                                <p class="activity-description">{{ Str::limit($activity->description, 150) }}</p>
                                @if($activity->location)
                                    <p style="margin-top: var(--space-md); font-size: var(--text-sm); color: var(--neutral-500);">
                                        📍 {{ $activity->location }}
                                    </p>
                                @endif
                            </div>
                        </article>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div style="margin-top: var(--space-3xl); display: flex; justify-content: center;">
                    {{ $activities->links() }}
                </div>
            @else
                <!-- Poetic Empty State -->
                <div class="empty-state">
                    <p class="empty-state-text">Kegiatan sedang dipersiapkan dengan penuh semangat...</p>
                    <p style="margin-top: 1rem; font-size: 0.875rem; color: var(--neutral-400);">活動準備中</p>
                </div>
            @endif
        </div>
    </section>

    <!-- Photo Gallery Section -->
    <section class="section" style="background: linear-gradient(135deg, var(--primary-50), var(--neutral-50));">
        <div class="section-container">
            <div class="section-header" style="text-align: center; margin-bottom: var(--space-2xl);">
                <h2 style="font-size: var(--text-3xl); color: var(--primary-900); margin-bottom: var(--space-sm);">📸 Galeri Kegiatan</h2>
                <p style="color: var(--neutral-600);">Momen-momen berharga bersama BANZAI</p>
            </div>

            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: var(--space-lg);">
                @php
                    $activityPhotos = [
                        ['file' => 'Budaya-Cosplay.jpeg', 'title' => 'Budaya Cosplay', 'desc' => 'Penampilan cosplay anggota BANZAI'],
                        ['file' => 'Penampilan-1.jpeg', 'title' => 'Penampilan', 'desc' => 'Pertunjukan budaya Jepang'],
                        ['file' => 'Workshop.jpeg', 'title' => 'Workshop', 'desc' => 'Pelatihan dan pembelajaran'],
                        ['file' => 'Latihan-Gabungan.jpeg', 'title' => 'Latihan Gabungan', 'desc' => 'Latihan bersama antar divisi'],
                        ['file' => 'Perayaan.jpeg', 'title' => 'Perayaan', 'desc' => 'Perayaan hari besar Jepang'],
                        ['file' => 'Foto-Bersama.jpeg', 'title' => 'Foto Bersama', 'desc' => 'Kebersamaan keluarga BANZAI'],
                    ];
                @endphp

                @foreach($activityPhotos as $photo)
                    <div style="position: relative; border-radius: var(--radius-lg); overflow: hidden; box-shadow: var(--shadow-md); transition: all 0.3s ease; aspect-ratio: 4/3;">
                        <img src="{{ asset('images/activities/' . $photo['file']) }}" 
                             alt="{{ $photo['title'] }}" 
                             style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.5s ease;"
                             onmouseover="this.style.transform='scale(1.05)'" 
                             onmouseout="this.style.transform='scale(1)'">
                        <div style="position: absolute; bottom: 0; left: 0; right: 0; padding: var(--space-lg); background: linear-gradient(transparent, rgba(0,0,0,0.8)); color: white;">
                            <h4 style="font-size: var(--text-lg); margin-bottom: 0.25rem;">{{ $photo['title'] }}</h4>
                            <p style="font-size: var(--text-sm); opacity: 0.9;">{{ $photo['desc'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection
