@extends('layouts.member')

@section('title', 'Materi Belajar')

@section('content')
<div class="materials-page">
    <!-- Header -->
    <div class="page-header-section" style="margin-bottom: 2rem;">
        <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
            <div>
                <h2 style="font-size: 1.5rem; font-weight: 700; color: var(--ink-900); margin-bottom: 0.25rem;">📚 Materi Belajar</h2>
                <p style="color: var(--neutral-600); font-size: 0.875rem;">Pelajari bahasa dan budaya Jepang</p>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="card" style="margin-bottom: 1.5rem;">
        <div class="card-body" style="padding: 1rem;">
            <form action="{{ route('member.materials.index') }}" method="GET" style="display: flex; gap: 1rem; flex-wrap: wrap; align-items: center;">
                <div style="flex: 1; min-width: 200px;">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari materi..." 
                           style="width: 100%; padding: 0.5rem 1rem; border: 1px solid var(--neutral-300); border-radius: 8px;">
                </div>
                <select name="category" style="padding: 0.5rem 1rem; border: 1px solid var(--neutral-300); border-radius: 8px;">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat }}" {{ request('category') === $cat ? 'selected' : '' }}>
                            {{ ucfirst($cat) }}
                        </option>
                    @endforeach
                </select>
                <select name="difficulty" style="padding: 0.5rem 1rem; border: 1px solid var(--neutral-300); border-radius: 8px;">
                    <option value="">Semua Level</option>
                    <option value="beginner" {{ request('difficulty') === 'beginner' ? 'selected' : '' }}>Pemula</option>
                    <option value="intermediate" {{ request('difficulty') === 'intermediate' ? 'selected' : '' }}>Menengah</option>
                    <option value="advanced" {{ request('difficulty') === 'advanced' ? 'selected' : '' }}>Lanjutan</option>
                </select>
                <button type="submit" class="btn btn-primary">Filter</button>
            </form>
        </div>
    </div>

    <!-- Materials Grid -->
    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 1.5rem;">
        @forelse($materials as $material)
            @php
                $isCompleted = $userProgress[$material->id] ?? false;
                $typeIcon = match($material->type) {
                    'text' => '📄',
                    'video' => '🎬',
                    'pdf' => '📕',
                    'external' => '🔗',
                    default => '📚'
                };
                $difficultyColor = match($material->difficulty_level) {
                    'beginner' => '#10B981',
                    'intermediate' => '#F59E0B',
                    'advanced' => '#EF4444',
                    default => '#737373'
                };
            @endphp
            <div class="card" style="overflow: hidden; transition: transform 0.2s, box-shadow 0.2s; {{ $isCompleted ? 'border: 2px solid #10B981;' : '' }}">
                @if($material->thumbnail)
                    <div style="height: 150px; background: url('{{ asset('storage/' . $material->thumbnail) }}') center/cover; position: relative;">
                @else
                    <div style="height: 150px; background: linear-gradient(135deg, #667EEA, #764BA2); display: flex; align-items: center; justify-content: center; position: relative;">
                        <span style="font-size: 3rem;">{{ $typeIcon }}</span>
                @endif
                        @if($isCompleted)
                            <div style="position: absolute; top: 0.5rem; right: 0.5rem; background: #10B981; color: white; padding: 0.25rem 0.5rem; border-radius: 50px; font-size: 0.75rem;">
                                ✓ Selesai
                            </div>
                        @endif
                    </div>
                
                <div class="card-body">
                    <div style="display: flex; gap: 0.5rem; margin-bottom: 0.75rem;">
                        <span style="background: {{ $difficultyColor }}20; color: {{ $difficultyColor }}; padding: 0.125rem 0.5rem; border-radius: 50px; font-size: 0.75rem;">
                            {{ $material->difficulty_label }}
                        </span>
                        <span style="background: var(--neutral-100); color: var(--neutral-600); padding: 0.125rem 0.5rem; border-radius: 50px; font-size: 0.75rem;">
                            {{ $material->category_label }}
                        </span>
                    </div>
                    
                    <h3 style="font-size: 1rem; font-weight: 600; color: var(--ink-900); margin-bottom: 0.5rem; line-height: 1.4;">
                        {{ $material->title }}
                    </h3>
                    
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 1rem;">
                        <div style="display: flex; gap: 1rem; color: var(--neutral-500); font-size: 0.75rem;">
                            <span>{{ $typeIcon }} {{ $material->type_label }}</span>
                            @if($material->duration_minutes)
                                <span>⏱️ {{ $material->duration_minutes }} menit</span>
                            @endif
                        </div>
                        <a href="{{ route('member.materials.show', $material) }}" class="btn btn-sm btn-primary">
                            Buka
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="card" style="grid-column: 1 / -1; text-align: center; padding: 3rem;">
                <div style="font-size: 3rem; margin-bottom: 1rem;">📚</div>
                <h3 style="color: var(--ink-900); margin-bottom: 0.5rem;">Belum Ada Materi</h3>
                <p style="color: var(--neutral-500);">Materi belajar akan segera tersedia</p>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($materials->hasPages())
        <div style="margin-top: 2rem; display: flex; justify-content: center;">
            {{ $materials->withQueryString()->links() }}
        </div>
    @endif
</div>
@endsection
