@extends('layouts.member')

@section('title', $material->title)

@section('content')
<div class="material-show-page">
    <!-- Back Button -->
    <a href="{{ route('member.materials.index') }}" style="display: inline-flex; align-items: center; gap: 0.5rem; color: var(--neutral-600); text-decoration: none; margin-bottom: 1.5rem;">
        <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
        Kembali ke Materi
    </a>

    <div style="display: grid; grid-template-columns: 1fr 300px; gap: 2rem;">
        <!-- Main Content -->
        <div class="card">
            <div class="card-body" style="padding: 2rem;">
                <!-- Header -->
                <div style="margin-bottom: 2rem;">
                    @php
                        $difficultyColor = match($material->difficulty_level) {
                            'beginner' => '#10B981',
                            'intermediate' => '#F59E0B',
                            'advanced' => '#EF4444',
                            default => '#737373'
                        };
                    @endphp
                    <div style="display: flex; gap: 0.5rem; margin-bottom: 1rem;">
                        <span style="background: {{ $difficultyColor }}20; color: {{ $difficultyColor }}; padding: 0.25rem 0.75rem; border-radius: 50px; font-size: 0.875rem;">
                            {{ $material->difficulty_label }}
                        </span>
                        <span style="background: var(--neutral-100); color: var(--neutral-600); padding: 0.25rem 0.75rem; border-radius: 50px; font-size: 0.875rem;">
                            {{ $material->category_label }}
                        </span>
                    </div>
                    
                    <h1 style="font-size: 1.75rem; font-weight: 700; color: var(--ink-900); margin-bottom: 0.5rem;">
                        {{ $material->title }}
                    </h1>
                    
                    <div style="display: flex; gap: 1.5rem; color: var(--neutral-500); font-size: 0.875rem;">
                        <span>👁️ {{ number_format($material->views_count) }} views</span>
                        @if($material->duration_minutes)
                            <span>⏱️ {{ $material->duration_minutes }} menit</span>
                        @endif
                        <span>📅 {{ $material->created_at->format('d M Y') }}</span>
                    </div>
                </div>

                <!-- Content based on type -->
                @if($material->type === 'video')
                    <div style="position: relative; padding-bottom: 56.25%; height: 0; margin-bottom: 2rem; background: #000; border-radius: 12px; overflow: hidden;">
                        @if($material->external_url)
                            <iframe src="{{ $material->external_url }}" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;" frameborder="0" allowfullscreen></iframe>
                        @elseif($material->file_path)
                            <video controls style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;">
                                <source src="{{ asset('storage/' . $material->file_path) }}" type="video/mp4">
                            </video>
                        @endif
                    </div>
                @elseif($material->type === 'pdf')
                    <div style="margin-bottom: 2rem;">
                        <a href="{{ asset('storage/' . $material->file_path) }}" target="_blank" class="btn btn-primary" style="display: inline-flex; align-items: center; gap: 0.5rem;">
                            📥 Download PDF
                        </a>
                    </div>
                @elseif($material->type === 'external')
                    <div style="margin-bottom: 2rem;">
                        <a href="{{ $material->external_url }}" target="_blank" class="btn btn-primary" style="display: inline-flex; align-items: center; gap: 0.5rem;">
                            🔗 Buka Link Eksternal
                        </a>
                    </div>
                @endif

                <!-- Text Content -->
                @if($material->content)
                    <div class="material-content" style="line-height: 1.8; color: var(--ink-800);">
                        {!! nl2br(e($material->content)) !!}
                    </div>
                @endif
            </div>
        </div>

        <!-- Sidebar -->
        <div style="display: flex; flex-direction: column; gap: 1.5rem;">
            <!-- Progress Card -->
            <div class="card">
                <div class="card-body" style="text-align: center;">
                    @if($progress && $progress->is_completed)
                        <div style="font-size: 3rem; margin-bottom: 0.5rem;">✅</div>
                        <h3 style="color: #10B981; margin-bottom: 0.25rem;">Selesai!</h3>
                        <p style="font-size: 0.875rem; color: var(--neutral-500);">
                            {{ $progress->completed_at->format('d M Y') }}
                        </p>
                    @else
                        <div style="font-size: 3rem; margin-bottom: 0.5rem;">📖</div>
                        <h3 style="color: var(--ink-900); margin-bottom: 1rem;">Tandai Selesai</h3>
                        <form action="{{ route('member.materials.progress', $material) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-primary" style="width: 100%;">
                                ✓ Saya Sudah Belajar
                            </button>
                        </form>
                    @endif
                </div>
            </div>

            <!-- Author Card -->
            <div class="card">
                <div class="card-body">
                    <h4 style="font-size: 0.875rem; color: var(--neutral-500); margin-bottom: 0.75rem;">Dibuat oleh</h4>
                    <div style="display: flex; align-items: center; gap: 0.75rem;">
                        <div style="width: 40px; height: 40px; border-radius: 50%; background: linear-gradient(135deg, #EC4899, #F59E0B); display: flex; align-items: center; justify-content: center; color: white; font-weight: 600;">
                            {{ strtoupper(substr($material->creator->name ?? 'A', 0, 1)) }}
                        </div>
                        <div>
                            <div style="font-weight: 600; color: var(--ink-900);">{{ $material->creator->name ?? 'Admin' }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Related Materials -->
            @if($related->count() > 0)
                <div class="card">
                    <div class="card-body">
                        <h4 style="font-size: 0.875rem; color: var(--neutral-500); margin-bottom: 1rem;">Materi Terkait</h4>
                        <div style="display: flex; flex-direction: column; gap: 0.75rem;">
                            @foreach($related as $rel)
                                <a href="{{ route('member.materials.show', $rel) }}" style="display: block; padding: 0.75rem; background: var(--neutral-50); border-radius: 8px; text-decoration: none; transition: background 0.2s;">
                                    <div style="font-weight: 500; color: var(--ink-900); font-size: 0.875rem;">{{ $rel->title }}</div>
                                    <div style="font-size: 0.75rem; color: var(--neutral-500);">{{ $rel->category_label }}</div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<style>
    @media (max-width: 768px) {
        .material-show-page > div:last-child {
            grid-template-columns: 1fr !important;
        }
    }
</style>
@endsection
