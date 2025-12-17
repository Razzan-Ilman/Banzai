@extends('layouts.app')

@section('title', 'Galeri')

@section('content')
    <!-- Page Header -->
    <header class="page-header">
        <div class="container">
            <h1 class="page-title brush-underline">Galeri Dokumentasi</h1>
            <p class="page-subtitle">Momen-momen berharga kegiatan BANZAI</p>
        </div>
    </header>

    <!-- Gallery -->
    <section class="section">
        <div class="section-container">
            <!-- Poetic Empty State -->
            <div class="empty-state">
                <p class="empty-state-text">Momen-momen indah sedang dikumpulkan...</p>
                <p style="margin-top: 1rem; font-size: 0.875rem; color: var(--neutral-400);">思い出を集めています</p>
            </div>
        </div>
    </section>
@endsection
